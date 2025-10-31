<?php

namespace Modules\Testimonial\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Testimonial\DataTables\TestimonialDataTable;
use Modules\Testimonial\Entities\Testimonial;
use Modules\Testimonial\Http\Requests\StoreTestimonialRequest;
use Modules\Testimonial\Http\Requests\UpdateTestimonialRequest;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('show_testimonials'), 403);
        $tests = Testimonial::latest()->get();

        return view('testimonial::testimonials.index',compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_testimonials'), 403);
        return view('testimonial::testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreTestimonialRequest $request)
    {
        $imageName = '';
        if ($request->image)
        {
            $imageName = time().'.'.$request->image->extension();

            $request->image->move(public_path('upload/images/testimonials'), $imageName);

        }
        Testimonial::create([
            'name' => $request['name'],
            'message' => $request['message'],
            'status' => $request['status'],
            'image' => $imageName
        ]);
        
        return redirect()->route('testimonials.index')->with('success','Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('testimonial::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_testimonials'), 403);
        $testimonial = Testimonial::findOrfail($id);
        return view('testimonial::testimonials.edit',compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateTestimonialRequest $request, $id)
    {

        $testimonial = Testimonial::findOrfail($id);
        $imageName = $testimonial->image;
        if ($request->image)
        {
            $imageName = time().'.'.$request->image->extension();

            $request->image->move(public_path('upload/images/testimonials'), $imageName);

        }

        $testimonial->update([
            'name' => $request['name'],
            'message' => $request['message'],
            'status' => $request['status'],
            'image' => $imageName
        ]);
        
        return redirect()->route('testimonials.index')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_testimonials'), 403);
        $testimonial = Testimonial::findOrfail($id);
        $testimonial->delete();
        
        return redirect()->route('testimonials.index')->with('success','Removed Successfully');
    }

    public function status($id)
    {
        abort_if(Gate::denies('access_testimonials'), 403);
        $testimonial = Testimonial::findOrfail($id);
        if($testimonial->status == 'on')
        {
            $status = 'off';
        }else{
            $status = 'on';
        }
        $testimonial->update([
           'status' => $status 
        ]);
        return redirect()->route('testimonials.index')->with('success', 'Status Updated Successfully');
    }
}
