<?php

namespace App\Http\Controllers;

use App\Models\Comp;
use App\Models\Table;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $comp;

    public function __construct()
    {
        $this->comp = Comp::first();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Table::orderBy('number', 'ASC');
            if ($request->number) {
                $data = Table::where('number', 'like', "%{$request->number}%")->orderBy('number', 'ASC')->get();
            }
            return DataTables::of($data)->toJson();
        }
        return view('table.data')->with(['comp' => $this->comp, 'title' => 'Data Table']);
    }

    public function paginate(Request $request)
    {
        if ($request->ajax()) {
            $number = 20;
            if ($request->has('pageSize') && $request->pageSize != '') {
                $number = $request->pageSize;
            }
            $data = Table::orderBy('number', 'ASC')->paginate($number);
            return response()->json($data);
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
            'number'    => 'required|integer|min:1|max:1000|unique:table,number',
            'status'    => 'required|in:free,booked,nonactive',
        ]);
        $table = Table::create([
            'number'    => $request->number,
            'status'    => $request->status,
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
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Table $table)
    {
        if ($request->ajax()) {
            $table = Table::find($table->id);
            return response()->json(['status' => true, 'message' => '', 'data' => $table]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $this->validate($request, [
            'number'    => 'required|integer|min:1|max:1000|unique:table,number,' . $table->id,
            'status'    => 'required|in:free,booked,nonactive',
        ]);
        $table->update([
            'number'    => $request->number,
            'status'    => $request->status,
        ]);
        if ($table) {
            return response()->json(['status' => true, 'message' => 'Success Update Data', 'data' => '']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed Update Data', 'data' => '']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id) {
                $count = count($request->id);
                $counter = 0;
                foreach ($request->id as $id) {
                    $table = Table::findOrFail($id);
                    $table->delete();
                    if ($table) {
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
                'status'    => 'required|in:free,booked,nonactive',
            ]);
            if ($request->id) {
                $count = count($request->id);
                $counter = 0;
                foreach ($request->id as $id) {
                    $table = Table::findOrFail($id);
                    $table->update([
                        'status'    => $request->status,
                    ]);
                    if ($table) {
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
