<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Comp;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CartController extends Controller
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
        $carts = Cart::where('user_id', '=', Auth::user()->id)->WhereRelation('menu', 'stock', '<', 1)->orWhereRelation('menu', 'status', '=', 'nonactive')->get();
        if (count($carts) > 0) {
            foreach ($carts as $cart) {
                $cart->delete();
            }
        }
        if ($request->ajax()) {
            $data = Cart::with('user', 'menu')->get();
            if ($request->name) {
                $data = Cart::where('name', 'like', "%{$request->name}%")->get();
            }
            return DataTables::of($data)->toJson();
        }
        return view('cart.data')->with(['comp' => $this->comp, 'title' => 'New Order']);
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
            'menu'    => 'required|integer',
            'qty'     => 'required|integer',
            'desc'    => 'max:150',
        ]);
        // $cart = Cart::where('user_id', '=', Auth::user()->id)->whereRelation('menu', 'paid', '=', 0);
        $cart = Cart::where('user_id', '=', Auth::user()->id)->where('menu_id', '=', $request->menu)->first();
        $menu = Menu::find($request->menu);
        if ($cart) {
            if (($menu->stock < ($cart->qty + $request->qty)) || ($menu->status == 'nonactive')) {
                return response()->json(['status' => false, 'message' => 'Out of stock / Nonactive', 'data' => '']);
            } else {
                $cart->update([
                    'qty'       => $cart->qty + $request->qty,
                    'desc'      => $request->desc,
                ]);
            }
        } else {
            $cart = Cart::create([
                'user_id'   => Auth::user()->id,
                'menu_id'   => $request->menu,
                'qty'       => $request->qty,
                'desc'      => $request->desc,
            ]);
        }
        if ($cart) {
            return response()->json(['status' => true, 'message' => 'Success Insert Data', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed Insert Data', 'data' => '']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $this->validate($request, [
            'qty'   => 'required|integer|gt:0|lte:' . $cart->menu->stock,
        ]);
        $cart->update([
            'qty'  => $request->qty,
        ]);
        if ($cart) {
            return response()->json(['status' => true, 'message' => 'Success Update Data', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed Update Data', 'data' => '']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id) {
                $count = count($request->id);
                $counter = 0;
                foreach ($request->id as $id) {
                    $cart = Cart::findOrFail($id);
                    $cart->delete();
                    if ($cart) {
                        $counter = $counter + 1;
                    }
                }
                return response()->json(['status' => true, 'message' => 'Success Delete ' . $count . '/' . $counter . ' Data', 'data' => '']);
            } else {
                return response()->json(['status' => false, 'message' => 'No Selected Data', 'data' => '']);
            }
        } else {
            abort(404);
        }
    }
}
