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
               <li><a href="javascript:void(0);">About Us</a></li>
               <li><a href="javascript:void(0);">{{ $page_title }}</a></li>
            </ul>
         </div>
      </div>
   </div>
</div>
<section class="kode_where_bg"> 
    <div class="container">
        @if(isset($journey) && $journey->isNotEmpty())
            <ul class="kode_camp_outr_wrap">
                @foreach($journey as $i => $value)
                    @if($i % 2 == 0)
                        <li>
                            <div class="kode_campagin_lst">
                                <div class="kode_campgn_lst2">
                                    <div class="kode_cam_date visible-xs">
                                        <h4>{{ $value->month ?? '' }}</h4>
                                        <h6>{{ $value->year ?? '' }}</h6>
                                    </div>
                                    <div class="kode_lst1_des">
                                        <h6>{{ $value->name ?? '' }}</h6>
                                        <p align="justify">
                                            {{ $value->short_description ?? '' }}<br><br>
                                        </p>
                                    </div>
                                    <div class="kode_cam_date hidden-xs">
                                        <h4>{{ $value->month ?? '' }}</h4>
                                        <h6>{{ $value->year ?? '' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @else
                        <li>
                            <div class="kode_campagin_lst">
                                <div class="kode_campgn_lst1">
                                    <div class="kode_cam_date visible-xs">
                                        <h4>{{ $value->month ?? '' }}</h4>
                                        <h6>{{ $value->year ?? '' }}</h6>
                                    </div>
                                    <div class="kode_lst1_des">
                                        <h6>{{ $value->name ?? '' }}</h6>
                                        <p align="justify">
                                            {{ $value->short_description ?? '' }}<br><br>
                                        </p>
                                    </div>
                                    <div class="kode_cam_date hidden-xs">
                                        <h4>{{ $value->month ?? '' }}</h4>
                                        <h6>{{ $value->year ?? '' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div style="width: 100%; height: 1em; float: left;"></div>
        @endif      
    </div>
</section>


@endsection