<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'category', 'year', 'quantity', 'cover'];

    public function borrows() {
        return $this->hasMany(Borrow::class);
    }
    

    public function book()
{
    return $this->belongsTo(Book::class);
}

    
}
