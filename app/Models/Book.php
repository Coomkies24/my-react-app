<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // ADDED: Allow mass assignment for these specific columns
    protected $fillable = [
        'title',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}