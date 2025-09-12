@extends('frontend.app')

@section('title', 'Our Indapur')

@section('content')

<div class="kode_about_bg">
   <div class="container">
      <div class="kode_aboutus_wrap">
         <h4>{{ $page_title ?? '' }}</h4>
         <div class="kode_bread_crumb">
            <ul>
               <li><a href="{{ route('web.home') }}">Home</a></li>
               <li><a href="javascript:void(0);">{{ $page_title ?? '' }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

@if(isset($our_indapur) && $our_indapur->isNotEmpty())
   <div class="kode_content">
      <section class="kf_team_listing_bg">
         <div class="container">
            <div class="row">
               @foreach ($our_indapur as $value)
                  @php
                     $image = $default_image ?? 'default.jpg';
                     $img   = $value->image ?? 'n/a';
                     if (!empty($value->image)) {
                           $image = asset('public/filemanager/'.$value->image);
                       }
                  @endphp
                  <div class="col-lg-4">
                     <div class="col-lg-12" style="border:1px solid #ccc; padding:0px; margin:0;">
                        <figure>
                           <img src="{{ $image }}" alt="{{ $value->name ?? '' }}"> 
                        </figure>
                        <div class="col-lg-12" style="padding-top: 10px;">
                           <h6>
                              <b>
                              <a href="{{ route('web.our_indapur_details', $value->slug) }}">
                                    {{ $value->name ?? '' }}
                                </a>
                              </b>
                           </h6>
                           <span>{{ $value->created_at ? \Carbon\Carbon::parse($value->created_on)->format('d M, Y') : '' }}</span>
                        </div>
                        <div class="col-lg-12" style="text-align: justify; overflow:hidden; margin-top:10px;">
                           <p>{{ $value->short_description ?? '' }}</p>
                        </div>
                        <div class="col-lg-12 text-right" style="padding-bottom:55px;">
                           <div class="kode_press_link">
                             <a class="kode_link_2" style="float: right; margin-right:1em; margin-top:0em;"
                                 href="{{ route('web.our_indapur_details', $value->slug) }}">
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
                  {{ $our_indapur->links('pagination::bootstrap-4') }}
               </div>
            </center>
         </div>
      </section>
   </div>
@endif

@endsection