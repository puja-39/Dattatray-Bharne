@extends('frontend.app')

@section('title', 'Introduction')

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

<section class="kode_about_welcome">
   <div class="container">
      <div class="row">
         <div class="col-md-5">
            <div class="kode_welcome">
               <figure>
                  <img src="{{ asset('public\uploads\dattatray_bharane.jpg') }}" alt="Dattatray Bharane">
               </figure>
            </div>
         </div>
         <div class="col-md-7">
            <div class="kode_wel_demo_des">
               <h4>About Dattatray Bharane</h4>
               <p class="text-justify">
                  Dattatray Vithoba Bharane was born in Bharanewadi, Taluka Indapur, Maharashtra on 1 June 1968.
                  Shri. Bharane completed his schooling from Narayandas Ramdas High School, Indapur.
                  He went on to do his "Bachelor's in Commerce" from TC College Baramati.
                  For the first time, Shri. Bharane was elected as Director of Shri Chhatrapati Sahakari Sakhar Karkhana in 1992.
               </p>
               <p class="text-justify">
                  In 1996, Shri. Bharane was elected as Director of Pune District Central Cooperative Bank (PDCC).
                  During 1-year tenure of 2001 to 2002, Shri. Bharane was elected as the President of Pune District Central Cooperative Bank (PDCC).
                  Furthermore, he was elected as President of Shri Chhatrapati Sahakari Sakhar Karkhana for a period of 5 years starting from 2002 to 2007.
                  In 2009, Shri. Bharane made his debut in the Maharashtra Vidhan Sabha Elections by contesting from Indapur Constituency.
                  He lost this election by a narrow margin of votes. However, he never looked back and kept on with his political journey.
                  He was elected as President of Pune Zilla Parishad for a tenure of 2.5 years from 2012 to 2014.
                  For the first time in 2014, Dattatray Bharane was elected as a Member of Legislative Assembly (MLA) from Indapur Constituency.
               </p>
               <p class="text-justify">
                  In 2019, Shri. Bharane won the Maharashtra Vidhan Sabha Elections from Indapur Constituency for the second consecutive time.
                  On 30 December 2019, Shri. Bharane took an oath as the State Minister of Maharashtra.
                  As a State Minister, Shri. Bharane has taken the charge of Department of Public Works (excluding public enterprises),
                  Department of Soil and Water Conservation, Forestry, Animal Husbandry, Dairy Development and Fisheries, General Administration.
               </p>
            </div>
         </div>

         <div class="row">
            <div class="col-md-12" id="col-md-5-md">
               <img src="{{ asset('/public/uploads/introduction.jpg') }}" alt="Introduction">
            </div>
         </div>
      </div>
   </div>
</section>


@endsection