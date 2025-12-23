<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory,softDeletes;
    protected $table = 'news';
    protected $fillable =
        [
        'author_id',
            'title',
            'slug',
            'content',
            'image',
            'published_at',
    ];

    protected $casts =
        [
            'published_at' => 'datetime',
        ];
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    //De gepubliceerde nieuws weergeven
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }
    //Nieuwste nieuws eerst weergeven
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }
    //Nieuws zoeken door de titel en inhoud
    public function scopeSearch($query,string $term)
    {
        return $query->where('title', 'LIKE', "%$term%")
            ->orWhere('content', 'LIKE', "%$term%");
    }
    //nieuwsafbeelding aan de hand van de URL ophalen
    public function imageUrl():string
    {
     if($this->image)
     {
         return asset('storage/' . $this->image);
     }
     return asset('images/default.png');
    }

    //publicatie datum vaststellen
    public function formattedDate():string
    {
        return $this->published_at->locale('english')->isoFormat('D MMMM Y');
    }

    //Aantal dagen van publicatie weergeven
    public function timeAgo():string
    {
        return $this->published_at->diffForHumans();
    }

    //Nagaan of het nieuws gepubliceerd is
    public function isPublished():bool
    {
        return $this->published_at <= now();
    }

    //Nagaan of nieuws recent is (<7 dagen oud)
    public function isRecent(): bool
    {
        return $this->published_at->isAfter(now()->subDays(7));
    }
}
