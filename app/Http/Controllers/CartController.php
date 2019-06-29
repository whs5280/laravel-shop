<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Http\Requests\Request;
use App\Models\CartItem;
use App\Models\ProductSku;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    // 利用 Laravel 的自动解析功能注入 CartService 类
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(AddCartRequest $request)
    {
        $skuId = $request->input('sku_id');
        $amount = $request->input('amount');

        $this->cartService->add($skuId , $amount);

        return [];
    }


    public function index(Request $request)
    {
        $cartItems = $this->cartService->get();
        $addresses = $request->user()->addresses()->orderBy('last_used_at', 'desc')->get();

        return view('cart.index', ['cartItems' => $cartItems , 'addresses' => $addresses]);
    }


    public function remove(ProductSku $sku , Request $request)
    {
        $this->cartService->remove($sku->id);

        return [];
    }
}
