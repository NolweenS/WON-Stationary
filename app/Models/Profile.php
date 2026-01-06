<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'birthday',
        'profile_photo',
        'about_me',

    ];

    protected $casts = [
        'birthday' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photoUrl()
    {
        if($this->profile_photo)
        {
            return asset('storage/'.$this->profile_photo);
        }
        return asset('images/default-avatar.png');
    }
    //We kunnen nagaan of het iemands verjaardag is
    public function isBirthday(): bool
    {
        if (!$this->birthday) {
            return false;
        }

        return $this->birthday->format('m-d') === now()->format('m-d');
    }

    public function nextBirthday()
    {
        if (!$this->birthday) {
            return null;
        }

        // Formatteer de datum naar dag en maand (12 januari)
        return $this->birthday->translatedFormat('d F');
    }

    //
    public function age()
    {
        if (!$this->birthday) {
            return null;
        }

        return $this->birthday->age;
    }

}
