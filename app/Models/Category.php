<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded = [];

    protected $fillable = [
        'name_english',
        'name_bangla',
        'slug',
        'parent_id',
        'type',
        'meta_title',
        'meta_description',
        'descriptions',
        'home_status',
        'logo',
        'status',
    ];

    // public function childrenCategories(): HasMany
    // {
    //     return $this->hasMany(Category::class)->with('categories');
    // }

    // public function categories(): HasMany
    // {
    //     return $this->hasMany(Category::class);
    // }



    // public function descendants()
    // {
    //     return $this->childrenCategories()->with('descendants');
    // }



    // use Cviebrock\EloquentSluggable\Sluggable;

    // use Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name_english', // Replace with the attribute you want to use for the slug
            ],
        ];
    }

    public function getLink()
    {
        return url('categories/' . $this->slug);
    }



    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function descendants()
    {
        return $this->children()->with('descendants');
    }
    public function hasPagination($query, $request)
    {
        return $query->paginate($request->input('per_page', 10));
    }

    public function scopeFilter($query, $request)
    {
        $query->when($request->search ?? false, function ($query, $search) {
            $query->where('name_english', 'like', "%$search%")
                ->orWhere('parent_id', 'like', "%$search%");
        });

        return $query;
    }

    public function scopeFilterByName($query, $search)
    {
        return $query->where('name_english', 'like', '%' . $search . '%');
    }


    public function scopeFilterByNameBangla($query, $search)
    {
        return $query->where('name_bangla', 'like', '%' . $search . '%');
    }
}
