<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Reqstock;
use Illuminate\Http\Request;
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
        //
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
