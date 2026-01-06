<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileMessage extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'from_user_id',
            'to_user_id',
            'message',
            'is_read',
            'parent_id'
        ];
    protected $casts =
        [
            'is_read' => 'boolean',
        ];


    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function parent()
    {
        return $this->belongsTo(ProfileMessage::class, 'parent_id');
    }

    //antwoorden op het bericht zelf
    public function replies()
    {
        return $this->hasMany(ProfileMessage::class, 'parent_id');
    }
    //Weergeven van ongelezen berichten
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
    //scope voor de nieuwste berichten eerst
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
    //een scope voor specifieke user (als ontvanger)
    public function scopeForUser($query, int $userId)
    {
        return $query->where('to_user_id', $userId);
    }
    //Markeer een gelezen bericht
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
    //Tijd sinds bericht werd verzonden
    public function timeAgo(): string
    {
        return $this->created_at->diffForHumans();
    }

    //Bericht verkorten (voor notificaties)
    public function preview(int $length = 50): string
    {
        if (strlen($this->message) <= $length) {
            return $this->message;
        }

        return substr($this->message, 0, $length) . '...';
    }
    //Verwijderen van berichten door de user eigenaar
    public function canBeDeletedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // Ontvanger of admin kan verwijderen
        return $user->id === $this->from_user_id || $user->is_admin;
    }
}
