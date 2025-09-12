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
               <li><a href="javascript:void(0);">{{ $page_title }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

@if(isset($blog) && !empty($blog))
    {{-- @php dd($blog); @endphp --}}
   <div class="kode_content">
      <section class="kf_team_listing_bg">
         <div class="container">
            <div class="row">
               @foreach($blog as $key => $value)
                    @php
                        // $images = asset('assets/default.png');
                        $img = $value->image ?? 'n/a';
                        //  dd($value->image);
                       if (!empty($value->image)) {
                           $image = asset('public/filemanager/'.$value->image);
                       }
                       
                    @endphp
                           {{-- @php  dd($image);@endphp --}}
                  <div class="col-lg-4">
                     <div class="col-lg-12" style="border:1px solid #ccc; padding:0px; margin:0;">
                        <figure>
                           <img src="{{ $image }}" alt="{{ $value->name ?? '' }}">
                           {{-- @php  dd($image);@endphp --}}
                        </figure>
                        <div class="col-lg-12" style="padding-top: 10px;">
                           <h6>
                              <b>
                                 <a href="{{ route('web.blog_details' , $value->slug) }}">{{ $value->name ?? '' }} </a>
                              </b>
                           </h6>
                           <span>{{ ($value->created_at) }}</span>
                             {{-- @php dd($value->created_at); @endphp --}}
                        </div>
                        <div class="col-lg-12" style="text-align: justify; overflow:hidden; margin-top:10px;">
                           <p>{{ $value->short_description ?? '' }}</p>
                        </div>
                        <div class="col-lg-12 text-right" style="padding-bottom:55px;">
                           <div class="kode_press_link">
                              <a class="kode_link_2" style="float: right; margin-right:1em; margin-top:0em;" 
                                 href="{{ route('web.blog_details' , $value->slug) }}">
                                 Read More
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
            <center>
               <div class="kode_pagination">
                  {{ $blog->links('pagination::bootstrap-4') }}
               </div>
            </center>
           {{-- <center>
                <div class="kode_pagination">
                    <ul class="pagination">
                        <li><a href="#">1</a></li>
                        <li style="float: right;"><a href="{{ url('/tag/blog-timeline/page/2') }}">NEXT</a></li>
                        <li style="float: right;"><a href="{{ url('/tag/blog-timeline/page/244') }}">244</a></li>
                        <li style="float: right;"><a href="{{ url('/tag/blog-timeline/page/2') }}">2</a></li>
                        <li style="border: 0; background: none;">..............</li>
                    </ul>
                </div>
            </center> --}}
         </div>
      </section>
   </div>
@endif


@endsection