<?php

namespace Modules\Catalog\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Catalog\App\Models\Product;
use Modules\Catalog\App\Models\Category;
use Modules\Catalog\App\Http\Requests\Product\CreateRequest;
use Modules\Catalog\App\Http\Requests\Product\UpdateRequest;
use Modules\Catalog\App\Http\Resources\ProductResource;
use Modules\Catalog\App\Http\Resources\CategoryResource;
use Inertia\Inertia;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();


        if ($request->has('search')) {
            $query = $query->where('name','LIKE','%'.$request->get('search').'%');
        }

        $products = ProductResource::collection($query->with('category')->paginate(15));

        return Inertia::render('Catalog::Products/Index',[
            'products' => $products,
            'search' => $request->get('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('active',1)->get();
        return Inertia::render('Catalog::Products/Create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $Product = new Product();
        $Product->name = $request->name;
        $Product->active = $request->active;
        $Product->category_id = $request->category_id;
        $Product->price = $request->price;
        $Product->is_a_service = $request->is_a_service;
        $Product->unit = $request->unit;
        $Product->barcode = $request->barcode;

        if ($request->hasFile('image')) {
            $Product->image = Storage::disk('public')->put('products',$request->image);
        }

        $save = $Product->save();
        if ($save) {
            return redirect()->route('catalog.products.index')->with('success','alerts.added_successfully');
        }
        return redirect()->route('catalog.products.create')->with('error','alerts.added_error');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('active',1)->get();
        return Inertia::render('Catalog::Products/Edit', compact('categories','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $product->name = $request->name;
        $product->active = $request->active;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->is_a_service = $request->is_a_service;
        $product->unit = $request->unit;
        $product->barcode = $request->barcode;

        if ($request->hasFile('image')) {
            $product->image = Storage::disk('public')->put('products',$request->image);
        }

        $save = $product->save();
        if ($save) {
            return redirect()->route('catalog.products.index')->with('success','alerts.edited_successfully');
        }
        return redirect()->route('catalog.products.create')->with('error','alerts.edited_error');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->loadCount(['salesItems', 'purchaseItems']);
        if ($product->sales_items_count > 0 || $product->purchase_items_count > 0) 
            return redirect()->route('catalog.products.index')->with('error','alerts.cannot_delete_product_error');

        $delete = $product->delete();
        if ($delete) {
            return redirect()->route('catalog.products.index')->with('success','alerts.deleted_successfully');
        }

        return redirect()->route('catalog.products.index')->with('error','alerts.deleted_error');
    }
}
