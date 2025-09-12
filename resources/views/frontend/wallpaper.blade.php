@extends('frontend.app')

@section('title', 'Wallpaper')

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
@if(isset($wallpaper) && !empty($wallpaper))
   <div class="kode_content">
      <section class="kf_team_listing_bg">
         <div class="container">
            <div class="demo-gallery" id="image-download">
               <div id="download-gallery" class="list-unstyled">
                  @foreach($wallpaper as $key => $value)
                     @php
                        $images = $default_image ?? 'N/a';
                         if (!empty($value->url)) {
                           $image = asset('public/filemanager/'.$value->url);
                       }
                      @endphp
                     <div class="col-md-4 col-sm-6">
                        <div class="kode_politician" style="height:auto;">
                           <div class="kode_news_wrap">
                              <a class="item" 
                                 data-src="{{ $image  ?? 'n/a' }}" 
                                 data-sub-html="{{ $value->name ?? '' }}">
                                 <figure>
                                    {{-- <p>
                                       <img class="gallery_image"  src="{{ $image }}" alt="{{ $value->name }}" style=" background-position: cover; background-repeat: no-repeat;">
                                    </p>     --}}
                                    <p class="gallery_image"style="background-image: url('{{ $image }}');background-size: contain;background-position: center;background-repeat: no-repeat; width: 100%; aspect-ratio: 16 / 9;">
                                 </p>
                              </figure>
                           <figcaption class="kode_poli_img_des">
                             <span>{{ $value->name ?? '' }}</span>
                         </figcaption>
                       </a>
                         </div>
                           <div class="kode_news_wrap_des">
                              <div class="kf_btn_list text-center" id="special_button">
                                 <a class="kode_link_33" 
                                    href="{{ $image }}" 
                                    download="{{ ($value->name ?? 'Default') . '.' . pathinfo($image, PATHINFO_EXTENSION) }}">
                                    Download <i class="fa fa-download"></i>
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>
                  @endforeach
               </div>
            </div>
         </div>
          <center>
               <div class="kode_pagination">
                  {{ $wallpaper->links('pagination::bootstrap-4') }}
               </div>
            </center>
      </section>
   </div>
@endif

@endsection