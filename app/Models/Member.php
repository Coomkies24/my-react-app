<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function membershipCard()
    {
        return $this->hasOne(MembershipCard::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
