<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FaqQuestion extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'faq_category_id',
            'question',
            'answer',
            'order',
        ];

    protected $casts =
        [
            'order' => 'integer',
        ];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('question', 'LIKE', "%{$term}%")
            ->orWhere('answer', 'LIKE', "%{$term}%");
    }

    public function scopeForCategory($query, int $categoryId)
    {
        return $query->where('faq_category_id', $categoryId);
    }

    // Het vraag verkorten
    public function shortQuestion(int $length = 80): string
    {
        if (strlen($this->question) <= $length) {
            return $this->question;
        }

        return substr($this->question, 0, $length) . '...';
    }
}
