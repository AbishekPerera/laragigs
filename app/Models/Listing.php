<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'title',
    //     'company',
    //     'description',
    //     'tags',
    //     'location',
    //     'website',
    //     'email',
    // ];

    public function scopeFilter($query, array $filters)
    {
        // dd($filters['tag']);
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }
        // dd($filters['search']);
        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
            ->orWhere('description', 'like', '%' . request('search') . '%')
            ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    // Relationship to user 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}