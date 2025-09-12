@extends('frontend.app')
@section('title', $page_title)
@push('styles')
<style>  
 /* .modal-backdrop {
        z-index: 999 !important;
    }
      .modal-content {
        z-index: 1050 !important;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 50%;
        height: 50%;
        overflow: auto;
        background-color: rgba(0,0,0,0.6);
    }
    
    .modal[hidden] {
        display: none;
    }
    
    .modal:not([hidden]) {
        display: block;
 } */
 
    .modal-backdrop {
    z-index: 999 !important;
}
.modal-content {
    z-index: 1050 !important;
}


</style>
@endpush
@section('content')
<div class="kode_about_bg">
   <div class="container">
      <div class="kode_aboutus_wrap">
         <h4>{{ $page_title }}</h4>
         <div class="kode_bread_crumb">
            <ul>
               <li><a href="{{ route('web.home') }}">Home</a></li>
               <li><a href="javascript:void();">{{ $page_title }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>

@if(isset($ringtone) && count($ringtone) > 0)
   <div class="kode_content">
      <section class="kf_team_listing_bg">
         <div class="container">
            <div class="row">
               @foreach($ringtone as $key => $value)
                  @php
                     $image = $default_image ?? '';
                     // $img = isset($value->image) && $value->image != '' ? $value->image : '';
                     if (!empty($value->image)) {
                           $image = asset('public/filemanager/'.$value->image);
                       }
                        // dd($image);
                     $audio = asset('public/filemanager/'.$value->url);
                     // dd($audio);
                  @endphp
                  <div class="ringtone-icon" style="width:100%; float:left; border-bottom:1px solid gray; padding-top:15px;">
                     <div class="col-md-8">
                        <table>
                           <tr><td class="td-1"><i class="fa fa-music fa-5x" aria-hidden="true"></i></td><td>
                                 <div class="kode_news_detail">
                                    <blockquote>
                                       <p>{{ $value->name ?? '' }}</p>
                                    </blockquote>
                                 </div>
                              </td>
                           </tr>
                        </table>
                     </div>
                   <div class="col-md-4">
                     
                     <div class="kf_btn_list" style="padding: 0; margin: 0;">
                           {{-- <a href="javascript:void(0);" data-url="{{ $audio }}" data-img="{{ $image }}" class="kode_link_11 audio-play" style="cursor:pointer;" >
                               Play <i class="fa fa-play"></i>
                           </a> --}}
                          <a href="javascript:void(0);" 
   class="kode_link_11 audio-play" 
   data-url="{{ $audio }}" 
   data-img="{{ $image }}" 
   style="cursor:pointer;">
   Play <i class="fa fa-play"></i>
</a>

                            <a class="kode_link_33" href="{{ $audio }}" download="{{ ($value->name ?? 'Default') .'.'. pathinfo($audio, PATHINFO_EXTENSION) }}">
                               Download <i class="fa fa-download"></i>
                            </a>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
         </div>
   </section>
</div>
{{-- <div class="modal fade" id="audioPlayer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-focus="false">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body" style="padding:0%; background-color:white;">
           <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"style="position:absolute; right:10px; top:4px; background:none; color:white; font-size:3rem; border:0;">
                   <i class="fa fa-times" style="color:#eee;"></i></button>   
             </div>
          <img id="ringtone_image" src="{{ $image ?? '' }}" alt="Ringtone Image">
         <div class="col-lg-12" style="padding-top:10px; padding-bottom:10px; background:#ff9933;">
            <div id="audio-body">
               <audio id="audio" preload="auto" controls autoplay>
                   <source id="play" src="{{ $audio ?? 'n/a' }}">
               </audio>
            </div>
         </div>
      </div>
   </div>
</div>  --}}

<div class="modal fade" id="audioPlayer" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body p-0" style="background:white;">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" 
          style="position:absolute; right:10px; top:4px; background:none; color:white; font-size:3rem; border:0;">
        </button>
      </div>
      <img id="ringtone_image" src=" {{ $image }} " alt="Ringtone Image">
      <div class="col-lg-12 py-2" style="background:#ff9933;">
        <div id="audio-body">
          <audio id="audio" preload="auto" controls autoplay>
            <source id="play" src=" {{ $audio }} ">
          </audio>
        </div>
      </div>
    </div>
  </div>
</div>

@endif

<script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".audio-play").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const audioUrl = this.getAttribute("data-url");
      const imgUrl = this.getAttribute("data-img");

      document.getElementById("ringtone_image").src = imgUrl;
      document.getElementById("play").src = audioUrl;

      const modal = new bootstrap.Modal(document.getElementById("audioPlayer"));
      modal.show();
    });
  });
});
</script>






@endsection