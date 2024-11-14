<?php

namespace Modules\Catalog\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Catalog\App\Models\Category;
use Modules\Catalog\App\Http\Requests\Category\CreateRequest;
use Modules\Catalog\App\Http\Requests\Category\UpdateRequest;
use Modules\Catalog\App\Http\Resources\CategoryResource;
use Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query()->select('id','name','image','active','created_at');


        if ($request->has('search')) {
            $query = $query->where('name','LIKE','%'.$request->get('search').'%');
        }

        $categories = CategoryResource::collection($query->paginate(6));

        return Inertia::render('Catalog::Categories/Index',[
            'categories' => $categories,
            'search' => $request->get('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Catalog::Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $Category = new Category();
        $Category->name = $request->name;
        $Category->active = $request->active;

        if ($request->hasFile('image')) {
            $Category->image = Storage::disk('public')->put('categories',$request->image);
        }

        $save = $Category->save();
        if ($save) {
            return redirect()->route('catalog.categories.index')->with('success','alerts.added_successfully');
        }
        return redirect()->route('catalog.categories.create')->with('error','alerts.added_error');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category = new CategoryResource(Category::find($category->id));

        return Inertia::render('Catalog::Categories/Edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->active = $request->active;

        if ($request->hasFile('image')) {
            $category->image = Storage::disk('public')->put('categories',$request->image);
        }

        $save = $category->save();
        if ($save) {
            return redirect()->route('catalog.categories.index')->with('success','alerts.edited_successfully');
        }

        return redirect()->route('catalog.categories.edit',$category->id)->with('error','alerts.edited_error');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $product->loadCount(['products']);

        if ($category->products_count > 0 ) 
            return redirect()->route('catalog.categories.index')->with('error','alerts.cannot_delete_category_error');

        $delete = $category->delete();
        if ($delete) {
            return redirect()->route('catalog.categories.index')->with('success','alerts.deleted_successfully');
        }

        return redirect()->route('catalog.categories.index')->with('error','alerts.deleted_error');
    }
}
