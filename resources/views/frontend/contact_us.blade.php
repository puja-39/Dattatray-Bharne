@extends('frontend.app')
@section('title', $page_title)
@push('styles')
<style>  

</style>
@endpush
@section('content')
<div class="kode_about_bg">
   <div class="container">
      <div class="kode_aboutus_wrap">
         <h4>{{ $page_title }}</h4>
         <div class="kode_bread_crumb">
            <ul>
               <li><a href="{{ route('web.home') }}">Home</a></li>
               <li><a href="{{ route('web.contact_us') }}">{{ $page_title }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>
<div class="kode_content">
   <div class="kf_contactus">
      <div class="kf_contact_map">
         {{-- <div class="map-canvas" style="background-image:url('{{ asset('/public/uploads/map.jpg') }}');"></div> --}}
      </div>
      <div class="kf_location_wrap" style=" opacity: 1.2;">
          <ul class="kf_office_name nav nav-tabs" id="tabs" role="tablist" style="margin: 0px 0px 50px 1px;">
              <li class="nav-item" style="border: 1px solid;">
                <a class="nav-link active" id="office1-tab" data-bs-toggle="tab" href="#office1" role="tab" aria-controls="office1" aria-selected="true">Janta Darbar</a>
              </li>
              <li class="nav-item" style="border: 1px solid;">
                <a class="nav-link" id="office2-tab" data-bs-toggle="tab" href="#office2" role="tab" aria-controls="office2" aria-selected="false">Party Office</a>
              </li>
            </ul>
         <div class="row tab-content" id="my-tab-content">
            <div class="tab-pane active" id="office1" role="tabpanel" aria-labelledby="office2-tab">
               <div class="col-md-6 col-sm-6">
                <a href="https://maps.app.goo.gl/n6HqWJQbiLdYcstTA"  target="_blank" rel="noopener noreferrer">
                  <div class="kf_location_info">
                     <i class="fa-solid fa-location-dot"></i>
                     <h6>Address</h6>
                     <p>PDCC Bank Anthurne, Anthurne, Maharashtra - 413114</p>
                  </div>
                   </a>
               </div>
               <div class="col-md-6 col-sm-6">
                  <div class="kf_location_info">
                     <i class="fa fa-send"></i>
                     <h6>Email Address</h6>
                     <a href="mailto:contact@dattatraybharne.com">contact@dattatraybharne.com</a>
                     <ul class="kf_loc_socil_icon">
                        <li><a target="_blank" href="https://facebook.com/bharanemamaNCP"><i class="fab fa-facebook fa-lg"></i></a></li>
                        <li><a target="_blank" href="https://twitter.com/bharanemamaNCP"><i class="fab fa-twitter fa-lg"></i></a></li>
                        <li><a target="_blank" href="https://instagram.com/bharanemamancp"><i class="fab fa-instagram fa-lg"></i></a></li>
                        <li><a target="_blank" href="https://www.youtube.com/channel/UCYP_5CvXZHBf2Cf-BcrhrVQ"><i class="fab fa-youtube fa-lg"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>

            <div class="tab-pane" id="office2" role="tabpanel" aria-labelledby="office2-tab">
               <div class="col-md-4 col-sm-4">
                  <a href="https://maps.app.goo.gl/mwbxwVUhX8NrTnWt5"  target="_blank" rel="noopener noreferrer">
                  <div class="kf_location_info">
                     <i class="fa-solid fa-location-dot"></i>
                     <h6>Address</h6>
                     <p>15, J.N. Heredia Marg, Ballard Estate, Fort, Mumbai, Maharashtra 400001</p>
                  </div>
                  </a>
               </div>
               <div class="col-md-4 col-sm-4">
                  <div class="kf_location_info">
                     <i class="fa fa-phone"></i>
                     <h6>Phone Number</h6>
                     <a href="tel:02235347400">022 3534 7400</a>
                  </div>
               </div>
               <div class="col-md-4 col-sm-4">
                  <div class="kf_location_info">
                     <i class="fa fa-send"></i>
                     <h6>Email Address</h6>
                     <a href="mailto:connect@ncp.org.in">connect@ncp.org.in</a>
                     <ul class="kf_loc_socil_icon">
                        <li><a target="_blank" href="https://www.facebook.com/bharanemamaNCP/"><i class="fab fa-facebook fa-lg"></i></a></li>
                        <li><a target="_blank" href="https://twitter.com/bharanemamaNCP"><i class="fab fa-twitter fa-lg"></i></a></li>
                        <li><a target="_blank" href="https://instagram.com/bharanemamancp"><i class="fab fa-instagram fa-lg"></i></a></li>
                        <li><a target="_blank" href="https://www.youtube.com/channel/UCYP_5CvXZHBf2Cf-BcrhrVQ"><i class="fab fa-youtube fa-lg"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
    <section>
    <div class="container">
        <div class="kode_hdg_1">
            <h4>Get in Touch with Us</h4>
        </div>
         <div class="row">
            <div class="col-md-12">
                <form id="contactform" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="kf_touch_field">
                                <input class="comming_place" name="name" value="{{ old('name') }}" type="text" placeholder="Your Name" required>
                                <span class="text-danger error-name"></span>
                            </div>
                         </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="kf_touch_field">
                                <input class="comming_place" name="email" value="{{ old('email') }}" type="text" placeholder="Email Address" required>
                                <span class="text-danger error-email"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="kf_touch_field">
                                <input class="comming_place" name="phone_no" value="{{ old('phone_no') }}" type="text" placeholder="Phone Number" required>
                                <span class="text-danger error-phone_no"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="kf_touch_field">
                                <input class="comming_place" name="subject" value="{{ old('subject') }}" type="text" placeholder="Subject" required>
                                <span class="text-danger error-subject"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="kf_touch_field">
                                <textarea class="comming_place" name="message" placeholder="Message" required>{{ old('message') }}</textarea>
                                <span class="text-danger error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="kf_touch_field d-flex align-items-center gap-2">
                                <input class="comming_place" name="captcha" type="text" placeholder="Enter Captcha" required style="flex:1;">
                                 <span class="text-danger error-captcha"></span>
                                 {{-- <img src="{{ url('/captcha-image') }}" alt="captcha" id="contact-captcha-img"    title="Click to refresh captcha"  style="cursor:pointer; height:48px;" title="Click to refresh captcha" onclick="this.src='{{ url('/captcha-image') }}?'+Math.random()"> --}}
                                 <img src="{{ route('captcha.image') }}" alt="captcha" id="contact-captcha-img" title="Click to refresh captcha" style="cursor:pointer; height:48px;">
                              </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="kf_touch_field">
                                <button type="submit" id="contact_btn" class="kode_btn_1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
             </div>
            <div class="col-md-3">
                <div class="kf_touch_img"></div>
            </div>
        </div>
    </div>
   </section>
</div>
<div class="clearfix"></div>

<script>
    window.contactConfig = {
        captchaUrl: "{{ route('captcha.image') }}",
        contactSubmitUrl: "{{ route('contact.submit') }}"
    };
</script>

@endsection
