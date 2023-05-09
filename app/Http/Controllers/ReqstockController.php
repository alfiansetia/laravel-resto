<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Dtreqstock;
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
            'menu'  => 'required|array|min:1'
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
    public function edit(ReqStock $reqStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReqStock  $reqStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReqStock $reqStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReqStock  $reqStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReqStock $reqStock)
    {
        //
    }
}
