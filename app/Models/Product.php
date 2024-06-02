<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId', 'chapterId', 'categoryId', 'name', 'price', 'state', 'type', 'description', 'gallery', 'address', 'connectMethod'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapterId');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }
}
