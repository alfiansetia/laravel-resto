<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $comp;

    public function __construct()
    {
        $this->middleware('auth');
        $this->comp = Comp::first();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('report.data')->with(['title' => 'Report', 'comp' => $this->comp]);
    }

    public function getData(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
        ]);
        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);
        $data = [];
        for ($date = $from; $date <= $to; $date->addDay()) {
            $result = Order::select(DB::raw('SUM(total) as total'))
                ->whereDate('date', $date->format('Y-m-d'))
                ->first();
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'total' => ($result ? $result->total : 0) ?? 0,
            ];
        }
        return response()->json(['status' => true, 'data' => $data, 'message' => '']);
    }

    public function perDate(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
        ]);
        $data = Order::whereDate('date', '=', Carbon::parse($request->date)->format('Y-m-d'))->get();
        return response()->json(['status' => true, 'data' => $data, 'message' => '']);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
