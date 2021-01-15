<?php
/**
 * Created by PhpStorm.
 * User: CLF
 * Date: 2021/1/15
 * Time: 16:26
 */

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class CouponCodesController  extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('优惠券列表')
            ->body($this->grid());
    }

    protected function grid()
    {
        $grid = new Grid(new CouponCode());

        // 默认按创建时间倒序排序
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('id', 'ID')->sortable();
        $grid->column('name', '名称');
        $grid->column('type', '类型')->display(function ($value) {
            return CouponCode::$typeMap[$value];
        });
        $grid->description('描述');
        $grid->total('总量');
        $grid->used('已用');
        $grid->enabled('是否启用')->display(function($value) {
            return $value ? '是' : '否';
        });
        $grid->created_at('创建时间');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        return $grid;
    }
}