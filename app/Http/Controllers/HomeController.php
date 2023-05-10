<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Dtorder;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home')->with(['comp' => $this->comp, 'title' => 'Dashboard']);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data['total_user'] = User::count();
            $data['total_menu'] = Menu::count();
            $data['total_order_today'] = Order::whereDate('date', Carbon::today())->count();
            $data['total_sales_today'] = Order::whereDate('date', Carbon::today())->sum('total');
            $data['lost_menu'] = Menu::orderBy('stock')->limit(5)->get();
            $data['top_menu'] = Dtorder::select('menu.*', DB::raw('SUM(dtorder.qty) as total_sales'))
                ->join('menu', 'dtorder.menu_id', '=', 'menu.id')
                ->groupBy('menu.id', 'menu.name', 'menu.price', 'menu.disc', 'stock', 'img', 'menu.catmenu_id', 'menu.desc', 'menu.created_at', 'menu.updated_at')
                ->orderByDesc('total_sales')
                ->take(6)
                ->get();
            return response()->json(['status' => true, 'data' => $data, 'message' => '']);
        } else {
            abort(404);
        }
    }

    public function report(Request $request)
    {
        if ($request->ajax()) {
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now();
            // $endOfMonth = now()->lastOfMonth();
            // $data = Order::select(DB::raw('DATE(date) as date'), DB::raw('SUM(total) as total'))
            //     ->whereBetween('date', [$startOfMonth, $endOfMonth])
            //     ->groupBy(DB::raw('DATE(date)'))
            //     ->get();
            $data = [];
            for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
                $result = Order::select(DB::raw('SUM(total) as total'))
                    ->whereDate('date', $date->format('Y-m-d'))
                    ->first();
                $data[] = [
                    'date' => $date->format('Y-m-d'),
                    'total' => $result ? $result->total : 0,
                ];
            }
            return response()->json(['status' => true, 'data' => $data, 'message' => '']);
        } else {
            abort(404);
        }
    }
}
