<?php

namespace App\Http\Controllers;

use App\Models\Catmenu;
use App\Models\Comp;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CatmenuController extends Controller
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
            $data = Catmenu::get();
            // if ($request->email) {
            //     $data = User::Table('email', 'like', "%{$request->email}%")->get();
            // }
            return DataTables::of($data)->toJson();
        }
        return view('catmenu.data')->with(['comp' => $this->comp, 'title' => 'Data Category']);
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
            'name'      => 'required|max:25|min:3|unique:catmenu,name',
            'status'    => 'required|in:active,nonactive',
            'desc'      => 'max:150',
        ]);
        $table = Catmenu::create([
            'name'      => $request->name,
            'status'    => $request->status,
            'desc'      => $request->desc,
        ]);
        if ($table) {
            return response()->json(['status' => true, 'message' => 'Success Insert Data', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed Insert Data', 'data' => '']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catmenu  $catmenu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Catmenu $catmenu)
    {
        //
        if ($request->ajax()) {
            return response()->json(['status' => true, 'message' => '', 'data' => $catmenu]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catmenu  $catmenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catmenu $catmenu)
    {
        $this->validate($request, [
            'name'      => 'required|max:25|min:3|unique:catmenu,name,' . $catmenu->id,
            'status'    => 'required|in:active,nonactive',
            'desc'      => 'max:150',
        ]);
        $catmenu->update([
            'name'      => $request->name,
            'status'    => $request->status,
            'desc'      => $request->desc,
        ]);
        if ($catmenu) {
            return response()->json(['status' => true, 'message' => 'Success Update Data', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed Update Data', 'data' => '']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catmenu  $catmenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id) {
                $count = count($request->id);
                $counter = 0;
                foreach ($request->id as $id) {
                    $catmenu = Catmenu::findOrFail($id);
                    $catmenu->delete();
                    if ($catmenu) {
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

    public function change(Request $request)
    {
        if ($request->ajax()) {
            $this->validate($request, [
                'status'    => 'required|in:active,nonactive',
            ]);
            if ($request->id) {
                $count = count($request->id);
                $counter = 0;
                foreach ($request->id as $id) {
                    $catmenu = Catmenu::findOrFail($id);
                    $catmenu->update([
                        'status'    => $request->status,
                    ]);
                    if ($catmenu) {
                        $counter = $counter + 1;
                    }
                }
                return response()->json(['status' => true, 'message' => 'Success Change Status ' . $count . '/' . $counter . ' Data', 'data' => '']);
            } else {
                return response()->json(['status' => false, 'message' => 'No Selected Data', 'data' => '']);
            }
        } else {
            abort(404);
        }
    }
}
