<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Restaurent\Models\RestaurentTable;
use Modules\Restaurent\Models\Section;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RestaurentTableController extends Controller
{
    protected $restaurent_id;

    public function __construct()
    {
        // Set the restaurent_id from authenticated user
        $this->middleware(function ($request, $next) {
            $this->restaurent_id = auth()->user()->restaurent_id;
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = RestaurentTable::where('restaurent_id', $this->restaurent_id)->with('section')->get();
        $sections = Section::where('restaurent_id', $this->restaurent_id)->get();
        return view('restaurent::tables.index', compact('tables', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurent::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_no' => ['required'],
            'capacity' => 'required'
        ]);
        $user = Auth::user();
        $table = new RestaurentTable();
        $table->table_number = $request['table_no'];
        $table->capacity = $request['capacity'];
        $table->restaurent_id = $user['restaurent_id'];
        $table->created_by = $user->id;
        $table->section_id = $request['section_id'] ?? null;
        $table->status = $request['status'] ?? 'on';
        $table->save();
        return back()->with('success', 'Table Created Successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('restaurent::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('restaurent::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'table_no' => ['required'],
        ]);
        $table = RestaurentTable::find($id);

        $user = Auth::user();
        $table->table_number = $request['table_no'];
        $table->capacity = $request['capacity'];
        $table->section_id = $request['section_id'] ?? null;
        $table->save();


        return back()->with('success', 'Section Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $table = RestaurentTable::find($id);
        $table->delete();
        return back()->with('success', 'Table Deleted Successfully');
    }
}
