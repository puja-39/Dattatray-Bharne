<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Slider;
use App\Models\wallpapers;
use App\Models\Contact;
use App\Models\Video;
use App\Models\Journey;
use App\Models\Our_indapur;
use App\Models\Hospital_help;
use App\Models\Ringtone;
use App\Models\Page;

class HomeController extends Controller
{ 
    public function index(){        
       return view('frontend.home');      
    }
     public function home()
    {
        $desktop_slider = Slider::where('is_active','=','1')->where('type','=','desktop')->get();
        $mobile_slider = Slider::where('is_active','=','1')->where('type','=','mobile')->get();
        $blog = Blog::where('is_active','=','1')->take(4)->get();
        $gallery = Gallery::where('is_active','=','1')->take(4)->get();
        // $video = Video::where('is_active','=','1')->take(4)->get();
        $journey = Journey::where('is_active', '=' ,'1')->take(5)->get();
        $hospital_help = Hospital_help::where('is_active', '=' ,'1')->take(4)->get(); 
        return view('frontend.home' , compact('blog' , 'gallery' , 'desktop_slider' ,'mobile_slider',  'journey' , 'hospital_help'));      
    }
      public function introduction()
      {
        $page_data = array();
        $page_data['page_title'] = 'Introduction';
        $page_data['page_name'] = 'introduction';
        return view('frontend.introduction' ,  $page_data ); 
    }
      public function contact_us()
      {
        $page_data = array();
        $page_data['page_title'] = 'Contact Us';
        $page_data['page_name'] = 'Contact Us';
        return view('frontend.contact_us' ,  $page_data ); 
    }
     public function journey()
     {
        $journey = Journey::where('is_active', '=' ,'1')->get();
        $page_data = array();
        $page_data['page_title'] = 'Journey';
        $page_data['page_name'] = 'journey';
        return view('frontend.journey' ,  $page_data, compact('journey') ); 
     }
     public function gallery()
     {
        $gallery = Gallery::where('is_active', '=', '1')->orderBy('created_at', 'desc')->paginate(12);
         foreach ($gallery as $item) {
         $cover = null;
         $path = public_path('filemanager/' . $item->slug);

       if (File::exists($path)) {
           foreach (File::files($path) as $file) {
               $ext = strtolower($file->getExtension());
               if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                   $cover = 'filemanager/' . $item->slug . '/' . $file->getFilename();
                   break;
               }
            }
         }
           $item->cover = $cover; 
      }
        $page_data = [
            'page_title' => 'Gallery',
            'page_name'  => 'gallery',
            'gallery'    => $gallery
        ];
        return view('frontend.gallery', $page_data);
    }
   
      public function gallery_details($slug)
         {
        $gallery = Gallery::where('slug', $slug)->firstOrFail();
        $page_js =  ["assets/home/plugins/fancybox/fancybox.umd.js"];
        $page_css = ["assets/home/plugins/fancybox/fancybox.css"];
        $page_data = [
            'page_title' => $gallery->name ?? 'Gallery Details',
            'page_name'  => 'gallery_details',
            'gallery'    => $gallery,
            'page_js'    => $page_js,
            'page_css'   => $page_css,
        ];
            return view('frontend.gallery_details', $page_data);
    }

    //   public function video(Request $request)
    //   {  
    //    $video = Video::where('is_active','=','1')->get();
    //     $page_data = array();
    //     $page_data['page_title'] = 'Video';
    //     $page_data['page_name'] = 'video';
    //     return view('frontend.video' ,  $page_data , compact('video')); 
    // }

    public function blog()
      {
        $blog = Blog::where('is_active', '=', '1')->orderBy('created_at', 'desc')->paginate(6);
        $page_data = array();
        $page_data['page_title'] = 'Blog';
        $page_data['page_name'] = 'blog';
     return view('frontend.blog' ,  $page_data , compact('blog') ); 
    }
    public function blog_details($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $page_data = array();
        $page_data['page_title'] = 'Blog';
        $page_data['page_name'] = 'blog';
     return view('frontend.blog_details' ,  $page_data , compact('blog') ); 
    }
      
    public function our_indapur()
     {
        $our_indapur = Our_indapur::where('is_active','=','1')->orderBy('created_at', 'desc')->paginate(6);
        // dd($our_indapur);
        $page_data = array();
        $page_data['page_title'] = 'Our Indapur';
        $page_data['page_name'] = 'our_indapur';
     return view('frontend.our_indapur' ,  $page_data , compact('our_indapur')  ); 
    }
    public function our_indapur_details($slug)
     {
        $our_indapur = Our_indapur::where('slug', $slug)->firstOrFail();
        $page_data = array();
        $page_data['page_title'] = 'Our Indapur';
        $page_data['page_name'] = 'Our indapur';
     return view('frontend.our_indapur_details' ,  $page_data , compact('our_indapur') ); 
    }

    public function hospital_help()
    {
        // $hospital_help = Hospital_help::where('is_active','=','1')->get();
        $hospital_help = Hospital_help::where('is_active', '=', '1')->orderBy('created_at', 'desc') ->get();
        $page_data = array();
        $page_data['page_title'] = 'Hospital Help';
        $page_data['page_name'] = 'Hospital Help';
     return view('frontend.hospital_help' ,  $page_data , compact('hospital_help')  ); 
    }  
       public function ringtone()
    {
        $ringtone = Ringtone::where('is_active','=','1')->get();
      //   dd($ringtone);
        $page_data = array();
        $page_data['page_title'] = 'Ringtone';
        $page_data['page_name'] = 'Ringtone';
     return view('frontend.ringtone' ,  $page_data , compact('ringtone')  ); 
    }  
              
     public function wallpaper(){
        $wallpaper = Wallpapers::where('is_active','=','1')->orderBy('created_at', 'desc')->paginate(6);
        $page_data = array();
        $page_data['page_title'] = 'Wallpaper';
        $page_data['page_name'] = 'wallpaper';
     return view('frontend.wallpaper' ,  $page_data , compact('wallpaper') ); 
    }

      
      public function page($slug){
        $page = Page::where('slug', $slug)->first();
       return view('frontend.page' ,  compact('page') );   
    }

     public function social_activity(){
        $page_data = array();
        $page_data['page_title'] = 'social_activity';
        $page_data['page_name'] = 'social_activity';
     return view('frontend.introduction' ,  $page_data ); 
    }
}
