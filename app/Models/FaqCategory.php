<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FaqCategory extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'slug',
            'order',
        ];

    protected $casts =
        [
            'order' => 'integer',
        ];

    public function questions()
    {
        return $this ->hasmany(FaqQuestion::class)
            ->orderBy('order');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeWithQuestions($query)
    {
        return $query->has('questions');
    }

    public function questionCount(): int
    {
        return $this->questions()->count();
    }


}
