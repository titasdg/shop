<?php

namespace Modules\Order\Http\Controllers;

use Modules\Order\Entities\Order;
use Modules\Order\Entities\Customer;
use Modules\Order\Entities\OrderedProduct;
use Modules\Product\Entities\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $order = Customer::where('name', 'LIKE', "%$keyword%")
                ->orWhere('last_name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('order_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $order = \DB::table('customer')
            ->leftJoin('orders', 'customer.order_id', '=', 'orders.id')->select('customer.*','orders.status')
            ->latest()->paginate($perPage);
            /*$order = \DB::table('customer')->select('customer.name','customer.last_name','customer.email','customer.order_id')
            ->join('orders','orders.id','=','customer.order_id')
            ->latest()->paginate($perPage);*/
            //$order = Customer::latest()->paginate($perPage);
        }

        return view('admin.order.index', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        $requestData = $request->all();

        Order::create($requestData);

        return redirect('admin/order')->with('flash_message', 'Order added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $customer = Customer::where('order_id','LIKE',$id)->firstOrFail();

        //$orderedProducts = OrderedProduct::where('order_id','LIKE',$id)->get();
        $products = \DB::table('products')
            ->leftJoin('ordered_product', 'products.id', '=', 'ordered_product.product_id')->where('ordered_product.order_id','LIKE',$id)
            ->get();
        //Reikia pasiimti produktus is produktu lenteles pagal id uzsakytu produktu lenteleje
        return view('admin.order.show', compact(['order','customer','products']));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'email'
        ]);
        $requestData = $request->all();

        $order = Order::findOrFail($id);
        $order->update($requestData);

        return redirect('admin/order')->with('flash_message', 'Order updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Order::destroy($id);

        return redirect('admin/order')->with('flash_message', 'Order deleted!');
    }
}
