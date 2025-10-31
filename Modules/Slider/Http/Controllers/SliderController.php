<?php

namespace Modules\Slider\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Slider\DataTables\SliderDataTable;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Http\Requests\StoreSliderRequest;
use Modules\Slider\Http\Requests\UpdateSliderRequest;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('show_sliders'), 403);
        $sliders = Slider::latest()->get();

        return view('slider::sliders.index',compact("sliders"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_sliders'), 403);
        return view('slider::sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreSliderRequest $request)
    {
        abort_if(Gate::denies('create_sliders'), 403);
        $imageName = '';
        if ($request->image)
        {
            $imageName = time().'.'.$request->image->extension();

            $request->image->move(public_path('upload/images/sliders'), $imageName);

        }
        Slider::create([
            'title' => $request['title'],
            'link' => $request['link'],
            'short_description'=> $request['short_description'],
            'description'=> $request['description'],
            'status' => $request['status'],
            'image' => $imageName
        ]);
        
        return redirect()->route('sliders.index')->with('success','Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('slider::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_sliders'), 403);
        $slider = Slider::findOrfail($id);
        return view('slider::sliders.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateSliderRequest $request, $id)
    {
        abort_if(Gate::denies('edit_sliders'), 403);
        $slider = Slider::findOrfail($id);
        $imageName = $slider->image;
        if ($request->image)
        {
            $imageName = time().'.'.$request->image->extension();

            $request->image->move(public_path('upload/images/sliders'), $imageName);

        }
        $slider->update([
            'title' => $request['title'],
            'link' => $request['link'],
            'short_description'=> $request['short_description'],
            'description'=> $request['description'],
            'status' => $request['status'],
            'image' => $imageName
        ]);
        
        return redirect()->route('sliders.index')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_sliders'), 403);
        $slider = Slider::findOrfail($id);
        $slider->delete();
        
        return redirect()->route('sliders.index')->with('success','Removed Successfully');
    }

    public function status($id)
    {
        abort_if(Gate::denies('access_sliders'), 403);
        $slider = Slider::findOrfail($id);
        if($slider->status == 'on')
        {
            $status = 'off';
        }else{
            $status = 'on';
        }
        $slider->update([
           'status' => $status 
        ]);
        return redirect()->route('sliders.index')->with('success', 'Status Updated Successfully');
    }
}
