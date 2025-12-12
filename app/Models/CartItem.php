<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Driver\Session;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //cart items weergeven voor de huidige bezoeker
    public static function getCurrentCart()
    {
        if(auth()->check())
        {
            return self::where('user_id', auth()->id())
                ->with('product')
                ->get();
        }else
        {
         return self::where('session_id', Session::getid())
         ->with('product')
         ->get();
        }
    }
    /* wanneer de bezoeker een user account gaat willen vastleggen bij de cartitem gaat het hier
    samen gebracht worden na een succesvolle AuthController, door login/registratie*/
    public static function mergeGuestCart($userId)
    {
        $sessionId = Session:: getId();
        //zoekt naar de items van de bezoeker
        $guestItems = self::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->get();
        foreach ($guestItems as $guestItem) {
            //kijkt na of de user dit product al in de cart heeft
            $existingItem = self::where('user_id', $userId)
                ->where('product_id', $guestItem->product_id)
                ->first();
            if ($existingItem) {
                //product zit al in de cart-> tel de aantallen bij elkaar
                $existingItem->quantity += $guestItems->quantity;
                $existingItem->save();
                $guestItem->delete();
            } else {
                //Als het prodcut nog niet in de user cart lig-> update de rij
                $guestItem->user_id = $userId;
                $guestItem->session_id = null;
                $guestItem->save();
            }
        }
    }

    //Aantal items in cart bepalen
    public static function cartCount():int
    {
        if(auth()->check())
        {
            return self ::where('user_id', auth()->id())->sum('quantity');
        }else
        {
         return self::where('session_id', Session::getId())->sum('quantity');
        }
    }

    //Totaal bedrag van de cart bepalen
    public static function cartTotal():float
    {
        $cartItems = self::getCurrentCart();
        return $cartItems->sum(function($item)
        {
          return $item->product->price * $item->quantity;
        });
    }

    //Berekenen de subtotaal voor deze cart item
    public function subtotal(): float
    {
        return $this->product->price * $this->quantity;
    }

    //we stellen de prijs vast
    public function formattedSubtotal(): string
    {
        return '€' . number_format($this->subtotal(), 2, ',', '.');
    }

    //Nagaan of er voldoende voorraad beschikbaar is
    public function hasEnoughStock(): bool
    {
        return $this->product->stock >= $this->quantity;
    }

    //Op basis van de voorraad gaan er een aantal maximum producten worden toegevoegd
    public function maxQuantity(): int
    {
        return $this->product->stock;
    }
}
