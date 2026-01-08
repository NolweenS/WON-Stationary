<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class User extends Authenticatable
{

    // we gebruiken hun functies
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *Worden niet getoond in JSON/API responses
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // AANGEPAST: Dit was 'is-admin', maar moet matchen met je database kolom
        ];
    }
    //We gaan de relaties voor de website opstellen

    // Een user heeft een profiel
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    //Een user heeft veel Bestellingen
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    //Een user schrijft veel comments bi een review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    //Een user heeft een winkelmandje met meerdere items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    //Een wishlist kan meerdere producten bevattem
    public function wishlist()
    {
        return $this->belongsToMany(Product::class,'wishlists')
            ->withTimestamps();
    }
    //Favorieten met meerdere producten
    public function favorites()
    {
        return $this->belongsToMany(Product::class,'user_favorites')
            ->withTimestamps();
    }

    public function wishlists()
    {
        return $this->belongsToMany(Product::class, 'wishlists');
    }
    public function newsArticles()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    // --- BERICHTEN SYSTEEM ---

    public function sentMessages()
    {
        return $this->hasMany(ProfileMessage::class, 'from_user_id');
    }

    // Dit haalt ALLES op (inclusief antwoorden), handig voor tellers
    public function receivedMessages()
    {
        return $this->hasMany(ProfileMessage::class, 'to_user_id');
    }

    // Het haalt alleen de HOOFDBERICHTEN op (dus geen antwoorden).
    public function profileMessages()
    {
        return $this->hasMany(ProfileMessage::class, 'to_user_id')
            ->whereNull('parent_id')
            ->latest();
    }

    // We moeten na kijken of de user admin is
    public function isAdmin()
    {
        return $this->is_admin;
    }

    //We kijken na of een bepaalde product ind e wishlist staat
    public function hasInWishlist(Product $product): bool
    {
        return $this->wishlist->contains($product);
    }

    //We kijken na of de producten in favorites staat
    public function hasInFavorites(Product $product):bool
    {
        return $this->favorites
            ->contains($product);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }
}
