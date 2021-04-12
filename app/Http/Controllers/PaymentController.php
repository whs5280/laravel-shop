<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
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

        // 获取支付方式；100为支付宝，200为微信
        $pay_method = $request->input('method', 100);

        // 订单已支付或者已关闭
        if ($order->paid_at || $order->closed){
            throw new InvalidRequestException('订单状态不正确');
        }

        switch ($pay_method) {
            case 100:
                // 调用支付宝的网页支付
                return app('alipay')->web([
                    'out_trade_no' => $order->no,   // 订单编号
                    'total_amount' => $order->total_amount,   // 订单金额
                    'subject' => '支付 Laravel Shop 的订单：'.$order->no,  // 订单标题
                ]);
            case 200:
                // 微信扫码
                return app('wechat_pay')->scan([
                    'out_trade_no' => $order->no,  // 商户订单流水号，与支付宝 out_trade_no 一样
                    'total_fee' => $order->total_amount * 100, // 与支付宝不同，微信支付的金额单位是分。
                    'body'      => '支付 Laravel Shop 的订单：'.$order->no, // 订单描述
                ]);
        }
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

        $this->afterPaid($order);
        return app('alipay')->success();
    }


    // 微信前端回调页面
    public function wechatNotify()
    {
        // 校验回调参数是否正确
        $data  = app('wechat_pay')->verify();
        // 找到对应的订单
        $order = Order::where('no', $data->out_trade_no)->first();
        // 订单不存在则告知微信支付
        if (!$order) {
            return 'fail';
        }
        // 订单已支付
        if ($order->paid_at) {
            // 告知微信支付此订单已处理
            return app('wechat_pay')->success();
        }

        // 将订单标记为已支付
        $order->update([
            'paid_at'        => Carbon::now(),
            'payment_method' => 'wechat',
            'payment_no'     => $data->transaction_id,
        ]);

        return app('wechat_pay')->success();
    }


    protected function afterPaid(Order $order)
    {
        event(new OrderPaid($order));
    }
}
