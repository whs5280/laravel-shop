<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $order = $request->input('order', '');

        $builder = Product::query()->where('on_sale', true);

        if($search) {
            $like = '%'.$search.'%';
            $builder->where(function ($query) use ($like){
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereHas('skus', function ($query) use ($like) {
                        $query->where('title', 'like', $like)
                            ->orWhere('description', 'like', $like);
                    });
            });
        }

        if($order) {
            // 是否是以 _asc 或者 _desc 结尾
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                // 如果字符串的开头是这 3 个字符串之一，说明是一个合法的排序值
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    // 根据传入的排序值来构造排序参数
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }

        $products = $builder->paginate(12);

        return view('products.index', ['products' => $products ,
            'filters'  => [
                'search' => $search,
                'order'  => $order,
            ],
        ]);
    }


    public function show(Product $product , Request $request)
    {
        //判断商品是否上架
        if (!$product->on_sale){
            throw new InvalidRequestException('商品未上架');
        }

        $favored = false;
        $user = $request->user();
        if ($user){
            $favored = boolval($user->favoriteProducts()->find($product->id));
        }
        return view('products.show' , ['product' => $product , 'favored' => $favored]);
    }


    /*
     * 收藏商品
     */
    public function favor(Product $product , Request $request)
    {
        $user = $request->user();
        if ($user->favoriteProducts()->find($product->id)){
            return [];
        }

        $user->favoriteProducts()->attach($product);

        return [];
    }


    /*
     * 取消收藏
     */
    public function disfavor(Product $product , Request $request)
    {
        $user = $request->user();
        $user->favoriteProducts()->detach($product);

        return [];
    }
}
