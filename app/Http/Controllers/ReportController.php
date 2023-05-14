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
            if (!auth()->user()->hasRole('admin')) {
                $result = Order::select(DB::raw('SUM(total) as total'))->where('user_id', auth()->user()->id)->whereDate('date', $date->format('Y-m-d'))->first();
            } else {
                $result = Order::select(DB::raw('SUM(total) as total'))->whereDate('date', $date->format('Y-m-d'))->first();
            }
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
        if (!auth()->user()->hasRole('admin')) {
            $data = Order::where('user_id', auth()->user()->id)->whereDate('date', '=', Carbon::parse($request->date)->format('Y-m-d'))->get();
        } else {
            $data = Order::whereDate('date', '=', Carbon::parse($request->date)->format('Y-m-d'))->get();
        }
        return response()->json(['status' => true, 'data' => $data, 'message' => '']);
    }

    public function user(Request $request)
    {
        return view('report.user')->with(['title' => 'Report Kasir', 'comp' => $this->comp]);
    }
}
