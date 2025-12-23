<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_featured' => 'boolean',
    ];

    //Product hoort bij een categorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    //Heeft beel reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    //zit in meerdere order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    //In welke wishlists staan de prodcuten
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists')
            ->withTimestamps();
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'user_favorites')
            ->withTimestamps();
    }

    //Alleen producten met voorraad
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    //Zoeken van producten
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'LIKE', "%{$term}%")
            ->orWhere('description', 'LIKE', "%{$term}%");
    }

    public function imageUrl(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('images/no-product-image.png');
    }
    public function formattedPrice(): string
    {
        return '€' . number_format($this->price, 2, ',', '.');
    }
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }
    public function isLowStock(): bool
    {
        return $this->stock > 0 && $this->stock < 5;
    }

    //We gaan de gemiddelde berekenen voor een review score
    //In de controllers en View aan passen
    public function avarageRating(int $decimals = 1):float
    {
        $score = $this->getAttribute('reviews_avg_rating');
        if ($score === null) {
            $score = $this->reviews()->avg('rating');
        }
        return round($score ?? 0, $decimals);
    }

    //hoeveelkeer werd een product verkoct
    public function timesSold(): int
    {
        return $this->orderItems()->sum('quantity');
    }

    //Een vermindering aan voorraad tonen
    public function decreaseStock(int $quantity): void
    {
        $this->decrement('stock', $quantity);
    }

    public function increaseStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }
}
