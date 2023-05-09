<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Dtreqstock;
use App\Models\Menu;
use App\Models\Menulog;
use App\Models\Reqstock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReqstockController extends Controller
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
            $data = Reqstock::where('number', 'like', "%{$request->number}%")->with('dtreqstock', 'user', 'stateby')->get();
            return DataTables::of($data)->toJson();
        }
        return view('reqstock.data')->with(['comp' => $this->comp, 'title' => 'Request Stock']);
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
            'desc'  => 'max:150',
            'menu'  => 'required|array|min:1',
        ]);
        $last = Reqstock::latest()->first() ?? new Reqstock();
        $reqnumber = 'REQ' . str_pad($last->id + 1, 5, "0", STR_PAD_LEFT);
        DB::beginTransaction();
        try {
            $req = Reqstock::create([
                'number'    => $reqnumber,
                'user_id'   => Auth::id(),
                'date'      => date("Y-m-d H:i:s"),
                'status'    => 'pending',
                'desc'      => $request->desc,
            ]);
            $menus = $request->menu;
            foreach ($menus as $menu) {
                Dtreqstock::create([
                    'reqstock_id'   => $req->id,
                    'menu_id'       => $menu['id'],
                    'type'          => $menu['type'],
                    'qty'           => $menu['qty'],
                ]);
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
     * @param  \App\Models\ReqStock  $reqStock
     * @return \Illuminate\Http\Response
     */
    public function show(ReqStock $reqStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReqStock  $reqStock
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Reqstock $reqstock)
    {
        if ($request->ajax()) {
            $reqstock = Reqstock::with('dtreqstock.menu', 'user', 'stateby')->find($reqstock->id);
            return response()->json(['status' => true, 'message' => '', 'data' => $reqstock]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reqstock  $reqstock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reqstock $reqstock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reqstock  $reqstock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reqstock $reqstock)
    {
        //
    }

    public function change(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|in:done,pending,cancel',
        ]);
        if ($request->ajax()) {
            $reqstock = Reqstock::with('dtreqstock')->find($id);
            DB::beginTransaction();
            try {
                if ($request->status == 'done') {
                    $menus = $reqstock->dtreqstock;
                    foreach ($menus as $m) {
                        if ($m->menu_id != null) {
                            $menu = Menu::find($m->menu_id);
                            if ($m->type == 'add') {
                                $menu->update(['stock' => ($menu->stock + $m->qty)]);
                            } elseif ($m->type == 'adjust') {
                                $menu->update(['stock' =>  $m->qty]);
                            }
                            Menulog::create([
                                'menu_id'   => $menu->id,
                                'user_id'   => Auth::id(),
                                'date'      => date("Y-m-d H:i:s"),
                                'message'   => 'stock : change on Request ' . $reqstock->number,
                            ]);
                        }
                    }
                }
                $reqstock->update([
                    'stateby_id' => Auth::id(),
                    'status'     => $request->status,
                    'date_state' => date("Y-m-d H:i:s"),
                ]);
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
        } else {
            abort(404);
        }
    }
}
