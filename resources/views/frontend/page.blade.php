@extends('frontend.app')

@section('title', $page->name)

@section('content')

<div class="kode_about_bg">
    <div class="container">
        {{-- @php print_r($page) @endphp --}}
        <div class="kode_aboutus_wrap">
            <h4>{{ $page->name }}</h4>
            <div class="kode_bread_crumb">
                <ul>
                    <li><a href="{{ route('web.home')}}">Home</a></li>
                    <li><a href="javascript:void(0);">{{ $page->name }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="kode_where_bg">
    <div class="container">
        {!! $page->description ?? 'n/a' !!}
     {{-- @php print_r('description'); @endphp --}}
    </div>
</section>


@endsection