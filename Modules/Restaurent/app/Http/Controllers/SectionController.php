<?php

namespace Modules\Restaurent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Restaurent\Models\Section;

class SectionController extends Controller
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
        $sections = Section::where('restaurent_id',$this->restaurent_id)->get();
        return view('restaurent::sections.index', compact('sections'));
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
    public function store(Request $request) {
        $request->validate([
            'name' => ['required'],
        ]);
        $user = Auth::user();
         $employee = new Section();
        $employee->name = $request['name'];
        $employee->restaurent_id = $user['restaurent_id'];
        $employee->created_by =$user->id;
        $employee->status = $request['status'] ?? 'on';
        $employee->save();

        return back()->with('success', 'Section Created Successfully');
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
    public function update(Request $request, $id) {
         $request->validate([
            'name' => ['required'],
        ]);
        $section = Section::find($id);
        $user = Auth::user();
        $section->name = $request['name'];
        $section->save();

        return back()->with('success', 'Section Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $section = Section::find($id);
        $section->delete();
         return back()->with('success', 'Section Deleted Successfully');
    }
}
