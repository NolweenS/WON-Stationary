<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    // Representeert product categorieen (Pens,Highlighters,..)
    use HasFactory, softDeletes;

    //Mass-assignable attributes
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image'
    ];
    // category heeft meerdere producten
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    //We gaan gaan door de categorien die wel producten hebben
    public function scopeWithProducts($query)
    {
        return $query->has('products');
    }
    //Sorteren op naam
    public function scopeOrderd($query)
    {
        return $query->orderBy('name', 'asc');
    }
    //We halen de category url image op
    public function imageUrl():string
    {
        if($this->image)
        {
            return asset('storage/' . $this->image);
        }
        return asset('images/default.png');
    }
    // De aantal producten bijhouden
    public function productCount(): int
    {
        return $this->products()->count();
    }
    // De voorraad van de producten per category
    public function inStockCount(): int
    {
        return $this->products()->where('stock', '>', 0)->count();
    }

}
