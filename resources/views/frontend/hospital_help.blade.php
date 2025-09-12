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
@if(isset($hospital_help) && $hospital_help->isNotEmpty())
    <div class="kode_content">
       <section class="kf_team_listing_bg">
          <div class="container">
             <div class="row">
                @foreach($hospital_help as $value)
                    @php
                        $image = $default_image ?? ''; 
                        $img = $value->image ?? '';
                        if (!empty($value->image)) {
                                  $image = asset('public/filemanager/'.$value->image);
                             }
                     @endphp
                    <div class="col-lg-4">
                       <div class="col-lg-12" style="border:1px solid #ccc; padding:0px; margin:0;">
                          <figure>
                              <img src="{{ $image }}" alt="{{ $value->name ?? '' }}">
                          </figure>
                          <div class="col-lg-12" style="padding-top:10px; ">
                             <h6>
                                <b>
                                   <a href="{{ url('hospital_help/'.$value->slug) }}">{{ $value->name ?? '' }}</a>
                                 </b>
                               </h6>
                             {{-- <span>{{ ($value->created_at) }}</span> --}}
                            </div>
                          {{-- <div class="col-lg-12" style="text-align: justify; overflow:hidden; margin-top:10px; ">
                             <p>{{ $value->short_description ?? '' }}</p>
                          </div> --}}
                       </div>
                    </div>
                @endforeach
             </div>
          </div>
       </section>
    </div>
@endif
@endsection