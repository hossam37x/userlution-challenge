<?php

namespace App\Http\Controllers;

use App\Filters\ProductsFilter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProductsFilter($request);
        $products = Product::query()->ageRestriction(Auth::user()?->age)->filter($filter)->paginate(15);
        return view('products.index', compact('products'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
