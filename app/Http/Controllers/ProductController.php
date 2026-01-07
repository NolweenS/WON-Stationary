<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;

/**
 * ProductController
 *
 * Handles product catalog and admin CRUD
 *
 */
class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // Pas de 'admin' middleware toe op alles, BEHALVE index en show
            new Middleware('admin', except: ['index', 'show']),
        ];
    }

    /**
     * Display product catalog (PUBLIC)
     */
    public function index(Request $request)
    {
        // Start de query met de categorie-relatie erbij
        $query = Product::with('category');

        // Categorie Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Zoekfunctie
        if ($request->filled('search')) {
            $search = $request->input('search');

            // Zoek in naam of beschrijving
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Producten ophalen met paginering
        $products = $query->latest()
            ->paginate(12)
            ->withQueryString();

        // Categorieën ophalen voor de dropdown
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show product detail (PUBLIC)
     */
    public function show(Product $product)
    {
        // Eager load relaties
        $product->load(['category', 'reviews.user']);

        // Related products (same category)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inStock() // Zorg dat deze scope bestaat in je Product model, anders weghalen
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show create product form (ADMIN)
     */
    public function create()
    {
        // Aangepast naar orderBy('name') voor veiligheid
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store new product (ADMIN)
     */
    public function store(Request $request)
    {
        // Validatie
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
        ], [
            'category_id.required' => 'Categorie is verplicht.',
            'name.required' => 'Productnaam is verplicht.',
            'description.required' => 'Beschrijving is verplicht.',
            'price.required' => 'Prijs is verplicht.',
            'price.numeric' => 'Prijs moet een getal zijn.',
            'stock.required' => 'Voorraad is verplicht.',
            'image.required' => 'Afbeelding is verplicht.',
            'image.image' => 'Bestand moet een afbeelding zijn.',
        ]);

        // Genereer slug
        $validated['slug'] = Str::slug($validated['name']);

        // Zorg voor unieke slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Upload afbeelding
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Set is_featured
        $validated['is_featured'] = $request->has('is_featured');

        // Create product
        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product succesvol aangemaakt!');
    }

    /**
     * Show edit product form (ADMIN)
     */
    public function edit(Product $product)
    {
        // Aangepast naar orderBy('name') voor veiligheid
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product (ADMIN)
     */
    public function update(Request $request, Product $product)
    {
        // Validatie
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
        ]);

        // Update slug als naam veranderd
        if ($validated['name'] !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']);

            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Product::where('slug', $validated['slug'])
                ->where('id', '!=', $product->id)
                ->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle nieuwe afbeelding
        if ($request->hasFile('image')) {
            // Verwijder oude afbeelding
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Set is_featured
        $validated['is_featured'] = $request->has('is_featured');

        // Update product
        $product->update($validated);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product succesvol bijgewerkt!');
    }

    /**
     * Delete product (ADMIN)
     */
    public function destroy(Product $product)
    {
        // Verwijder afbeelding
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Soft delete product
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product succesvol verwijderd!');
    }
}
