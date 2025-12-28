<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller implements HasMiddleware
{

 //we gaan een middelware gebruiken van Laravel
    public static function middleware() : array
    {
    //We gaan een middelware definieren voor deze controller
        return [
            new Middleware('auth',except: ['index', 'show']),
        ];
    }
    //Een lijst van nieuws voor bezoekers weergeven
    public function index()
    {
        $newsItems = News::published()
            ->latest()
            ->paginate(10);
        return view('news.index', compact('newsItems'));
    }

    /**
     * Show the form for creating a new resource.
     * Admin kan nieuws toevoegen
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     * Admin gaat een nieuws in de databse kunnen opslagen
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ], [
            'title.required' => 'Titel is verplicht.',
            'content.required' => 'Inhoud is verplicht.',
            'image.required' => 'Afbeelding is verplicht.',
            'image.image' => 'Bestand moet een afbeelding zijn.',
            'image.max' => 'Afbeelding mag maximaal 2MB zijn.',
        ]);

        //slug maken uit de titel
        $validated['slug'] = Str::slug($validated['title']);
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (News::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }
        $validated['author_id'] = auth()->id();
        $validated['published_at'] = $validated['published_at'] ? $validated['published_at'] : now();
        News::create($validated);

        return redirect()
            ->route('news.index')
            ->with('success', 'Nieuws succesvol aangemaakt!');

    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $news->load('author');
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ],[
            'title.required' => 'Titel is verplicht.',
            'content.required' => 'Inhoud is verplicht.',
            'image.image' => 'Bestand moet een afbeelding zijn.',
            'image.max' => 'Afbeelding mag maximaal 2MB zijn.',
        ]);
        if($news ->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()
            ->route('news.show', $news)
            ->with('success', 'Nieuws succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //We gaan een soft delete voeren om niet alles definitief we te krijgen
        $news->delete();
        return redirect()
            ->route('news.index')
            ->with('success', 'Nieuws succesfully deleted!');
    }
}
