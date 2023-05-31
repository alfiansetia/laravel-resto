<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Menu;
use App\Models\Menulog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
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
            $data = Menu::with('catmenu')->get();
            if ($request->name) {
                $data = Menu::where('name', 'like', "%{$request->name}%")->get();
            }
            return DataTables::of($data)->toJson();
        }
        return view('menu.data')->with(['comp' => $this->comp, 'title' => 'Data Menu']);
    }


    public function paginate(Request $request)
    {
        if ($request->ajax()) {
            $number = 20;
            if ($request->has('pageSize') && $request->pageSize != '') {
                $number = $request->pageSize;
            }
            $data = Menu::query()->with('catmenu');
            if ($request->has('category') && $request->category != '') {
                $data->where('catmenu_id', $request->category);
            }
            if ($request->has('stock') && $request->stock == 'available') {
                $data->where('stock', '>', 0);
            }
            if($request->filled('name')){
                $data->where('name', 'like', "%$request->name%");
            }
            $result = $data->paginate($number);
            return response()->json($result);
        } else {
            abort(404);
        }
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
            'name'      => 'required|max:25|min:3|unique:menu,name',
            'catmenu'   => 'required|integer',
            'img'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price'     => 'integer|gte:0',
            'disc'      => 'integer|gte:0',
            'desc'      => 'max:150',
        ]);
        $img = null;
        if ($files = $request->file('img')) {
            $destinationPath = 'images/menu/'; // upload path
            $img = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }
        $menu = Menu::create([
            'name'          => $request->name,
            'catmenu_id'    => $request->catmenu,
            'img'           => $img,
            'price'         => $request->price,
            'disc'          => $request->disc,
            'desc'          => $request->desc,
        ]);
        if ($menu) {
            return response()->json(['status' => true, 'message' => 'Success Insert Data', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed Insert Data', 'data' => '']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Menu $menu)
    {
        if ($request->ajax()) {
            $menu = Menu::with('catmenu', 'menulog.user:id,name')->find($menu->id);
            return response()->json(['status' => true, 'message' => '', 'data' => $menu]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:menu,name,' . $menu->id,
            'catmenu'   => 'required|integer',
            'img'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price'     => 'integer|gte:0',
            'disc'      => 'integer|gte:0',
            'desc'      => 'max:150',
        ]);
        $img = $menu->img;
        if ($files = $request->file('img')) {
            //delete old file
            File::delete('images/menu/' . $img);
            //insert new file
            $destinationPath = 'images/menu/'; // upload path
            $img = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $img);
        }
        if ($menu->disc != $request->disc || $menu->name != $request->name) {
            $message = '';
            if ($menu->disc != $request->disc) {
                $message .= "disc : $menu->disc => $request->disc ,";
            }
            if ($menu->name != $request->name) {
                $message .= "name : $menu->name => $request->name ,";
            }
            Menulog::create([
                'menu_id'   => $menu->id,
                'user_id'   => Auth::id(),
                'date'      => date("Y-m-d H:i:s"),
                'message'   => $message,
            ]);
        }
        $menu->update([
            'name'          => $request->name,
            'catmenu_id'    => $request->catmenu,
            'img'           => $img,
            'price'         => $request->price,
            'disc'          => $request->disc,
            'desc'          => $request->desc,
        ]);
        if ($menu) {
            return response()->json(['status' => true, 'message' => 'Success Update Data', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed Update Data', 'data' => '']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id) {
                $count = count($request->id);
                $counter = 0;
                foreach ($request->id as $id) {
                    $menu = Menu::findOrFail($id);
                    if ($menu->img != null) {
                        File::delete('images/menu/' . $menu->img);
                    }
                    $menu->delete();
                    if ($menu) {
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
