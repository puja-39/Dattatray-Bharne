<style>
    .myvertspace figure{
        margin-bottom: 20px !important;
    }
    .kode_banner ul.bxslider>li:before {
    background: none !important;
    position: fixed;
}
</style>
@extends('frontend.app')
@section('title', 'home')
@section('content')

@if(isset($desktop_slider) && $desktop_slider->isNotEmpty())
    <div class="kode_banner desktop-slider only-desktop" >
        <ul class="bxslider">
            @foreach ($desktop_slider as $key => $value)
                @php
                    $image = asset('assets/default.png'); 
                    if (!empty($value->image)) {
                        $image = asset('public/filemanager/'.$value->image);
                    }
                @endphp
                <li>
                    <img src="{{ $image }}" alt="{{ $value->name ?? 'N/A' }}"/>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@if(isset($mobile_slider) && $mobile_slider->isNotEmpty())
    <div class="kode_banner mobile-slider only-mobile">
        <ul class="bxslider">
            @foreach ($mobile_slider as $key => $value)
                @php
                    $image = asset('assets/default.png'); 
                    if (!empty($value->image)) {
                        $image = asset('public/filemanager/'.$value->image);
                    }
                @endphp
                <li>
                    <img src="{{ $image }}" alt="{{ $value->name ?? 'N/A' }}"/>
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div class="kode_content">
<section class="kode_welcome_bg">
    <div class="container">
        <div class="kode_hdg_1">
            <h6></h6>
            <h4>Introduction</h4>
        </div>
        <div class="kode_wel_outr_wrap tab-content" id="my-tab-content">
            <div class="row tab-pane active" id="about">
                <div class="col-md-5">
                    <div class="kode_welcome">
                        <figure>
                            <img src="{{ asset('public\uploads\dattatray_bharane.jpg') }}" alt="Dattatray Bharane">
                        </figure>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="kode_wel_demo_des">
                        <h6></h6>
                        <h4>About Dattatray Bharane</h4>
                        <p>
                            Dattatray Vithoba Bharane was born in Bharanewadi, Taluka Indapur, Maharashtra on 1 June 1968. Shri. Bharane completed his schooling from Narayandas Ramdas High School, Indapur. He went on to do his "Bachelor's in Commerce" from TC College Baramati. For the first time, Shri. Bharane was elected as Director of Shri Chhatrapati Sahakari Sakhar Karkhana in 1992.
                            <br />
                            In 1996, Shri. Bharane was elected as Director of Pune District Central Cooperative Bank (PDCC). During 1-year tenure of 2001 to 2002, Shri. Bharane was elected as the President of Pune District Central Cooperative Bank (PDCC). Furthermore, he was elected as President of Shri Chhatrapati Sahakari Sakhar Karkhana for a period of 5 years starting from 2002 to 2007. In 2009, Shri. Bharane made his debut in the Maharashtra Vidhan Sabha Elections by contesting from Indapur Constituency. He lost this election by a narrow margin of votes. However, he never looked back and kept on with his political journey. He was elected as President of Pune Zilla Parishad for a tenure of 2.5 years from 2012 to 2014. For the first time in 2014, Dattatray Bharane was elected as a Member of Legislative Assembly (MLA) from Indapur Constituency.
                            <br />
                            In 2019, Shri. Bharane won the Maharashtra Vidhan Sabha Elections from Indapur Constituency for the second consecutive time. On 30 December 2019, Shri. Bharane took an oath as the State Minister of Maharashtra. As a State Minister, Shri. Bharane has taken the charge of Department of Public Works (excluding public enterprises), Department of Soil and Water Conservation, Forestry, Animal Husbandry, Dairy Development and Fisheries, General Administration.
                        </p>
                        <a class="kode_link_3" href="{{ url('introduction') }}" >
                            See More <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="clearfix"></div>
  @if(isset($blog) && $blog->isNotEmpty())
    <section class="kode_welcome_bg" style="padding:0; margin:0;">
        <div class="container">
            <div class="kode_hdg_1">
                <h6></h6>
                <h4>Blog</h4>
            </div>
        </div>
    </section>

    <style type="text/css">
    .kode_wht_otr_wrap:after {
        background-image: url('{{ asset("public/uploads/blog.jpg") }}');
    }
  </style>
    <div class="kode_wht_otr_wrap">
        <div class="row">
            <div class="col-md-6 col-sm-6"></div>
            <div class="col-md-6 col-sm-12">
                <div class="kode_wht_des">
                    <h6></h6>
                    <h4>Latest Blog</h4>
                    <ul id="bxslider">
                        @foreach($blog as $value)
                            @php
                                $image = asset('assets/home/images/default.png'); 
                                if (!empty($value->image)) {
                                  $image = asset('public/filemanager/'.$value->image);
                               }
                            @endphp
                            <li>
                                <a href="{{ url('blog'.$value->slug) }}">
                                    <span class="blog_image_1"
                                          style="background-size:cover;background-repeat:no-repeat;background-image:url('{{ $image }}');">
                                    </span></a>
                                <div class="kode_wht_icon_des">
                                    <h6 style="font-size:1.3rem; margin:0;" class="blog_title_1">
                                        {{ $value->name ?? '' }}
                                    </h6>
                                    <div class="blog_description_1"
                                         style="height:auto; font-size:1.15rem; text-align:justify; color:whitesmoke; overflow:hidden;">
                                        {{ $value->short_description ?? '' }}
                                    </div>
                                    <a href="{{ url('blog'.$value->slug) }}" style="float:right; color:whitesmoke; text-decoration:none;">
                                        <u>Read More...</u>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="kode_press_link">
        <a class="kode_link_2"style="float:right; margin-right:1em; margin-top:1em;" href="{{ url('blog') }}" >See More</a>
    </div>
@endif

@if(isset($gallery) && $gallery->isNotEmpty())
    <section class="kode_latest_wrk_bg" style=" border:0; ">
        <div class="container">
            <div class="kode_hdg_1">
                <h6></h6>
                <h4>GALLERY</h4>
            </div>
        </div>
        <div id="show_1">
            <div class="filterable_container">
                @foreach ($gallery as $key => $value)
                    @php
                        $images = asset('assets/default.png');
                        $img = $value->images ?? 'n/a';
                       if (!empty($value->images)) {
                              $imageArray = explode(',', $value->images);
                              $firstImage = trim($imageArray[0]); 
                              $images = asset('public/filemanager/'.$firstImage);
                        }  
                    @endphp
                    <div class="home_gallery filterable-item">
                        <a id="t-link-1" href="{{ url('gallery/'.$value->slug) }}">
                            <div class="kode_galry_item">
                                <figure>
                                    <div class="gallery_image" id="t-image-1" style=" background-position: center; background-repeat: no-repeat; background-image:url('{{ $images }}');"></div>
                                </figure>
                                <div class="kode_galry_des">
                                    <p></p>
                                    <h6>
                                        <p id="title-1">{{ $value->name ?? '' }}</p>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="kode_press_link">
                <a class="kode_link_2" style=" float: right; margin-right:1em; margin-top:1em;"  href="{{ url('gallery') }}">See More</a>
            </div>
        </div>
    </section>
@endif


@if(isset($video) && $video->isNotEmpty())
    <section class="kode_welcome_bg" style="padding:0; margin:0;">
        <div class="container">
            <div class="kode_hdg_1">
                <h6></h6>
                <h4>RECENT Video</h4>
            </div>
        </div>
      </section>
     <section style=" display: flex; flex-wrap: nowrap; gap: 15px; overflow-x: auto; padding: 10px 0;">
        <div class="kode_video_bg" id="video-gallery"  >
            <div id="owl-demo2" class="owl-carousel owl-theme kode_video_list" >
                @foreach($video as $key => $value)
                    @php
                        $image = asset('assets/default.png');
                         if (!empty($value->image)) {
                           $video = asset('public/filemanager/'.$value->image);
                       }
                    @endphp
                    <a data-fancybox href="{{ $value->url }}">
                        <li data-src="" data-sub-html="{{ $value->name ?? '' }}">
                            <div class="kode_politician" style="border: 1px solid gray;">
                                <div class="transparance-css">
                                    <div class="image-play-preview">
                                        <i class="fa fa-play-circle-o fa-5x"></i>
                                    </div>
                                </div>
                                <figure>
                                    <img src="{{ $video }}" alt="{{ $value->name ?? '' }}">
                                </figure>
                                <figcaption class="kode_poli_img_des">
                                    <span>{{ $value->name ?? '' }}</span>
                                </figcaption>
                            </div>
                        </li>
                    </a>
                @endforeach
            </div>
        </div>

        <div style="width: 100%; height:1.2em; float:left;"></div>
        <div class="kode_press_link">
            <a class="kode_link_2" style="float:right; margin-right:1.2em;" href="{{ url('video') }}">See More</a>
        </div>
    </section>
@endif


@if(isset($hospital_help) && !empty($hospital_help))
<section class="kode_latest_wrk_bg" style="border:0;">
    <div class="container">
        <div class="kode_hdg_1">
            <h6></h6>
            <h4>Hospital Help</h4>
        </div>
    </div>
    <div class="kode_press_new_lst">
        <div class="row">
            @foreach($hospital_help as $key => $value)
                @php
                    $image = asset('assets/default.png');
                    if (!empty($value->image)) {
                        $image = asset('public/filemanager/' . $value->image);
                    }
                @endphp
                <div class="col-md-3 col-sm-6 myvertspace">
                    <figure>
                        <img src="{{ $image }}" alt="{{ $value->name ?? '' }}">
                    </figure>
                </div>
            @endforeach
        </div>
    </div>
    <div style="width: 100%; height:1.2em; float: left;"></div>
    <div class="kode_press_link">
        <a class="kode_link_2" style="float:right; margin-right:1.2em;" href="{{ url('hospital_help') }}">See More</a>
    </div>
</section>
@endif

@if(isset($journey) && $journey->isNotEmpty())
<section class="kode_politician_bg">
    <div class="container">
        <div class="kode_hdg_1">
            <h6></h6>
            <h4>Journey</h4>
        </div>
        <ul class="kode_camp_outr_wrap">
            @foreach($journey as $key => $value)
                @if($loop->index % 2 == 0)
                    <li>
                        <div class="kode_campagin_lst">
                            <div class="kode_campgn_lst2">
                                <div class="kode_cam_date visible-xs">
                                    <h4>{{ $value->month ?? '' }}</h4>
                                    <h6>{{ $value->year ?? '' }}</h6>
                                </div>
                                <div class="kode_lst1_des">
                                    <h6>{{ $value->name ?? '' }}</h6>
                                    <p align="justify">
                                        {{ $value->short_description ?? '' }}<br /><br />
                                    </p>
                                </div>
                                <div class="kode_cam_date hidden-xs">
                                    <h4>{{ $value->month ?? '' }}</h4>
                                    <h6>{{ $value->year ?? '' }}</h6>
                                </div>
                            </div>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="kode_campagin_lst">
                            <div class="kode_campgn_lst1">
                                <div class="kode_cam_date visible-xs">
                                    <h4>{{ $value->month ?? '' }}</h4>
                                    <h6>{{ $value->year ?? '' }}</h6>
                                </div>
                                <div class="kode_lst1_des">
                                    <h6>{{ $value->name ?? '' }}</h6>
                                    <p align="justify">
                                        {{ $value->short_description ?? '' }}<br /><br />
                                    </p>
                                </div>
                                <div class="kode_cam_date hidden-xs">
                                    <h4>{{ $value->month ?? '' }}</h4>
                                    <h6>{{ $value->year ?? '' }}</h6>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
        <div style="width: 100%; height: 1em; float: left;"></div>
        <div class="kode_press_link">
            <a class="kode_link_2" style=" float: right;" href="{{ route('web.journey') }}">See More</a>
        </div>
    </div>
</section>
@endif

</div>

<section class="kode_news_bg">
	<div class="container">
		<div class="kode_hdg_1">
			<h4>Follow </h4>
		</div>
		<div class="kode_press_new_lst">
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<div class="kode_press_news">
						<div class="social_name" style=" background-color:#0084b4;">Twitter</div>
						<a class="twitter-timeline" data-height="600" href="https://twitter.com/bharanemamaNCP">
							Tweets by Dattatray Bharane
						</a>
						<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="kode_press_news">
						<div class="social_name" style=" background-color: #3b5998;">Facebook</div>
						<div class="fb-page"data-href="https://facebook.com/bharanemamaNCP"data-tabs="timeline"data-width="555" data-height="600" data-small-header="false"data-adapt-container-width="true"
							data-hide-cover="false"data-show-facepile="true">
							<blockquote cite="https://www.facebook.com/bharanemamaNCP" class="fb-xfbml-parse-ignore">
								<a href="https://www.facebook.com/bharanemamaNCP">Dattatray Bharane</a>
							</blockquote>
						</div>
					</div>
				</div>

				<style type="text/css">
					.in_font_size_9 {
						font-size:.9rem;
					}
				</style>
				<div class="col-md-4 col-sm-6">
					<div class="kode_press_news">
						<div class="social_name" style=" background-color:#fbad50;">Instagram</div>
						<div id="instragram_div">
							<div class="col-lg-12">
								<div class="row m-0">
									<a style=" text-decoration:none; color:black;" href="https://www.instagram.com/bharanemamancp" target="_blank">
										<table class="font-12 margin-top-0" style="width:100%; margin-top:10px; border-bottom:1px solid silver;">
											<tr>
												<td rowspan="2" style=" width:70px; ">
													<img src="" class="profile-pic" style=" border-radius:50%;">
												</td>
												<td colspan="3">
													<b>
														<h6 class="username margin-top-5 margin-bottom-10"></h6>
													</b>
												</td>
											</tr>
											<tr>
												<td class="text-center">
													<p class="number-of-posts" style="line-height:11px;"></p>
													<br /> posts
												</td>
												<td class="text-center">
													<p class="followers" style="line-height:11px;"></p>
													<br /> followers
												</td>
												<td class="text-center">
													<p class="following" style="line-height:11px;"></p>
													<br /> following
												</td>
											</tr>
											<tr>
												<td colspan="5" class="text-left">
													<h6 class="in_name font-size-12 margin-top-0 margin-bottom-0 padding-bottom-0" hidden></h6>
													<h6 class="biography col-lg-12 margin-top-0 padding-top-0 in_font_size_9" style=" margin-top:10px; margin-bottom:7px;"></h6>
												</td>
											</tr>
										</table>
									</a>
									<div class="col-lg-12" style=" max-height:467px; overflow:scroll;">
										<div class="row posts"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="kode_contact_bg">
	<div class="container">
		<div class="kode_hdg_2">
		<h4>Contact Us</h4>
	</div>
	<div class="row">
		<div class="col-md-8">
		  <div class="kode_contact_wrap">
			 <div class="row">						
               <form id="homecontact"  novalidate>
                    @csrf             
                    <div class="col-md-6">
                        <div class="kode_contact_field">
                            <input type="text" id="name" autocomplete="off" name="name" value="{{ old('name') }}" placeholder="YOUR NAME :" required>
                            <span class="text-danger error-name"></span>                           
                        </div>
                       </div>                   
                    <div class="col-md-6">
                        <div class="kode_contact_field">
                            <input type="text" id="email" autocomplete="off" name="email" value="{{ old('email') }}" placeholder="EMAIL ADDRESS :">
                               <span class="text-danger error-email"></span>
                          </div>
                      </div>              
                    <div class="col-md-6">
                         <div class="kode_contact_field">
                            <input type="text" id="phone_no" autocomplete="off" name="phone_no" value="{{ old('phone_no') }}" placeholder="PHONE NUMBER :">
                              <span class="text-danger error-phone_no"></span>
                          </div>
                       </div>              
                    <div class="col-md-6">
                        <div class="kode_contact_field">
                            <input type="text" id="subject" autocomplete="off" name="subject" value="{{ old('subject') }}" placeholder="SUBJECT :">
                             <span class="text-danger error-subject"></span>                           
                          </div>
                       </div>             
                    <div class="col-md-12">
                        <div class="kode_contact_field">
                            <textarea  name="message" id="message" autocomplete="off" placeholder="YOUR MESSAGE :" class="fs-4">{{ old('message') }}</textarea>
                            <span class="text-danger error-message"></span>                            
                        </div>
                      </div>
                     <div class="col-md-6">
                        <div class="kode_contact_field">
                            <input type="text" id="captcha" autocomplete="off" name="captcha" value="{{ old('captcha') }}" placeholder="ENTER CAPTCHA :" >
                           <span class="text-danger error-captcha"></span>                        
                        </div>
                      </div>
                        <div class="col-md-2">
                          <div class="kf_touch_field" style="padding-top: 10px;">
                            {{-- <img src="{{ url('/captcha-image') }}" alt="captcha" id="home-captcha-img" style="cursor:pointer;" title="Click to refresh captcha" onclick="this.src='{{ url('/captcha-image') }}?'+Math.random()"> --}}
                            <img src="{{ route('captcha.image') }}" alt="captcha" id="contact-captcha-img" title="Click to refresh captcha" style="cursor:pointer; height:40px;">
                        </div>
                    </div>                
                      <div class="col-md-12">
                        <div class="kode_contact_field">
                            <span id="alert-text" class="pull-left text-left text-white pt-1"></span>
                         <button type="submit" id="contact_btn" class="pull-right">Submit</button>
                     </div>
                     </div>
                  </form>  
	   	       </div>
	         </div>
          </div>
			<div class="col-md-4">
				<div class="kode_contact_info kode_contact_wrap">
					<h5>Email Address</h5>
					<i class="fa fa-envelope-o"></i>
					<div class="kode_contact_des">
						<span><a href="mailto:contact@dattatraybharne.com">contact@dattatraybharne.com</a></span>
					</div>
				</div>
				<div class="kode_contact_info kode_contact_wrap">
					<h5>Phone</h5>
					<i class="fa fa-phone"></i>
					<div class="kode_contact_des">
						<span><a href="tel:02235347400">022 353 474 00</a></span>
					</div>
				</div>
				<div class="kode_contact_info kode_contact_wrap">
				 <h5>Janta Darbar</h5>
                  <a href="https://maps.app.goo.gl/n6HqWJQbiLdYcstTA"  target="_blank" rel="noopener noreferrer">
					<i class="fa-solid fa-location-dot"></i>
					<div class="kode_contact_des">
						<span>PDCC Bank Anthurne, Anthurne, Maharashtra - 413114</span>
					</div>
                    </a>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
  $(window).on('load', function(){
    $('.bxslider').bxSlider({
        mode: 'horizontal',auto: true,mode: 'fade',speed: 600,pause: 4000,pager: true,controls: true,adaptiveHeight: true
    });
 });
</script>
<script>
     $(document).ready(function(){
     $("#video-gallery").owlCarousel({
      loop: false,         
      margin: 10,           
      nav: true,           
      dots: false,         
      responsive: {
          0: { items: 1 }, 576: { items: 2 },768: { items: 3 }, 992: { items: 4 }    
      }
  });
});
</script>

<script>
    window.contactConfig = {
        captchaUrl: "{{ url('/captcha-image') }}",
        contactSubmitUrl: "{{ route('contact.submit') }}"
    };
</script>
@endsection