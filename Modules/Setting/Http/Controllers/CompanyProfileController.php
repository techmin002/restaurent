<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Setting\Entities\CompanyProfile;
use Modules\Setting\Entities\WhyUs;
use Modules\Setting\Entities\Feature;
use Modules\Setting\Entities\Plan;
use Modules\Setting\Entities\askedQuestions;
use Modules\Setting\Entities\customerSays;
use Modules\Setting\Entities\Interfaces;
use Modules\Setting\Entities\ContactMessage;
use App\Models\Video;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('access_settings'), 403);
        $profile = CompanyProfile::first();

        return view('setting::company-profile.index',compact("profile"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('setting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('setting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('access_settings'), 403);
        $profile = CompanyProfile::findOrfail($id);
        $logo = '';
        if ($request->logo)
        {
            $filename=$request->logo->getClientOriginalName();
            $logo = $filename.'.'.$request->logo->extension();

            $request->logo->move(public_path('upload/images/settings'), $logo);

        }
        else{
            $logo = $profile->logo;
        }

        $footer_logo = '';
        if ($request->footer_logo)
        {
            $filename=$request->footer_logo->getClientOriginalName();
            $footer_logo = $filename.'.'.$request->footer_logo->extension();

            $request->footer_logo->move(public_path('upload/images/settings'), $footer_logo);

        }
        else{
            $footer_logo = $profile->footer_logo;
        }

        $favicon = '';
        if ($request->favicon)
        {
            $filename=$request->favicon->getClientOriginalName();
            $favicon = $filename.'.'.$request->favicon->extension();

            $request->favicon->move(public_path('upload/images/settings'), $favicon);

        }
        else{
            $favicon = $profile->favicon;
        }

        $image = '';
        if ($request->image)
        {
            $filename=$request->image->getClientOriginalName();
            $image = $filename.'.'.$request->image->extension();

            $request->image->move(public_path('upload/images/settings'), $image);

        }
        else{
            $image = $profile->image;
        }

        $profile->update([
            'company_name' => $request['company_name'],
            'company_phone' => $request['company_phone'],
            'company_email' => $request['company_email'],
            'company_address' => $request['company_address'],
            'logo' => $logo,
            'footer_logo' => $footer_logo,
            'favicon' => $favicon,
            'image' => $image,
            'introduction' => $request['introduction'],
            'mission' => $request['mission'],
            'vision' => $request['vision'],
            'footer_text' => $request['footer_text'],
            'map' => $request['map'],
            'facebook' => $request['facebook'],
            'instagram' => $request['instagram'],
            'twitter' => $request['twitter'],
            'youtube' => $request['youtube'],
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'meta_keywords' => $request['meta_keywords']
        ]);

        return redirect()->route('company.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
    public function whyUs()
    {
        $whyus = WhyUs::all();
        return view('setting::company-profile.why-us',compact('whyus'));
    }
    public function WhyUsStore(Request $request)
    {
        if ($request->icon)
        {
            $filename=$request->icon->getClientOriginalName();
            $icon = $filename.'.'.$request->icon->extension();

            $request->icon->move(public_path('upload/images/whyus'), $icon);

        }else{
            $icon = 'noimage';
        }
        $whyus = WhyUs::create([
            'name' => $request['title'],
            'icon' => $icon
        ]);
         return back()->with('success','Successfully Created');
    }
    public function WhyUsUpdate(Request $request, $id)
    {
        $whyus = WhyUs::findOrfail($id);
        if ($request->icon)
        {
            $filename=$request->icon->getClientOriginalName();
            $icon = $filename.'.'.$request->icon->extension();

            $request->icon->move(public_path('upload/images/whyus'), $icon);

        }
        else
        {
            $icon=$whyus->icon;
        }
        $whyus->update([
            'name' => $request['title'],
            'icon' => $icon
        ]);
         return back()->with('success','Successfully Updated');
    }
    public function WhyUsDelete($id)
    {
        $whyus = WhyUs::findOrfail($id);
        $whyus->delete();
        return back()->with('success','Successfully Deleted');
    }


    public function features()
{
    // dd($features);
    $features = Feature::all();
    return view('setting::company-profile.features', compact('features'));
}

public function featuresStore(Request $request)
{
    $data = new Feature();
    $data->title = $request->title;

    if ($request->hasFile('image')) {
        $file = $request->image;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move('upload/images/features/', $filename);
        $data->image = $filename;
    }

    $data->save();
    return back()->with('success', 'Feature Created Successfully');
}

public function featuresUpdate(Request $request, $id)
{
    $data = Feature::findOrFail($id);
    $data->title = $request->title;

    if ($request->hasFile('image')) {
        $file = $request->image;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move('upload/images/features/', $filename);
        $data->image = $filename;
    }

    $data->save();
    return back()->with('success', 'Feature Updated Successfully');
}

public function featuresDelete($id)
{
    Feature::findOrFail($id)->delete();
    return back()->with('success', 'Feature Deleted Successfully');
}


    public function plans()
{
    // dd($features);
    $plans = Plan::all();
    return view('setting::company-profile.plans', compact('plans'));
}

public function plansStore(Request $request)
{
    $data = new Plan();
    $data->title = $request->title;
    $data->bigtitle = $request->bigtitle;
      $data->days = $request->days;
    $data->data1 = $request->data1;
    $data->data2 = $request->data2;
    $data->data3 = $request->data3;
    $data->data4 = $request->data4;
    $data->data5 = $request->data5;
    $data->data6 = $request->data6;
    $data->data7 = $request->data7;
    $data->data8 = $request->data8;
    $data->data9 = $request->data9;
    $data->data10 = $request->data10;


    if ($request->hasFile('image')) {
        $file = $request->image;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move('upload/images/plans/', $filename);
        $data->image = $filename;
    }

    $data->save();
    return back()->with('success', 'Plans Created Successfully');
}

public function plansUpdate(Request $request, $id)
{
    $data = Plan::findOrFail($id);
   $data->title = $request->title;
    $data->bigtitle = $request->bigtitle;
      $data->days = $request->days;
    $data->data1 = $request->data1;
    $data->data2 = $request->data2;
    $data->data3 = $request->data3;
    $data->data4 = $request->data4;
    $data->data5 = $request->data5;
    $data->data6 = $request->data6;
    $data->data7 = $request->data7;
    $data->data8 = $request->data8;
    $data->data9 = $request->data9;
    $data->data10 = $request->data10;

    if ($request->hasFile('image')) {
        $file = $request->image;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move('upload/images/plans/', $filename);
        $data->image = $filename;
    }

    $data->save();
    return back()->with('success', 'Plans Updated Successfully');
}

public function plansDelete($id)
{
    Plan::findOrFail($id)->delete();
    return back()->with('success', 'plans Deleted Successfully');
}

//aked questions
 public function askedQuestions()
{
    // dd($features);
    $askedQuestions = askedQuestions::all();
    return view('setting::company-profile.askedQuestions', compact('askedQuestions'));
}

public function askedQuestionsStore(Request $request)
{
    $data = new askedQuestions();
    $data->title = $request->title;
    $data->subtitle=$request->title;

    $data->save();
    return back()->with('success', 'askedQuestions Created Successfully');
}

public function askedQuestionsUpdate(Request $request, $id)
{
    $data = askedQuestions::findOrFail($id);
    $data->title = $request->title;
    $data->subtitle = $request->subtitle;



    $data->save();
    return back()->with('success', 'askedQuestions Updated Successfully');
}

public function askedQuestionsDelete($id)
{
    askedQuestions::findOrFail($id)->delete();
    return back()->with('success', 'askedQuestions Deleted Successfully');
}

// ===== CUSTOMER SAYS ===== //

public function customerSays()
{
    $customerSays = customerSays::all();
    return view('setting::company-profile.customerSays', compact('customerSays'));
}

public function customerSaysStore(Request $request)
{
    $data = new customerSays();
    $data->name = $request->name;
    $data->working = $request->working;
    $data->description = $request->description;

    // image upload
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload/customer_says'), $filename);
        $data->image = $filename;
    }

    $data->save();

    return back()->with('success', 'Customer Says Created Successfully');
}

public function customerSaysUpdate(Request $request, $id)
{
    $data = customerSays::findOrFail($id);
    $data->name = $request->name;
    $data->working = $request->working;
    $data->description = $request->description;

    // image upload
    if ($request->hasFile('image')) {
        // delete old
        if ($data->image && file_exists(public_path('upload/customer_says/'.$data->image))) {
            unlink(public_path('upload/customer_says/'.$data->image));
        }

        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload/customer_says'), $filename);
        $data->image = $filename;
    }

    $data->save();

    return back()->with('success', 'Customer Says Updated Successfully');
}

public function customerSaysDelete($id)
{
    $data = customerSays::findOrFail($id);

    // delete image
    if ($data->image && file_exists(public_path('upload/customer_says/'.$data->image))) {
        unlink(public_path('upload/customer_says/'.$data->image));
    }

    $data->delete();

    return back()->with('success', 'Customer Says Deleted Successfully');
}

public function customerSaysStatus($id)
{
    $data = customerSays::findOrFail($id);

    $data->status = $data->status == 'on' ? 'off' : 'on';
    $data->save();

    return back()->with('success', 'Status Updated');
}





// ===== Feature ===== //

public function Interface()
{
    $Interfaces = Interfaces::all();
    return view('setting::company-profile.interface', compact('Interfaces'));
}

public function InterfaceStore(Request $request)
{    $request->validate([
        'image' => 'required|image',
    ]);

    $data = new Interfaces;


    // image upload
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload/images/interfaces'), $filename);
        $data->image = $filename;
    }

    $data->save();

    return back()->with('success', 'Interface Created Successfully');
}

public function InterfaceUpdate(Request $request, $id)
{

    $data = Interfaces::find($id);   // ✔ You forgot this

    if (!$data) {
        return back()->with('error', 'Interface not found');
    }
    // image upload
    if ($request->hasFile('image')) {
        // delete old
        if ($data->image && file_exists(public_path('upload//images/interfaces/'.$data->image))) {
            unlink(public_path('upload/images/interfaces/'.$data->image));
        }

        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload/images/interfaces'), $filename);
        $data->image = $filename;
    }

    $data->save();

    return back()->with('success', 'Interface  Updated Successfully');
}

public function InterfaceDelete($id)
{
   $data = Interfaces::find($id);   // ✔ You forgot this

    if (!$data) {
        return back()->with('error', 'Interface not found');
    }

    // delete image
    if ($data->image && file_exists(public_path('upload/images/interfaces/'.$data->image))) {
        unlink(public_path('upload/images/interfaces/'.$data->image));
    }

    $data->delete();

    return back()->with('success', 'Interface Deleted Successfully');
}


//videos
public function Video(Request $request)
{
    $query = Video::query();

    // Search by name/title

    if ($request->has('search') && !empty($request->search)) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }
      $profile = CompanyProfile::first();

    $videos = $query->latest()->paginate(10);
    $featuredVideos = Video::where('is_featured', 1)->latest()->take(5)->get();

    return view('frontend.body.blogs', compact('videos', 'featuredVideos','profile'));
}


public function VideoStore(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'youtube_url' => 'required|url',
    ]);

    // Generate thumbnail from YouTube URL
    $thumbnail = $this->getYoutubeThumbnail($request->youtube_url);

    // Create video
    Video::create([
        'title' => $request->title,
        'youtube_url' => $request->youtube_url,
        'thumbnail' => $thumbnail,
        'is_featured' => $request->has('is_featured') ? 1 : 0, // <--- Fix here
    ]);

    return redirect()->route('company-profile.videos')->with('success', 'Video added successfully!');
}


     public function VideoDelete($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return redirect()->route('company-profile.videos')->with('success', 'Video deleted successfully!');
    }

   private function getYoutubeThumbnail($url)
{
    // Match youtu.be or youtube.com URLs
    preg_match('%(?:youtube\.com/(?:.*v=|v/|embed/)|youtu\.be/)([a-zA-Z0-9_-]{11})%i', $url, $matches);
    return isset($matches[1])
        ? 'https://img.youtube.com/vi/'.$matches[1].'/hqdefault.jpg'
        : null;
}





}
