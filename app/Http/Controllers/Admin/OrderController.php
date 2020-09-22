<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 3:05 PM
 */

namespace App\Http\Controllers\Admin;


use App\Entity\Order;
use App\Entity\OrderBank;
use App\Entity\OrderCodeSale;
use App\Entity\OrderItem;
use App\Entity\OrderShip;
use App\Entity\SettingOrder;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });

    }
    
    public function setting() {
        
        $orderShips = OrderShip::get();
        $orderBanks = OrderBank::get();
        $orderCodeSales = OrderCodeSale::get();
        $settingOrder = SettingOrder::first();
        
        return view('admin.order.setting', compact('orderShips', 'orderBanks', 'orderCodeSales', 'settingOrder'));
    }
    public function updateSetting(Request $request) {
        $settingOrder = new SettingOrder();

        $settingOrder->delete();
        $settingOrder->insert([
            'point_to_currency' => $request->input('point_to_currency'),
            'currency_give_point' => $request->input('currency_give_point'),
        ]);

        return redirect(route('method_payment'));
    }
    public function updateBank(Request $request) {
        $orderBank = new OrderBank();
        $orderBank->insert([
            'name_bank' => $request->input('name_bank'),
            'number_bank' => $request->input('number_bank'),
            'manager_account' => $request->input('manager_account'),
            'branch' => $request->input('branch'),
        ]);

        return redirect(route('method_payment'));
    }
    public function updateCodeSale(Request $request) {
        $orderCodeSale = new OrderCodeSale();

        $discountStartEnd = $request->input('code_sale_start_end');
        $discountTime = explode('-', $discountStartEnd);
        $discountStart = new \DateTime($discountTime[0]);
        $discountEnd = new \DateTime($discountTime[1]);
        
        $orderCodeSale->insert([
            'code' => $request->input('code'),
            'method_sale' => $request->input('method_sale'),
            'sale' => $request->input('sale'),
            'start' =>  $discountStart,
            'end' => $discountEnd ,
            'many_use' => $request->input('many_use'),
        ]);

        return redirect(route('method_payment'));
    }
    public function updateShip(Request $request) {
        $orderShip =  new OrderShip();
        $orderShip->insert([
            'method_ship' => $request->input('method_ship'),
            'cost' => $request->input('cost'),
        ]);

        return redirect(route('method_payment'));
    }
    public function listOrder(Request $request) {
        $orders = Order::orderBy('created_at', 'desc')
            ->where('status', '>', 0);

        if (!empty($request->input('order_id'))) {
            $orders = $orders->where('order_id', 'like', '%'.$request->input('order_id').'%');
        }
        if (!empty($request->input('phone'))) {
            $orders = $orders->where('shipping_phone', 'like', '%'.$request->input('phone').'%');
        }
        if (!empty($request->input('email'))) {
            $orders = $orders->where('shipping_email', 'like', '%'.$request->input('email').'%');
        }
        if (!empty($request->input('name'))) {
            $orders = $orders->where('shipping_name', 'like', '%'.$request->input('name').'%');
        }
        if (!empty($request->input('user_id'))) {
            $orders = $orders->where('user_id', '=', $request->input('user_id'));
        }
        if ($request->input('is_search_time') == 1) {
            $startEnd = $request->input('search_start_end');
            $time = explode('-', $startEnd);
            $start = $time[0];
            $end = $time[1];

            $orders = $orders->where('updated_at', '>=', new \DateTime($start))
                ->where('updated_at', '<=', new \DateTime($end));
        }

        $orders = $orders->paginate(5);
        
        foreach($orders as $id => $order) {
            $orders[$id]->orderItems = OrderItem::join('products','products.product_id','=', 'order_items.product_id')
                ->join('posts', 'products.post_id','=','posts.post_id')
                ->select(
                    'posts.*',
                    'products.price',
                    'products.discount',
                    'products.code',
                    'order_items.*'
                )
                ->where('order_id', $order->order_id)->get();
        }

       return view('admin.order.list', compact('orders'));
    }
    public function updateStatusOrder(Request $request) {
        $orderId = $request->input('order_id');
        $status = $request->input('status');

        Order::where('order_id', $orderId)->update([
            'status' => $status
        ]);

        return redirect(route('orderAdmin'));
    }

    public function deleteOrder(Order $order) {
        // delete order item
        OrderItem::where('order_id', $order->order_id)->delete();

        $order->delete();

        return redirect(route('orderAdmin'));
    }
}
