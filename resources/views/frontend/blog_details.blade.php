@extends('frontend.app')
@section('title', $page_title)
@section('content')

  <div class="kode_about_bg">
   <div class="container">
      <div class="kode_aboutus_wrap">
         <h4>{{ $page_title }}</h4>
         <div class="kode_bread_crumb">
            <ul>
               <li><a href="{{ url('/') }}">Home</a></li>
               <li><a href="{{ url('/blog') }}">Blog</a></li>
               <li><a href="javascript:void(0);">{{ $blog->name }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

@if(isset($blog) && !empty($blog))
    <div class="kode_content">
       <section class="kf_team_listing_bg">
          <div class="container">
             <div class="row">
                @php
                    // Default image fallback
                    $image = $default_image ?? asset('images/no-image.png');
                    $image = $blog->image ?? '';
                  //   dd($img);
                  //   $image = asset('public/uploads/default.png'); 
                   if (!empty($value->image)) {
                     $image = asset('/public/filemanager/'.$value->image);
                  }
                  // dd( $image);
                  @endphp
                <div class="col-lg-12">
                   <div class="col-lg-12" style="border:1px solid #ccc; padding:0px; margin:0;">
                      <figure style="text-align: center;">
                         <img src="{{  asset('public/filemanager/' . $image ) }}" alt="{{ $blog->name ?? '' }}">
                           {{-- @php dd( $image); @endphp --}}
                      </figure>

                      <div class="col-lg-12" style="padding-top: 10px;">
                         <h6><b>{{ $blog->name ?? '' }}</b></h6>
                         <span>{{ \Carbon\Carbon::parse($blog->created_on)->format('d M Y, h:i A') }}</span>
                      </div>

                      <div class="col-lg-12" style="text-align: justify; overflow:hidden; margin-top:10px;">
                         <p>{!! $blog->description ?? '' !!}</p>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </section>
    </div>
@endif


@endsection