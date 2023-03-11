<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Comp;
use App\Models\Dtorder;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $carts = Cart::with('menu')->where('user_id', Auth::id())->get();
        $fail = [];
        $total = 0;

        foreach ($carts as $cart) {
            if (($cart->menu->stock < $cart->qty) || $cart->menu->status == 'nonactive') {
                array_push($fail, $cart);
            }
            $total = $total + (($cart->qty * $cart->menu->price) - ($cart->menu->price * $cart->menu->disc / 100));
        }

        if (count($fail) > 0) {
            return response()->json([
                'status'    => false,
                'message'   => count($fail) . ' Menu tidak bisa diproses (kurang/habis)',
                'data'      => $fail,
            ]);
        }
        $this->validate($request, [
            'name'      => 'required|max:30',
            'category'  => 'required|in:dine in,take away',
            'table'     => 'required_if:category,==,dine in|integer|nullable',
            'bill'      => 'required|integer|gte:' . $total,
        ]);
        $last = Order::latest()->first() ?? new Order();
        $invnumber = 'INV' . date('ymd') . str_pad($last->id + 1, 5, "0", STR_PAD_LEFT);
        DB::beginTransaction();
        try {
            $order = Order::create([
                'number'    => $invnumber,
                'name'      => $request->name,
                'table_id'  => $request->table,
                'user_id'   => Auth::id(),
                'category'  => $request->category,
                'date'      => date("Y-m-d H:i:s"),
                'total'     => $total,
                'bill'      => $request->bill,
                'status'    => 'paid',
            ]);
            if ($request->category == 'dine in' && $request->has('table')) {
                $table = Table::find($request->table);
                $table->update([
                    'status' => 'booked',
                ]);
            }

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
                $cart->delete();
            }
            DB::commit();
            return response()->json([
                'status'    => true,
                'message'   => 'Transaksi berhasil',
                'data'      => [],
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status'    => false,
                'message'   => 'Transaksi Gagal',
                'data'      => [],
            ]);
        }
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

    public function lastfive(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('dtorder', 'table', 'user')->where('user_id', Auth::id())->latest()->take(5)->get();
            return DataTables::of($data)->toJson();
        } else {
            abort(404);
        }
    }

    public function print(Request $request, $number)
    {
        $order = Order::whereNumber($number)->with('dtorder.menu.catmenu')->first();
        if ($order) {
            $comp = $this->comp;
            $user = Auth::user();
            $img = $comp->logo;
            if ($comp->logo == '') {
                $img = 'logodefault.png';
            }
            $file = public_path("images/company/$img");
            $image = base64_encode(file_get_contents($file));
            if ($request->has('type') && $request->type == 'small') {
                return view('order.printsmall', compact(['order', 'user', 'image']))->with(['comp' => $this->comp]);
            } elseif ($request->has('type') && $request->type == 'pdf') {
                $pdf = Pdf::loadview('order.printsmall', ['order' => $order, 'user' => $user, 'comp' => $comp, 'image' => $image]);
                return $pdf->download($order->number . '_' . date('ymdHis') . '.pdf');
            } else {
                // return view('order.print', compact(['order', 'user']));
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function tes()
    {
        // return $pdf->download('sample.pdf');
        // $data = 'INV' . date('ymd') . str_pad(1 + 1, 5, "0", STR_PAD_LEFT);
        $data = date('d-m-Y H:i:s');
        return response()->json($data);
    }
}
