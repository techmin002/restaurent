<?php

namespace Modules\Expenses\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Modules\Expenses\Entities\ExpenseCategory;
use Illuminate\Support\Str;


class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $expenses = ExpenseCategory::orderBy('created_at','DESC')->with('branch')->get();
        $branches = Branch::where('status','on')->get();
        return view('expenses::category.index', compact('expenses','branches'));
    }
  
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('expenses::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $image = '';
        if($request->image)
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/expenses-category'), $image);
        }
        $slug = Str::slug($request->title);
        ExpenseCategory::create([
            'title' => $request->title,
            'slug' => $slug,
            'image' => $image,
            'branch_id' => $request->branch_id,
            'created_by' => auth()->user()->id,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return back()->with('success','Expense Category Added Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('expenses::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('expenses::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $cat = ExpenseCategory::findOrfail($id);
        $image = $cat->image;
        if($request->image)
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/expenses-category'), $image);
        }
        $slug = Str::slug($request->title);
        $cat->update([
            'title' => $request->title,
            'slug' => $slug,
            'image' => $image,
            'branch_id' => $request->branch_id,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return back()->with('success','Expense Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $categorys= ExpenseCategory::findOrfail($id);
        $categorys->delete();
        return redirect()->back()->with('success','Category Deleted!');
    }
    public function Status($id)
    {
        $categorys= ExpenseCategory::findOrfail($id);
        if($categorys->status == 'on')
        {
            $status ='off';
        }else{
            $status ='on';
        }
        $categorys->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success','Categgory Updated!');
    }
   
}
