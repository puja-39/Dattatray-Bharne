@extends('frontend.app')
@section('title', $page_title)
@section('content') 

<div class="kode_about_bg">
   <div class="container">
      <div class="kode_aboutus_wrap">
         <h4>{{ $page_title }}</h4>
         <div class="kode_bread_crumb">
            <ul>
               <li><a href="{{ route('web.home') }}">Home</a></li>
               <li><a href="{{ route('web.our_indapur') }}">Our Indapur</a></li>
               <li><a href="javascript:void();">{{ $our_indapur->name }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

@if(isset($our_indapur) && !empty($our_indapur))
    <div class="kode_content">
        <section class="kf_team_listing_bg">
            <div class="container">
                <div class="row">
                    @php
                        $image = $default_image ??  asset('public/filemanager/Our Indapur/default.png');
                         $image = $our_indapur->image ?? '';
                         if (!empty($value->image)) {
                           $image = asset('/public/filemanager/'.$value->image);
                           }
                    @endphp
                    <div class="col-lg-12">
                        <div class="col-lg-12" style="border:1px solid #ccc; padding:0px; margin:0;">
                            <figure style="text-align: center;">
                                <img src="{{  asset('public/filemanager/' . $image ) }}"  alt="{{ $our_indapur->name ?? '' }}">
                            </figure>
                            <div class="col-lg-12" style="padding-top: 10px;">
                                <h6><b>{{ $our_indapur->name ?? '' }}</b></h6>
                                <span>{{ isset($our_indapur->created_on) ? display_datetime($our_indapur->created_on) : '' }}</span>
                            </div>
                            <div class="col-lg-12" style="text-align: justify; overflow:hidden; margin-top:10px;">
                                <p>{!! $our_indapur->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endif

@endsection