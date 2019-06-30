<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yansongda\Pay\Log;

class PaymentController extends Controller
{
    public function payByAlipay(Order $order , Request $request)
    {
        $this->authorize('own',$order);

        // 订单已支付或者已关闭
        if ($order->paid_at || $order->closed){
            throw new InvalidRequestException('订单状态不正确');
        }

        // 调用支付宝的网页支付
        return app('alipay')->web([
            'out_trade_no' => $order->no,   // 订单编号
            'total_amount' => $order->total_amount,   // 订单金额
            'subject' => '支付 Laravel Shop 的订单：'.$order->no,  // 订单标题
        ]);
    }


    // 前端回调页面
    public function alipayReturn()
    {
        try {
            app('alipay')->verify();
        }catch (\Exception $e){
            return view('pages.error', ['msg' => '数据不正确']);
        }

        return view('pages.success', ['msg' => '付款成功']);
    }


    // 服务器端回调
    public function alipayNotify()
    {
        // 校验输入参数
        $data = app('alipay')->verify();

        // 如果订单状态不是成功或者结束，则不走后续的逻辑
        if(!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
            return app('alipay')->success();
        }

        // 如果这笔订单的状态已经是已支付
        $order = Order::where('no', $data->out_trade_no)->first();
        if (!$order){
            return 'fail';
        }
        if ($order->paid_at){
            return app('alipay')->success();   // 返回数据给支付宝
        }

        $order->update([
            'paid_at'        => Carbon::now(), // 支付时间
            'payment_method' => 'alipay', // 支付方式
            'payment_no'     => $data->trade_no, // 支付宝订单号
        ]);
    }
}
