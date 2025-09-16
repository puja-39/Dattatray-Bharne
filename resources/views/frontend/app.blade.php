<!DOCTYPE html>
<html lang="en">
<head>   
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="app-url" content="{{ getBaseURL() }}">
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
        <title>@yield('title') | Official Web Site Of Dattatray Bharne</title>
        <link rel="icon" href="{{ asset('public\uploads\favicon.ico') }}" type="image/png">
      	<link rel="apple-touch-icon-precomposed" href="/apple-touch-icon.png">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/style2.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/color.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/typography.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/prettyPhoto.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/TimeCircles.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/popup.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/fullcalendar.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/widget.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/shortcodes.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/backend/css/jquery.bxslider.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/home/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('public/assets/home/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/home/plugins/fancybox/fancybox.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css"> --}}
       <script>
         document.addEventListener('DOMContentLoaded', function() {
           const header = document.querySelector('.kode_navigation_outr_wrap');
           const showPoint = 100;
           window.addEventListener('scroll', function() {
               if (window.scrollY > showPoint) {
                   header.classList.add('scrolled');
               } else {
                   header.classList.remove('scrolled');
               } });
         });
       </script>
        @stack('styles')
</head>
<style>
/* .kode_navigation_outr_wrap {
    background: #fff;
    z-index: 9999;
    transition: all 0.3s ease-in-out;
    position: relative;
} */
 .bx-pager {
  display: none !important;
}

.kode_navigation_outr_wrap.scrolled {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}
@keyframes slideDown {
    from { transform: translateY(-100%); }
    to { transform: translateY(0); }
}
.kode_ui_element.scrolled {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%; 
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    animation: slideDown 0.4s ease forwards; 
}
.kode_ui_element ul li a {
    text-decoration: none !important; 
}
.kode_navigation_outr_wrap.scrolled:after {
    display: none;
}
.kf_office_name .nav-link {
    background-color: #fff !important;    
    border: 1px solid #000 !important;
    transition: 0.3s;
}

.kf_office_name .nav-link.a.active {
    background-color: #f93 !important;      
    color: #fff !important;
    border-color: #f93 !important;
}

.kf_office_name .nav-link:hover {
    background-color: #f93 !important;      
    color: #fff !important;
}

.kode_banner ul.bxslider>li:before {
    position: fixed;
}
</style>
<body class="wide">
 <header>
    <div class="kode_navigation_outr_wrap">
        <div class="container">

            @php
               $aboutMenu = ['introduction', 'journey'];
               $downloadMenu = ['wallpaper', 'ringtone'];
            @endphp
              <div id="kode-responsive-navigation" class="dl-menuwrapper"  style="color: black; height: 36px; width: 40px;">
                 <button class="navbar-toggler" id="menuToggle">
                     <i class="fa-solid fa-bars"></i>
                 </button>             
                 <div class="mobile-menu" id="mainNavbar">
                     <button class="close-btn" id="closeMenu" style="color: white; font-size: 18px; background-color:#000; border-radius:8px ">&times;</button> 
                     <ul class="dl-menu">
                     <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="menu-item kode-parent-menu {{ request()->is($aboutMenu) ? 'active' : '' }}">
                             {{-- <a href="javascript:void(0);">About</a> --}}
                             <ul class="dl-submenu">
                                 <li><a href="{{ url('introduction') }}">Introduction</a></li>
                                 <li><a href="{{ url('journey') }}">Journey</a></li>
                             </ul>
                         </li>
                         <li><a href="{{ url('gallery') }}">Gallery</a></li>
                         {{-- <li><a href="{{ url('video') }}">Video</a></li> --}}
                         <li><a href="{{ url('blog') }}">Blog</a></li>
                         <li><a href="{{ url('our_indapur') }}">Our Indapur</a></li>
                         <li><a href="{{ url('hospital_help') }}">Hospital Help</a></li>
                         <li class="menu-item kode-parent-menu">
                             {{-- <a href="javascript:void(0);">Download</a> --}}
                             <ul class="dl-submenu">
                                 <li><a href="{{ url('wallpaper') }}">Wallpaper</a></li>
                                 {{-- <li><a href="{{ url('ringtone') }}">Ringtone</a></li> --}}
                             </ul>
                           </li>
                         <li><a href="{{ url('contact_us') }}">Contact Us</a></li>
                     </ul>
                 </div>
             </div>

            <div class="kode_logo">
                <a href="{{ url('/') }}">
                    <img height="72px" src="{{ asset('public\uploads\logo.png') }}" alt="Dattatray Bharane">
                </a>
            </div>

            <div class="kode_ui_element">
                <div class="kode_menu">
                    <ul>
                        <li class="{{ request()->is('/') ? 'active' : '' }}">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="{{ request()->is($aboutMenu) ? 'active' : '' }}">
                            <a href="javascript:void(0);">About <i class="fa fa-angle-down"></i></a>
                            <ul>
                                <li class="{{ request()->is('introduction') ? 'active' : '' }}">
                                    <a href="{{ url('introduction') }}">Introduction</a>
                                </li>
                                <li class="{{ request()->is('journey') ? 'active' : '' }}">
                                    <a href="{{ url('journey') }}">Journey</a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ request()->is('gallery') ? 'active' : '' }}">
                            <a href="{{ url('gallery') }}">Gallery</a>
                        </li>
                        {{-- <li class="{{ request()->is('video') ? 'active' : '' }}">
                            <a href="{{ url('video') }}">Video</a>
                        </li> --}}
                        <li class="{{ request()->is('blog') ? 'active' : '' }}">
                            <a href="{{ url('blog') }}">Blog</a>
                        </li>
                        <li class="{{ request()->is('our-indapur') ? 'active' : '' }}">
                            <a href="{{ url('our_indapur') }}">Our Indapur</a>
                        </li>
                        <li class="{{ request()->is('hospital-help') ? 'active' : '' }}">
                            <a href="{{ url('hospital_help') }}">Hospital Help</a>
                        </li>
                        <li class="{{ request()->is($downloadMenu) ? 'active' : '' }}">
                            <a href="javascript:void(0);">Download <i class="fa fa-angle-down"></i></a>
                            <ul>
                                <li class="{{ request()->is('wallpaper') ? 'active' : '' }}">
                                    <a href="{{ url('wallpaper') }}">Wallpaper</a>
                                </li>
                                {{-- <li class="{{ request()->is('ringtone') ? 'active' : '' }}">
                                    <a href="{{ url('ringtone') }}">Ringtone</a>
                                </li> --}}
                            </ul>
                        </li>
                        <li class="{{ request()->is('contact-us') ? 'active' : '' }}">
                            <a href="{{ url('contact_us') }}">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</header>
 <div id="infoModal" class="modal modal-lg" hidden>
        <div class="modal-contentss">
            <div class="modal-header">
                <span class="infoModalClose" style=" top: 10px;"><a><i class="fa fa-times fa-lg"></i></a></span>
                <h3><b>Join With Us</b></h3>
            </div>
            <div class="modal-body" style="height:auto;padding:2%;">
                <form id="contact_form">
                    <div class="row" id="join_mobile">
                        <div class="col-md-8 col-sm-8">
                            <div class="kf_touch_field">
                                <input class="comming_place" autocomplete="off" name="phone_nu" id="join_phone_no" type="text" placeholder="Phone Number" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="kf_touch_field">
                                <button type="button" id="btn_check_join" class="kode_btn_1">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="join_form" style="display:none;">
                        <div class="col-md-6 col-sm-6">
                            <div class="kf_touch_field">
                                <input class="comming_place" autocomplete="off" id="name" name="user_name" type="text" placeholder="Your Name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="kf_touch_field">
                                <input class="comming_place" autocomplete="off" id="city"  name="user_city" type="text" placeholder="Your City" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="kf_touch_field">
                                <input class="comming_place dob" autocomplete="off" id="dob"  name="user_dob" type="text" placeholder="Your Date of Birth" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="kf_touch_field">
                                <button type="button" id="btn_form_join" class="kode_btn_1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

 @if(request()->routeIs(''))
<script>
    document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("infoModal");
    if (modal) {
        modal.removeAttribute("hidden");
        modal.style.display = "block"; 
    }
    var closeBtn = document.querySelector(".infoModalClose");
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });
    }
    var btnCheck = document.getElementById("btn_check_join");
    if (btnCheck) {
        btnCheck.addEventListener("click", function () {
            var phoneInput = document.getElementById("join_phone_no");
            if (phoneInput.value.trim() === "") {
                alert("Please enter your phone number!");
                return;
            }
            document.getElementById("join_mobile").style.display = "none";
            document.getElementById("join_form").style.display = "flex";
        });
     }
  });
</script>
@endif
<script>
document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menuToggle");
    const closeMenu = document.getElementById("closeMenu");
    const mainNavbar = document.getElementById("mainNavbar");
    const parentMenus = document.querySelectorAll('.menu-item.kode-parent-menu > a');

    menuToggle.addEventListener("click", function () {
        mainNavbar.classList.add("active");
    });

    if (closeMenu) {
        closeMenu.addEventListener("click", function () {
            mainNavbar.classList.remove("active");
        });
    }
    parentMenus.forEach(function (link) {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            this.parentElement.classList.toggle("open");
        });
    });
});
</script>

        <main>
            @yield('content')
        </main>
        @stack('styles')
        <footer>
           @include('frontend.footer')                   
        </footer>
        
     <div id="custom-alert" style="
        display:none;
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 5px;
        font-weight: 600;
        color: white;
        z-index: 99999;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        max-width: 320px;">
      <span id="custom-alert-text"></span>
    </div>   
    

</body>
</html>
