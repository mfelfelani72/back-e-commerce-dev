<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\CreateResponseMessage;
use Illuminate\Support\Facades\Validator;
use App\Models\Category\Categories;

class AdminCategoryController extends Controller
{

     /**
     * Display a listing of the resource.
     */
    public function categories()
    {
        $categories = Categories::Active()->get();

        return response()->json(CreateResponseMessage::Success("categories_returned", json_decode((json_encode([
            "categories" => $categories,
        ])))), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        Validator::make($request->all(), [

            'name' => 'required',
            'slug' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'icon' => 'required',
            
        ], [
            'name.required' => 'name_required',
            'slug.required' => 'slug_required',
            'meta_title.required' => 'meta_title_required',
            'meta_description.required' => 'meta_description_required',
            'icon.required' => 'icon_required',
         
        ])
            ->validate();

        $category = Categories::create(
            [
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'parent_id' => $request->parent_id,
                'featured_image' => $request->featured_image,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'color' => $request->color,
                'icon' => $request->icon,
                'order' => $request->order,
                'is_featured' => $request->is_featured,
                'posts_count' => 0,
                'status' => 'enable',
                // 'operator' => Auth::user()->id,
            ]
        );

         return response()->json(CreateResponseMessage::Success("category_created", json_decode((json_encode([
            "category" => $category,
            
        ])))), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
