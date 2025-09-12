@extends('frontend.app')
@section('title', $page_title)
@section('content')
<div class="kode_about_bg">
   <div class="container">
      <div class="kode_aboutus_wrap">
         <h4>{{ $page_title ?? '' }}</h4>
         <div class="kode_bread_crumb">
            <ul>
               <li><a href="{{ route('web.home') }}">Home</a></li>
               <li><a href="{{ route('web.social_activity') }}">Blog</a></li>
               <li><a href="javascript:void(0);">{{ $page_title ?? '' }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

@if(isset($social_activity) && !empty($social_activity))
   <div class="kode_content">
      <section class="kf_team_listing_bg">
         <div class="container">
            <div class="row">
               @php
                   // default fallback
                   $image = asset('images/default.jpg'); 
                   if (!empty($social_activity->image) && file_exists(public_path('filemanager/'.$social_activity->image))) {
                       $image = asset('filemanager/'.$social_activity->image);
                   }
               @endphp

               <div class="col-lg-12">
                  <div class="col-lg-12" style="border:1px solid #ccc; padding:0px; margin:0;">
                     <figure style="text-align: center;">
                        <img src="{{ $image }}" alt="{{ $social_activity->name ?? '' }}">
                     </figure>
                     <div class="col-lg-12" style="padding-top: 10px;">
                        <h6>
                           <b>{{ $social_activity->name ?? '' }}</b>
                        </h6>
                        <span>
                           {{ !empty($social_activity->created_on) ? \Carbon\Carbon::parse($social_activity->created_on)->format('d M, Y') : '' }}
                        </span>
                     </div>
                     <div class="col-lg-12" style="text-align: justify; overflow:hidden; margin-top:10px;">
                        <p>{{ $social_activity->description ?? '' }}</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>
@endif

@endsection