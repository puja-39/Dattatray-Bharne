@extends('frontend.app')

@section('title', 'video')

@section('content')
<div class="kode_about_bg">
   <div class="container">
      <div class="kode_aboutus_wrap">
         <h4>{{ $page_title }}</h4>
         <div class="kode_bread_crumb">
            <ul>
               <li><a href="{{ route('web.home') }}">Home</a></li>
               <li><a href="javascript:void(0);">{{ $page_title }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

@if(isset($video) && !empty($video))
   <div class="kode_content">
      <section class="kf_team_listing_bg">
         <div class="container">
            <div class="demo-video">
               <ul id="lightvideo" class="list-unstyled">
                  @foreach($video as $key => $value)
                     @php
                        $image = public_path('assets/default.png'); 
                        $img = $value->image ?? '';
                        if (!empty($value->image)) {
                           $video = asset('public/filemanager/'.$value->image);
                       }
                        // dd($video);
                     @endphp
                     <a data-fancybox href="{{ $value->url }}">
                        <li class="col-md-6 col-sm-6" data-src="" data-sub-html="{{ $value->name ?? '' }}">
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
               </ul>
            </div>
         </div>
      </section>
   </div>
@endif



@endsection