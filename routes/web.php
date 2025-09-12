<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Role;
use App\Http\Controllers\Admin\Settings;
use App\Http\Controllers\Admin\Profile;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Home;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\Enquiry;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\Our_IndapurController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\WallpapersController;
use App\Http\Controllers\Admin\SocialActivityController;
use Mews\Captcha\Facades\Captcha;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\Hospital_HelpController;
use App\Http\Controllers\Admin\JourneyController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\RingtoneController;
use App\Http\Controllers\HomeController;



Route::get('/',[HomeController::class, 'index'])->name(name: 'web.app');
Route::get('/',[HomeController::class, 'home'])->name(name: 'web.home');
Route::get('introduction',[HomeController::class, 'introduction'])->name(name: 'web.introduction');
Route::get('journey',[HomeController::class, 'journey'])->name(name: 'web.journey');
Route::get('gallery',[HomeController::class, 'gallery'])->name(name: 'web.gallery');
Route::get('/gallery/{slug}', [HomeController::class, 'gallery_details'])->name('web.gallery_details');
// Route::get('video',[HomeController::class, 'video'])->name(name: 'web.video');
Route::get('/blog', [HomeController::class, 'blog'])->name('web.blog');
Route::get('blog{slug}',[HomeController::class, 'blog_details'])->name(name: 'web.blog_details');
Route::get('our_indapur',[HomeController::class, 'our_indapur'])->name(name: 'web.our_indapur');
Route::get('our_indapur/{slug}',[HomeController::class, 'our_indapur_details'])->name(name: 'web.our_indapur_details');
Route::get('hospital_help',[HomeController::class, 'hospital_help'])->name(name: 'web.hospital_help');
Route::get('ringtone',[HomeController::class, 'ringtone'])->name(name: 'web.ringtone');
Route::get('wallpaper',[HomeController::class, 'wallpaper'])->name(name: 'web.wallpaper');
Route::get('page/{slug}',[HomeController::class, 'page'])->name(name: 'web.page');
Route::get('social_activity',[HomeController::class, 'social_activity'])->name(name: 'web.social_activity');

Route::get('contact_us',[HomeController::class, 'contact_us'])->name(name: 'web.contact_us');
Route::post('contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/captcha-image', function () {
    $builder = new CaptchaBuilder;
    $builder->setBackgroundColor(255, 255, 255);
    $builder->setMaxAngle(10);      
    $builder->setMaxBehindLines(2);
    $builder->setMaxFrontLines(2);
    $builder->setDistortion(false);
    $number = random_int(100, 999); 
    $builder->setPhrase((string)$number);
    $builder->build(100, 40);
    Session::put('captcha_phrase', $number); 
    return response($builder->output())
        ->header('Content-Type', 'image/png')
        ->header('Cache-Control', 'no-cache, must-revalidate');
})->name('captcha.image');


Route::group(['prefix'=>'/admin'], function() {
    Route::get('/refresh-captcha', [Login::class, 'reloadCaptcha'])->name('admin.reload.captcha');
    Route::get('',[Login::class,'login'])->name('admin.login')->middleware('admin-auth','no-cache');
    Route::post('',[Login::class,'login_check'])->name('admin.check_login');
    Route::get('forgot-password',[Login::class,'forgot_password'])->name('admin.forgot_password')->middleware('admin-auth','no-cache');
    Route::get('logout',[Login::class,'logout'])->name('admin.logout');
    Route::get('clear-cache', [Dashboard::class,'clear_cache'])->name('admin.clear_cache');

    Route::middleware(['admin-auth', 'no-cache'])->group(function () {
        Route::get('dashboard',[Dashboard::class,'index'])->name('admin.dashboard');
        Route::get('role',[Role::class,'list'])->name('admin.role');
        Route::post('role',[Role::class,'ajax_list'])->name('admin.role.list');
        Route::get('role/new',[Role::class,'new'])->name('admin.role.new');
        Route::get('role/edit/{id}',[Role::class,'edit'])->name('admin.role.edit');
        Route::post('role/add',[Role::class,'new_role'])->name('admin.role.new_role');
        Route::post('role/edit',[Role::class,'edit_role'])->name('admin.role.edit_role');
        Route::get('role/details/{id}',[Role::class,'quick_details'])->name('admin.role.quick_details');
        Route::post('role/update',[Role::class,'change_status'])->name('admin.role.change_status');

        Route::get('settings/basic',[Settings::class,'basic'])->name('admin.settings.basic')->middleware('admin-auth');
        Route::post('settings/update-basic',[Settings::class,'update_basic'])->name('admin.setings.update_basic');
        Route::get('settings/application',[Settings::class,'application'])->name('admin.settings.application')->middleware('admin-auth');
        Route::post('settings/update-application',[Settings::class,'update_application'])->name('admin.setings.update_application');
        Route::get('settings/application', [Settings::class, 'Pages'])->name('admin.settings.application');
        Route::get('settings/theme',[Settings::class,'theme'])->name('admin.settings.theme')->middleware('admin-auth');
        Route::post('settings/update-theme',[Settings::class,'update_theme'])->name('admin.setings.update_theme');
        Route::get('settings/security',[Settings::class,'security'])->name('admin.settings.security')->middleware('admin-auth');
        Route::post('settings/update-security',[Settings::class,'update_security'])->name('admin.setings.update_security');
        Route::get('settings/payment-gateway',[Settings::class,'payment_gateway'])->name('admin.settings.payment_gateway')->middleware('admin-auth');
        Route::post('settings/payment-gateway-list',[Settings::class,'payment_gateway_list'])->name('admin.settings.payment_gateway_list');
        Route::get('category/edit-payment-gateway/{id}',[Settings::class,'edit_payment_gateway'])->name('admin.settings.edit_payment_gateway');
        Route::post('settings/update-payment-gateway',[Settings::class,'update_payment_gateway'])->name('admin.settings.update_payment_gateway');
        Route::post('settings/change-payment-status',[Settings::class,'change_payment_status'])->name('admin.settings.change-payment-status');
        Route::get('settings/details/{id}',[Settings::class,'payment_gateway_details'])->name('admin.settings.payment_gateway_details');

        Route::get('profile/basic',[Profile::class,'basic'])->name('admin.profile.basic');
        Route::post('profile/edit',[Profile::class,'edit_profile'])->name('admin.profile.edit_profile');

        Route::post('dashboard',[Dashboard::class,'contact_list'])->name('admin.dashboard.contact_list');

        Route::get('enquiry/contact',[Enquiry::class,'contact'])->name('admin.enquiry.contact')->middleware('admin-auth');
        Route::post('enquiry/contact-list',[Enquiry::class,'contact_list'])->name('admin.enquiry.contact_list');
        Route::get('enquiry/contact/details/{id}',[Enquiry::class,'contact_details'])->name('admin.enquiry.contact_details');
        Route::get('enquiry/subscribe',[Enquiry::class,'subscribe'])->name('admin.enquiry.subscribe')->middleware('admin-auth');
        Route::post('enquiry/subscribe-list',[Enquiry::class,'subscribe_list'])->name('admin.enquiry.subscribe_list');
        Route::post('enquiry/new-subscribe',[Enquiry::class,'new_subscribe'])->name('admin.enquiry.new_subscribe');
        Route::get('enquiry/subscribe/details/{id}',[Enquiry::class,'subscribe_details'])->name('admin.enquiry.subscribe_details');
    
        Route::get('enquiry/joinWithUs',[Enquiry::class,'joinWithUs'])->name('admin.enquiry.joinWithUs')->middleware('admin-auth');
        Route::post('enquiry/new-joinWithUs',[Enquiry::class,'new_joinWithUs'])->name('admin.enquiry.new_joinWithUs');
        Route::post('enquiry/joinWithus-list',[Enquiry::class,'joinWithus_list'])->name('admin.enquiry.joinWithus_list');
        Route::get('enquiry/joinWithUs/details/{id}',[Enquiry::class,'joinWithUs_details'])->name('admin.enquiry.joinWithUs_details');
        

        Route::get('filemanager', [FileManagerController::class, 'index'])->name('admin.filemanager');
        Route::get('filemanager/browse', [FileManagerController::class, 'browse'])->name('admin.filemanager.browse');
        Route::post('filemanager/upload', [FileManagerController::class, 'upload'])->name('admin.filemanager.upload');
        Route::post('filemanager/create-folder', [FileManagerController::class, 'createFolder'])->name('admin.filemanager.create-folder');
        Route::post('filemanager/delete', [FileManagerController::class, 'delete'])->name('admin.filemanager.delete');
        Route::post('filemanager/rename', [FileManagerController::class, 'rename'])->name('admin.filemanager.rename');
         //page
        Route::get('page',[PageController::class,'index'])->name('admin.page')->middleware('admin-auth');
        Route::get('page/new', [PageController::class, 'add'])->name('admin.page.new');
        Route::post('page/add', [PageController::class, 'new_page'])->name('admin.page.add_page');
        Route::post('page', [PageController::class, 'ajax_list'])->name('admin.page.list');
        Route::get('page/edit/{id}', [PageController::class, 'edit'])->name('admin.page.edit');
        Route::post('page/edit', [PageController::class, 'edit_page'])->name('admin.page.edit_page');
        Route::get('page/details/{id}', [PageController::class, 'quick_details'])->name('admin.page.quick_details');
        Route::post('page/update', [PageController::class, 'change_status'])->name('admin.page.change-status');
          //blog
        Route::get('blog',[BlogController::class,'index'])->name('admin.blog')->middleware('admin-auth');
        Route::get('blog/new', [BlogController::class, 'add'])->name('admin.blog.new');
        Route::post('blog/add', [BlogController::class, 'new_blog'])->name('admin.blog.add_blog');
        Route::post('blog', [BlogController::class, 'ajax_list'])->name('admin.blog.list');
        Route::get('blog/edit/{id}', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::post('blog/edit', [BlogController::class, 'edit_blog'])->name('admin.blog.edit_blog');
        Route::get('blog/details/{id}', [BlogController::class, 'quick_details'])->name('admin.blog.quick_details');
        Route::post('blog/update', [BlogController::class, 'change_status'])->name('admin.blog.change-status');
        //our indapur
        Route::get('our-indapur',[Our_IndapurController::class,'index'])->name('admin.our_indapur')->middleware('admin-auth');
       Route::get('our-indapur/new', [Our_IndapurController::class, 'add'])->name('admin.our_indapur.new');
        Route::post('our-indapur/add', [Our_IndapurController::class, 'new_our_indapur'])->name('admin.our_indapur.add_our_indapur');
        Route::post('our-indapur', [Our_IndapurController::class, 'ajax_list'])->name('admin.our_indapur.list');
        Route::get('our-indapur/edit/{id}', [Our_IndapurController::class, 'edit'])->name('admin.our_indapur.edit');
        Route::post('our-indapur/edit', [Our_IndapurController::class, 'edit_our_indapur'])->name('admin.our_indapur.edit_our_indapur');
        Route::get('our-indapur/details/{id}', [Our_IndapurController::class, 'quick_details'])->name('admin.our_indapur.quick_details');
        Route::post('our-indapur/update', [Our_IndapurController::class, 'change_status'])->name('admin.our_indapur.change-status');
        //gallery
        Route::get('gallery',[GalleryController::class,'index'])->name('admin.gallery')->middleware('admin-auth');
        Route::get('gallery/new', [GalleryController::class, 'add'])->name('admin.gallery.new');
        Route::post('gallery/add', [GalleryController::class, 'new_gallery'])->name('admin.gallery.add_gallery');
        Route::post('gallery', [GalleryController::class, 'ajax_list'])->name('admin.gallery.list');
        Route::get('gallery/edit/{id}', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
        Route::post('gallery/edit', [GalleryController::class, 'edit_gallery'])->name('admin.gallery.edit_gallery');
        Route::get('gallery/details/{id}', [GalleryController::class, 'quick_details'])->name('admin.gallery.quick_details');
        Route::post('gallery/update', [GalleryController::class, 'change_status'])->name('admin.gallery.change-status');
        //social Activity
        Route::get('social-activity',[SocialActivityController::class,'index'])->name('admin.social_activity')->middleware('admin-auth');
        Route::get('social-activity/new', [SocialActivityController::class, 'add'])->name('admin.social_activity.new');
        Route::post('social-activity/add', [SocialActivityController::class, 'new_social_activity'])->name('admin.social_activity.add_social_activity');
        Route::post('social-activity', [SocialActivityController::class, 'ajax_list'])->name('admin.social_activity.list');
        Route::get('social-activity/edit/{id}', [SocialActivityController::class, 'edit'])->name('admin.social_activity.edit');
        Route::post('social-activity/edit', [SocialActivityController::class, 'edit_social_activity'])->name('admin.social_activity.edit_social_activity');
        Route::get('social-activity/details/{id}', [SocialActivityController::class, 'quick_details'])->name('admin.social_activity.quick_details');
        Route::post('social-activity/update', [SocialActivityController::class, 'change_status'])->name('admin.social_activity.change-status');
        //slider
        Route::get('slider',[SliderController::class,'index'])->name('admin.slider')->middleware('admin-auth');
        Route::get('slider/new', [SliderController::class, 'add'])->name('admin.slider.new');
        Route::post('slider/add', [SliderController::class, 'new_slider'])->name('admin.slider.add_slider');
        Route::post('slider', [SliderController::class, 'ajax_list'])->name('admin.slider.list');
        Route::get('slider/edit/{id}', [SliderController::class, 'edit'])->name('admin.slider.edit');
        Route::post('slider/edit', [SliderController::class, 'edit_slider'])->name('admin.slider.edit_slider');
        Route::get('slider/details/{id}', [SliderController::class, 'quick_details'])->name('admin.slider.quick_details');
        Route::post('slider/update', [SliderController::class, 'change_status'])->name('admin.slider.change-status');
        //wallpapers
        Route::get('wallpapers',[WallpapersController::class,'index'])->name('admin.wallpapers')->middleware('admin-auth');
        Route::get('wallpapers/new', [WallpapersController::class, 'add'])->name('admin.wallpapers.new');
        Route::post('wallpapers/add', [WallpapersController::class, 'new_wallpapers'])->name('admin.wallpapers.add_wallpapers');
        Route::post('wallpapers', [WallpapersController::class, 'ajax_list'])->name('admin.wallpapers.list');
        Route::get('wallpapers/edit/{id}', [WallpapersController::class, 'edit'])->name('admin.wallpapers.edit');
        Route::post('wallpapers/edit', [WallpapersController::class, 'edit_wallpapers'])->name('admin.wallpapers.edit_wallpapers');
        Route::get('wallpapers/details/{id}', [WallpapersController::class, 'quick_details'])->name('admin.wallpapers.quick_details');
        Route::post('wallpapers/update', [WallpapersController::class, 'change_status'])->name('admin.wallpapers.change-status');
        //user
         Route::get('user',[UserController::class,'list'])->name('admin.user');
        Route::get('user/new', [UserController::class, 'add'])->name('admin.user.new');
        Route::post('user/add', [UserController ::class, 'new_user'])->name('admin.user.add_user');
        Route::post('user', [UserController::class, 'ajax_list'])->name('admin.user.list');
        Route::get('user/details/{id}', [UserController::class, 'quick_details'])->name('admin.user.quick_details');
        Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::post('user/edit', [UserController::class, 'edit_user'])->name('admin.user.edit_user');
        Route::post('user/update', [UserController::class, 'change_status'])->name('admin.user.change-status');
        Route::get('user/password/{id}', [UserController::class, 'password'])->name('admin.user.passsword');
        Route::post('user/setpassword', [UserController::class, 'set_password'])->name('admin.user.set-passsword');

     //video
        // Route::get('video',[VideoController::class,'index'])->name('admin.video')->middleware('admin-auth');
        // Route::get('video/new', [VideoController::class, 'add'])->name('admin.video.new');
        // Route::post('video/add', [VideoController::class, 'new_video'])->name('admin.video.add_video');
        // Route::post('video', [VideoController::class, 'ajax_list'])->name('admin.video.list');

        // Route::get('video/edit/{id}', [VideoController::class, 'edit'])->name('admin.video.edit');
        // Route::post('video/edit', [VideoController::class, 'edit_video'])->name('admin.video.edit_video');
        // Route::get('video/details/{id}', [VideoController::class, 'quick_details'])->name('admin.video.quick_details');
        // Route::post('video/update', [VideoController::class, 'change_status'])->name('admin.video.change-status');

         //Ringtone
        // Route::get('ringtone',[RingtoneController::class,'index'])->name('admin.ringtone')->middleware('admin-auth');
        // Route::get('ringtone/new', [RingtoneController::class, 'add'])->name('admin.ringtone.new');
        // Route::post('ringtone/add', [RingtoneController::class, 'new_ringtone'])->name('admin.ringtone.add_ringtone');
        // Route::post('ringtone', [RingtoneController::class, 'ajax_list'])->name('admin.ringtone.list');
        // Route::get('ringtone/edit/{id}', [RingtoneController::class, 'edit'])->name('admin.ringtone.edit');
        // Route::post('ringtone/edit', [RingtoneController::class, 'edit_ringtone'])->name('admin.ringtone.edit_ringtone');
        // Route::get('ringtone/details/{id}', [RingtoneController::class, 'quick_details'])->name('admin.ringtone.quick_details');
        // Route::post('ringtone/update', [RingtoneController::class, 'change_status'])->name('admin.ringtone.change-status');

        //hospital help
        Route::get('hospital-help',[Hospital_HelpController::class,'index'])->name('admin.hospital_help')->middleware('admin-auth');
        Route::get('hospital-help/new', [Hospital_HelpController::class, 'add'])->name('admin.hospital_help.new');
        Route::post('hospital-help/add', [Hospital_HelpController::class, 'new_hospital_help'])->name('admin.hospital_help.add_hospital_help');
        Route::post('hospital-help', [Hospital_HelpController::class, 'ajax_list'])->name('admin.hospital_help.list');
        Route::get('hospital-help/edit/{id}', [Hospital_HelpController::class, 'edit'])->name('admin.hospital_help.edit');
        Route::post('hospital-help/edit', [Hospital_HelpController::class, 'edit_hospital_help'])->name('admin.hospital_help.edit_hospital_help');
        Route::get('hospital-help/details/{id}', [Hospital_HelpController::class, 'quick_details'])->name('admin.hospital_help.quick_details');
        Route::post('hospital-help/update', [Hospital_HelpController::class, 'change_status'])->name('admin.hospital_help.change-status');
        //journey
        Route::get('journey',[JourneyController::class,'index'])->name('admin.journey')->middleware('admin-auth');
        Route::get('journey/new', [JourneyController::class, 'add'])->name('admin.journey.new');
        Route::post('journey/add', [JourneyController::class, 'new_journey'])->name('admin.journey.add_journey');
        Route::post('journey', [JourneyController::class, 'ajax_list'])->name('admin.journey.list');
        Route::get('journey/edit/{id}', [JourneyController::class, 'edit'])->name('admin.journey.edit');
        Route::post('journey/edit', [JourneyController::class, 'edit_journey'])->name('admin.journey.edit_journey');
        Route::get('journey/details/{id}', [JourneyController::class, 'quick_details'])->name('admin.journey.quick_details');
        Route::post('journey/update', [JourneyController::class, 'change_status'])->name('admin.journey.change-status');
    //journey
        Route::get('journey',[JourneyController::class,'index'])->name('admin.journey')->middleware('admin-auth');
        Route::get('journey/new', [JourneyController::class, 'add'])->name('admin.journey.new');
        Route::post('journey/add', [JourneyController::class, 'new_journey'])->name('admin.journey.add_journey');
        Route::post('journey', [JourneyController::class, 'ajax_list'])->name('admin.journey.list');
        Route::get('journey/edit/{id}', [JourneyController::class, 'edit'])->name('admin.journey.edit');
        Route::post('journey/edit', [JourneyController::class, 'edit_journey'])->name('admin.journey.edit_journey');
        Route::get('journey/details/{id}', [JourneyController::class, 'quick_details'])->name('admin.journey.quick_details');
        Route::post('journey/update', [JourneyController::class, 'change_status'])->name('admin.journey.change-status');


    
    });
});


