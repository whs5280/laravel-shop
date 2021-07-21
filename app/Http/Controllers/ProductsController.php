<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Category;
use App\Models\OrderItem;
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

        // 如果有传入 category_id 字段，并且在数据库中有对应的类目
        if ($request->input('category_id') && $category = Category::find($request->input('category_id'))) {
            // 如果这是一个父类目
            if ($category->is_directory) {
                // 则筛选出该父类目下所有子类目的商品
                $builder->whereHas('category', function ($query) use ($category) {
                    $query->where('path', 'like', $category->path.$category->id.'-%');
                });
            } else {
                // 如果这不是一个父类目，则直接筛选此类目下的商品
                $builder->where('category_id', $category->id);
            }
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
                // 等价于 isset($category) ? $category : null
            ],
            'category' => $category ?? null,
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

        $reviews = OrderItem::query()
            ->with(['order.user', 'productSku'])    // 预先加载关联关系
            ->where('product_id', $product->id)
            ->whereNotNull('reviewed_at') // 筛选出已评价的
            ->orderBy('reviewed_at', 'desc') // 按评价时间倒序
            ->limit(10) // 取出 10 条
            ->get();

        return view('products.show' , [
            'product' => $product ,
            'favored' => $favored ,
            'reviews' => $reviews
        ]);
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


    /*
     * 收藏列表
     */
    public function favorites(Request $request)
    {
        $products = $request->user()->favoriteProducts()->paginate(12);

        return view('products.favorites' , ['products' => $products]);
    }
}
