<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $guarded = ['id'];

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
