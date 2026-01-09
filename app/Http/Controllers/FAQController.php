<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use App\Models\FaqQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

//Gaat functioneren voor de FAQ categorie en de vragen
class FAQController extends Controller implements HasMiddleware
{
    //amdin middelware toevoegen
    public static function middleware(): array
    {
        return [
            new Middleware('admin', except: ['index']),
        ];
    }

    //FAQ overview voor het publiek
    public function index()
    {
        //Halen alle categorieën met hun vragen op
        $categories = FaqCategory::with(['questions' => function($query) {
            $query->orderBy('order');
        }])->ordered()->get();

        return view('faq.index', compact('categories'));
    }

    //admin overview
    public function categoriesIndex()
    {
        $categories = FaqCategory::withCount('questions')->ordered()->get();

        return view('faq.admin.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        return view('faq.admin.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:faq_categories|max:255',
            'order'=> 'nullable|integer|min:0',
        ],
        [
            'name.required' => 'Please enter a name.',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $originalSlug = $validated['slug'];
        $counter = 1;
        while (FaqCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }
        if (!isset($validated['order'])) {
            $validated['order'] = FaqCategory::max('order') + 1;
        }
        FaqCategory::create($validated);

        return redirect()
            ->route('faq.admin.categories.index')
            ->with('success', 'Categorie succesvol aangemaakt!');
    }

    public function categoriesEdit(FaqCategory $category)
    {
        return view('faq.admin.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, FaqCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validated['name'] !== $category->name) {
            $validated['slug'] = Str::slug($validated['name']);

            $originalSlug = $validated['slug'];
            $counter = 1;
            while (FaqCategory::where('slug', $validated['slug'])
                ->where('id', '!=', $category->id)
                ->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $category->update($validated);

        return redirect()
            ->route('faq.admin.categories.index')
            ->with('success', 'Categorie succesvol bijgewerkt!');
    }

    public function categoriesDestroy(FaqCategory $category)
    {
        if ($category->questions()->count() > 0) {
            return back()->with('error', 'Kan categorie niet verwijderen: er zijn nog vragen gekoppeld.');
        }

        $category->delete();

        return redirect()
            ->route('faq.admin.categories.index')
            ->with('success', 'Categorie succesvol verwijderd!');
    }

    //Question management voor de admin
    public function questionsIndex()
    {
        $questions = FaqQuestion::with('category')->ordered()->paginate(20);

        return view('faq.admin.questions.index', compact('questions'));
    }

    public function questionsCreate()
    {
        $categories = FaqCategory::ordered()->get();

        return view('faq.admin.questions.create', compact('categories'));
    }

    public function questionsStore(Request $request)
    {
        $validated = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
        ], [
            'faq_category_id.required' => 'Categorie is verplicht.',
            'faq_category_id.exists' => 'Geselecteerde categorie bestaat niet.',
            'question.required' => 'Vraag is verplicht.',
            'answer.required' => 'Antwoord is verplicht.',
        ]);

        if (!isset($validated['order'])) {
            $validated['order'] = FaqQuestion::where('faq_category_id', $validated['faq_category_id'])
                    ->max('order') + 1;
        }

        FaqQuestion::create($validated);

        return redirect()
            ->route('faq.admin.questions.index')
            ->with('success', 'Vraag succesvol aangemaakt!');
    }

    public function questionsEdit(FaqQuestion $question)
    {
        $categories = FaqCategory::ordered()->get();

        return view('faq.admin.questions.edit', compact('question', 'categories'));
    }

    public function questionsUpdate(Request $request, FaqQuestion $question)
    {
        $validated = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $question->update($validated);

        return redirect()
            ->route('faq.admin.questions.index')
            ->with('success', 'Vraag succesvol bijgewerkt!');
    }

    public function questionsDestroy(FaqQuestion $question)
    {
        $question->delete();

        return redirect()
            ->route('faq.admin.questions.index')
            ->with('success', 'Vraag succesvol verwijderd!');
    }


}
