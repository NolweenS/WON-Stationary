<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    Protected $fillable =
        [
            'name',
            'email',
            'subject',
            'message',
            'is_read',
        ];

    protected $casts =
        [
            'is_read' => 'boolean',
        ];

    //Alle ongelezen berichten opsommen
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    //Alleen gelezen berichten
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    //Nieuwste eerst
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    //Een scopa aanmaken om te zoeken per naam,amail, subkect, message
    public function scopeSearch($query, string $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
                ->orWhere('email', 'LIKE', "%{$term}%")
                ->orWhere('subject', 'LIKE', "%{$term}%")
                ->orWhere('message', 'LIKE', "%{$term}%");
        });
    }

    //Markeer het bericht als gelezen
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    //Markeer het bericht als ongelezen
    public function markAsUnread(): void
    {
        $this->update(['is_read' => false]);
    }

    // Tijd sinds het bericht werd ontvangen
    public function timeAgo(): string
    {
        return $this->created_at->diffForHumans();
    }

    //Voor de admin een verkorte bericht preview
    public function preview(int $length = 100): string
    {
        if (strlen($this->message) <= $length) {
            return $this->message;
        }

        return substr($this->message, 0, $length) . '...';
    }

    //Weergeven van aantal ongelezen berichten
    public static function unreadCount(): int
    {
        return self::unread()->count();
    }
}
