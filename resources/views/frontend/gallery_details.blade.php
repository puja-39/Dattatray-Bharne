@extends('frontend.app')

@section('title',  $page_title)


@section('content')
<div class="kode_about_bg">
   <div class="container">
      <div class="kode_aboutus_wrap">
         <h4>{{ $page_title }}</h4>
         <div class="kode_bread_crumb">
            <ul>
               <li><a href="{{ url('/') }}">Home</a></li>
               <li><a href="{{ url('/gallery') }}">Gallery</a></li>
               <li><a href="javascript:void(0);">{{ $page_title }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>
  @php
     $images = !empty($gallery->images) ? explode(',', $gallery->images) : [];
     // dd($images);
  @endphp
  @if(!empty($images))
    <div class="kode_content">
       <section class="kf_team_listing_bg">
          <div class="container">
             <div class="row">
                @foreach($images as $img)
                    <div class="col-md-3 col-sm-3">
                        <a href="{{ asset('public/filemanager/'.$img) }}" data-fancybox="gallery">
                            <div class="kode_politician" style="height:auto; color:black; border:1px solid gray;">
                                <figure style="margin-bottom:0;">
                                    <img src="{{ asset('public/filemanager/'.$img) }}" alt="{{ $gallery->name ?? '' }}" style="object-fit:cover; width:100%; height:200px;">
                                </figure>
                            </div>
                        </a>
                    </div>
                @endforeach
             </div>
          </div>
       </section>
    </div>
@endif
@endsection
