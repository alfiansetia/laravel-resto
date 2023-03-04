<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Comp;
use App\Models\Dtorder;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    protected $comp;

    public function __construct()
    {
        $this->comp = Comp::first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('dtorder', 'table', 'user')->get();
            if ($request->name) {
                $data = Order::where('name', 'like', "%{$request->name}%")->get();
            }
            return DataTables::of($data)->toJson();
        }
        return view('order.data')->with(['comp' => $this->comp, 'title' => 'Data Order']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:30',
            'table'     => 'required|integer',
            'category'  => 'required|in:dine in,take away',
            'desc'      => 'max:50',
        ]);
        // $cart = Cart::where('user_id', Auth::id())->with('menu')->get();
        $carts = Cart::with('menu')->where('user_id', '=', Auth::id())->get();
        $status = false;
        $message = '';
        $data = [];
        $fail = [];

        foreach ($carts as $cart) {
            if (($cart->menu->stock < $cart->qty) || $cart->menu->status == 'nonactive') {
                // $fail = $fail + 1;
                array_push($fail, $cart);
            }
        }

        if (count($fail) > 0) {
            return response()->json([
                'status'    => false,
                'message'   => count($fail) . ' Data tidak bisa diproses',
                'data'      => $fail,
            ]);
        }
        $order = Order::create([
            'name'      => $request->name,
            'table_id'  => $request->table,
            'user_id'   => Auth::id(),
            'category'  => $request->category,
            'date'      => date("Y-m-d H:i:s"),
            'status'    => 'paid',
            'desc'      => $request->desc,
        ]);
        $table = Table::find($request->table);
        $table->update([
            'status' => 'booked',
        ]);
        foreach ($carts as $cart) {
            Dtorder::create([
                'order_id'  => $order->id,
                'menu_id'   => $cart->menu_id,
                'price'     => $cart->menu->price,
                'disc'      => $cart->menu->disc,
                'qty'       => $cart->qty,
            ]);
            $menu = Menu::find($cart->menu_id);
            $menu->update([
                'stock' => $menu->stock - $cart->qty,
            ]);
        }

        foreach ($carts as $cart) {
            $cart->delete();
        }
        return response()->json([
            'status'    => true,
            'message'   => 'Transaksi berhasil',
            'data'      => [],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
