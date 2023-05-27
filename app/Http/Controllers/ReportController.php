<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
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
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
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
            'date' => 'required|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
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

    public function data(Request $request)
    {
        $this->validate($request, [
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d',
        ]);
        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to)->addDay();

        $data = Order::select('user_id', DB::raw('SUM(total) as total'))
            ->groupBy('user_id')
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->with('user')
            ->get();
        return response()->json(['status' => true, 'data' => $data, 'message' => '']);
    }

    public function peruser(Request $request)
    {
        $this->validate($request, [
            'user'  => 'required|integer',
            'from'  => 'required|date_format:Y-m-d',
            'to'    => 'required|date_format:Y-m-d',
        ]);
        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to)->addDay();

        $data = Order::whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->where('user_id', $request->user)
            ->with('user')
            ->get();
        return response()->json(['status' => true, 'data' => $data, 'message' => '']);
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
        ]);
        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);
        $comp = $this->comp;
        $param['from'] = $request->from;
        $param['to'] = $request->to;
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
        $image = public_path('images/company/' . ($comp->getRawOriginal('logo') ?? 'default/logo.png'));
        $view = 'report.export_user';
        if (auth()->user()->hasRole('admin')) {
            $view = 'report.export';
        }
        $pdf = Pdf::loadview($view, [
            'data' => $data,
            'param' => $param,
            'comp' => $comp,
            'image' => $image,
            'title' => 'Report',
        ]);
        return $pdf->download('report_' . $request->from . '_' . $request->to . '.pdf');
    }
}
