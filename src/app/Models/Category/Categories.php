<?php

namespace App\Models\Category;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Categories extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "id",
        "name",
        "slug",
        "description",
        "parent_id",
        "featured_image",
        "meta_title",
        "meta_description",
        "color",
        "icon",
        "order",
        "is_featured",
        "posts_count",
        "status",
        "created_at",
        "updated_at",
        "deleted_a",
    ];
}
