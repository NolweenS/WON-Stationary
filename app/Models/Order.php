<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Laravel\Prompts\select;

class Order extends Model
{
    use HasFactory,softDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'status',
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_postal',
        'shipping_country',
        'shipping_phone',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'float',
    ];
    //eem order hort bij een user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    //We gaan filteren op status
    public function scopeStatus($query,string $status)
    {
        return $query->where('status', $status);
    }
    //De orders in behandeling
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    //Alleen de completed status
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    //De recente orders eerst
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    //Genereer een unieke order nummer aan de hand van Laravel Conventions
    public static function generateOrderNumber():string
    {
        $year = date('Y');
        $lastOrder = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        $number = $lastOrder ? ((int) substr($lastOrder->order_number, -5, ))+1:1;
        return 'WON-' . $year.'-'.str_pad($number, 5, '0', STR_PAD_LEFT);
    }
    // we gaan de prijs vaststellen
    public function formattedPrice():string
    {
        return '€'.number_format($this->total_price,2,',',',');
    }
    // We gaan nu een kleur aan de status maken voor het later gebruik im de UI
    //Tailwind CSS utility classes
    public function statusColor():string
    {
        return match($this->status)
        {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    //Totaal aantal items in de order
    public function totalItems():int
    {
        return $this->items->sum('quantity');
    }

    //Nakijken of de order geannuleerd kunnen worden
    public function canBeCancelled():bool
    {
        return $this->status==='pending';
    }
    //Annuleer de order
    //we gaan de status updaten en stock terug zetten
    public function cancel():void
    {
        if(!$this->canBeCancelled())
        {
            return;
        }
        foreach($this->items as $item)
        {
            if ($item->product) {
                $item->product->increaseStock($item->quantity);
            }
        }
        $this->update(['status'=>'cancelled']);
    }


}
