<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
    ];

    public function order()
    {
    return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class)
            /*we gebruiken ook "withTrashed"" om ook de softdeletes
             te kunnen weergeven als een product verwijderd wordt*/
            ->withTrashed();
    }

    //We gaan de subtotaal berekenen voor een specifieke item
    public function subtotal():float
    {
        return $this->price*$this->quantity;
    }
    //We stellen de subtotaal vast
    public function formattedSubtotal():string
    {
     return '€'.number_format($this->subtotal(),2, ',', ',');
    }
    //We stellen de prijs per stuk vast
    public function formattedPrice(): string
    {
        return '€' . number_format($this->price, 2, ',', '.');
    }

    //Nakijken of een prij snog bestaat (niet soft deleted)
    public function  productExists(): bool
    {
        return $this->product()->withoutTrashed()->exists();
    }
}
