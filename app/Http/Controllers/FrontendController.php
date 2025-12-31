<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Setting\Entities\CompanyProfile;
use Modules\Setting\Entities\Feature;
use Modules\Setting\Entities\Plan;
use Modules\Setting\Entities\askedQuestions;
use Modules\Setting\Entities\customerSays;
use Modules\Setting\Entities\Interfaces;
use App\Models\Video;
use App\Models\Blog;
use App\Models\ContactMessage;



class FrontendController extends Controller
{

public function welcome()
{
    $profile = CompanyProfile::first(); 
    $features = Feature::all();
    $plans = Plan::all(); 
    $askedQuestions = askedQuestions::all(); 
    $customerSays = customerSays::all(); 
    $Interfaces = Interfaces::all(); 

    // Get latest 5 videos
    $videos = Video::latest()->take(5)->get();

    return view('welcome', compact(
        'profile',
        'features',
        'plans',
        'askedQuestions',
        'customerSays',
        'Interfaces',
        'videos' 
    ));
}



    public function about()
    {
          $profile = CompanyProfile::first(); 
            $plans = Plan::all(); 
                $features = Feature::all();
        return view('frontend.body.aboutus',compact('profile','plans','features'));
    }

    // public function services()
    // {
    //     return view('frontend.services');
    // }



    // Show Contact Page (GET)
      // Show Contact Page
    public function contact()
    {
        $profile = CompanyProfile::first();
        return view('frontend.body.contact', compact('profile'));
    }

    // Store Contact Form
    public function contactStore(Request $request)
    {
        $request->validate([
            'full_name'    => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'email'        => 'required|email|max:100',
            'company'      => 'nullable|string|max:150',
            'message'      => 'required|string|max:1000',
        ]);

        ContactMessage::create([
            'full_name'    => $request->full_name,
            'phone_number' => $request->phone_number,
            'email'        => $request->email,
            'company'      => $request->company,
            'message'      => $request->message,
            'is_read'      => 0, // default to unread
        ]);

        return back()->with('success', 'Your message has been sent successfully!');
    }
    


    public function blogs()
{
    $profile = CompanyProfile::first();

    // Main blogs (paginate if you want)
    $videos = Video::orderBy('created_at', 'desc')->paginate(10);

    // Suggested blogs (latest 5)
    $featuredVideos = Video::orderBy('created_at', 'desc')->take(5)->get();

    return view('frontend.body.blogs', compact('profile', 'videos', 'featuredVideos'));
}
    public function blogsreadmore()
    {
           $profile = CompanyProfile::first(); 
        return view('frontend.body.viewall',compact('profile'));
    }
    public function terms()
    {
         $profile = CompanyProfile::first(); 
        return view('frontend.body.terms',compact('profile'));
    }
    public function privacy()
    {
         $profile = CompanyProfile::first(); 
        return view('frontend.body.privacy',compact('profile'));
    }
    public function plan()
    {
           $plans = Plan::all(); 
          $profile = CompanyProfile::first(); 
        return view('frontend.body.plan',compact('profile','plans'));
    }
    public function login()
    {
        return view('frontend.body.login');
    }
   
   
}
