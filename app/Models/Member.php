<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function membershipCard()
    {
        return $this->hasOne(MembershipCard::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
