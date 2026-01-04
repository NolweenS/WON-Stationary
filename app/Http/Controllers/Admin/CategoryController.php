<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

/**
 * CategoryController (Admin)
 *
 * Admin management voor categorieën
 */
class CategoryController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin', except: ['index', 'show']),
        ];
    }

    /**
     * Display all categories (ADMIN)
     */
    public function index()
    {
        $categories = Category::withCount('products')->ordered()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store new category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Genereer slug
        $validated['slug'] = Str::slug($validated['name']);

        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Upload afbeelding
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categorie succesvol aangemaakt!');
    }

    /**
     * Show edit form
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update category
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update slug als naam veranderd
        if ($validated['name'] !== $category->name) {
            $validated['slug'] = Str::slug($validated['name']);

            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Category::where('slug', $validated['slug'])
                ->where('id', '!=', $category->id)
                ->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle nieuwe afbeelding
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categorie succesvol bijgewerkt!');
    }

    /**
     * Delete category
     */
    public function destroy(Category $category)
    {
        // Check of er producten zijn
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kan categorie niet verwijderen: er zijn nog producten gekoppeld.');
        }

        // Verwijder afbeelding
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categorie succesvol verwijderd!');
    }
}
