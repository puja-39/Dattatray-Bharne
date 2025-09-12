@extends('frontend.app')

@section('title',  $page_title)

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
@if(isset($gallery) && !empty($gallery))
	<div class="kode_content">
	   <section class="kf_team_listing_bg">
	      <div class="container">
	         <div class="row">     	
            @foreach($gallery as $value)
                    @php
                    $images = explode(',', $value->images); 
                	//  dd($images);    
                    $cover = !empty($images[0])? asset('public/filemanager/'.$images[0]): asset('images/no-image.png');
                @endphp               
                    <a href="{{ route('web.gallery_details', $value->slug) }}">
                        <div class="col-md-3 col-sm-3">
                            <div class="kode_politician" id="opacity_off" style="height:auto; color:black; border: 1px solid gray;">
                                <figure>
                                    <img src="{{ $cover }}" alt="{{ $value->name ?? '' }}" style="object-fit: cover; object-position: center; width:100%; height:100%;">
                                </figure>
                                <div class="kode_news_wrap_des">
                                    <span style="padding-bottom:10px; color:black;">
                                        <center>
                                            <h6><a>{{ $value->name ?? '' }}</a></h6>
                                        </center>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
	         </div> 
              <center>
               <div class="kode_pagination">
                  {{ $gallery->links('pagination::bootstrap-4') }}
               </div>
            </center>        
	         {{-- <center>
	            <div class="kode_pagination">
	               <ul class="pagination">
	                  <li><a href="#">1</a></li>
	                  <li style="float: right;"><a href="/tag/gallery-timeline/page/2/">NEXT</a></li>
	                  <li style="float: right;"><a href="/tag/gallery-timeline/page/244/">244</a></li>
	                  <li style="float: right;"><a href="/tag/gallery-timeline/page/2/">2</a></li>
	                  <li style="border:0; background:none;">..............</li>
	               </ul>
	            </div>
	         </center> --}}
	        
	      </div>
	   </section>
	</div>
@endif


@endsection