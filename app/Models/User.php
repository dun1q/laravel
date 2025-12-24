<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Car;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{   
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
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
        ];
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Друзья которых я добавил
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends_users', 'user_id', 'friend_id')->withTimestamps();
    }

    // Друзья которые добавили меня
    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friends_users', 'friend_id', 'user_id')->withTimestamps();
    }
}
