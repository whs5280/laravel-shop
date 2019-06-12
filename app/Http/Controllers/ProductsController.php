<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::query()->where('on_sale', true)->paginate(12);

        return view('products.index', ['products' => $products]);
    }
}
