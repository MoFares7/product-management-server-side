<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
      protected $fillable = ['name', 'type', 'description', 'price', 'image'];
 public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    use HasFactory;
}
