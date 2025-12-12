<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
   use HasFactory;

   protected $fillable = [
       'user_id',
       'product_id',
       'rating',
       'comment',
   ];

   // we gaaan type casting doen om ervoor te zorgen dat de de gegevens werkelijk een integer is (type safety)
    protected $casts = [
        'rating' => 'integer',
    ];
    //een review hoort bij een user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //Een review hoort bij een product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //We gaan een scope doen met alleen de minimale rating
    public function scopeMinRating($query,int $rating)
    {
        return $query->where('rating', '>=', $rating);
    }
    // Alleen reviews met comment
    public function scopeWithComment($query)
    {
        return $query->whereNotNull('comment');
    }
    //Check of de review positief is
    public function isPositive(): bool
    {
        return $this->rating >=4;
    }
    //Check of review negatief is
    public function isNegative(): bool
    {
        return $this->rating <=2;
    }

    // We gaan voor de overzicht een verkorte commentaar weergeven
    public function shortComment(?int $length=100): ?string
    {
        if(!$this->comment)
        {
            return null;
        }
        if (strlen($this->comment) <= $length) {
            return $this->comment;
        }
        return substr($this->comment,0,$length).'...';

    }

    //Tijd sinds review is geplaatst
    public function timeAgo():string
    {
        return $this->created_at->diffForHumans();
    }
}
