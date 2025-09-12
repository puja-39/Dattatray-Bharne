<footer>
    <div class="kode_newsletter_bg">
        <div class="container">
            <div class="kode_newsletter_des">
                <h5>Subscribe</h5>
                <h3>Newsletter</h3>
            </div>
             <div class="kode_newsletter_form">
                 <form id="subscribe_user" novalidate>
                     @csrf
                     <input class="placeholder2" id="newsletter_email" name="newsletter_email" type="text" placeholder="Enter Email">
                     <span class="text-danger error-newsletter_email" style="color: #000"></span>
                     <button type="submit" id="newsletter_email"><i class="fa fa-send"></i></button>
                     <span id="f-alert-text"></span>
                 </form>
             </div>
        </div>
    </div>
    <div class="kode_footer_bg">
        <div class="container">
            <div class="kode_footer_logo">
                <figure>
                    <a href="{{ route('web.home') }}">
                        <img src="{{ asset('public\uploads\logo_footer.png') }}" alt="Dattatray Bharane">
                    </a>
                </figure>
                <ul>
                    <li><a target="_blank" href="https://facebook.com/bharanemamaNCP"><i class="fab fa-facebook fa-lg" style="line-height: 2.05em;"></i></a></li>
                    <li><a target="_blank" href="https://twitter.com/bharanemamaNCP"><i class="fab fa-twitter fa-lg" style="line-height: 2.05em;"></i></a></li>
                    <li><a target="_blank" href="https://instagram.com/bharanemamancp"><i class="fab fa-instagram fa-lg" style="line-height: 2.05em;"></i></a></li>
                    <li><a target="_blank" href="https://www.youtube.com/channel/UCYP_5CvXZHBf2Cf-BcrhrVQ"><i class="fab fa-youtube fa-lg" style="line-height: 2.05em;"></i></a></li>
                </ul>
            </div>          
            <div class="kf_page_list" style="text-align: center;">
                 @php
                   $page = App\Models\Page::get()->where('is_active',1);
                @endphp
                <ul  >
                      @foreach ($page as $page)
                        <li><a href="{{ route('web.page', ['slug' => $page->slug]) }}">{{ $page->name }}</a></li>
                      @endforeach
                 </ul>
              </div>
            <div class="kode_copyright text-center" style=" display: flex; justify-content: center;  align-items: center; flex-direction: column; height: 100px; ">
                <p> Copyright ©  {{ date('Y') }} {{ $title ?? '' }}  Official Web Site of Dattatray Bharne</p>
                <a class="kode-back-top" href="javascript:void(0);"><i class="fa fa-angle-up"></i></a>
            </div>
        </div>
    </div>
</footer>
<a target="_blank" href="https://whatsapp.com/channel/0029Va9SkdSEQIakQrOBnj2M" style="position: fixed; bottom: 30px; left: 20px;" >  
    <span class="s_8 waves-effect waves-light ctc-analytics" style="display: flex; padding: 0 2rem; letter-spacing: .5px; transition: .2s ease-out; text-align: center; justify-content: center; align-items: center; border-radius:2px; height:36px; line-height:36px; vertical-align:middle; box-shadow:0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12), 0 3px 1px -2px rgba(0,0,0,.2); box-sizing:inherit; background-color:#26a69a;">
          <i class="fab fa-whatsapp fa-lg" style="color: #ffffff;"></i>
               <g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1">
                  <path d="M259.253137,0.00180389396 C121.502859,0.00180389396 9.83730687,111.662896 9.83730687,249.413175 C9.83730687,296.530232 22.9142299,340.597122 45.6254897,378.191325 L0.613226597,512.001804 L138.700183,467.787757 C174.430395,487.549184 215.522926,498.811168 259.253137,498.811168 C396.994498,498.811168 508.660049,387.154535 508.660049,249.415405 C508.662279,111.662896 396.996727,0.00180389396 259.253137,0.00180389396 L259.253137,0.00180389396 Z M259.253137,459.089875 C216.65782,459.089875 176.998957,446.313956 143.886359,424.41206 L63.3044195,450.21808 L89.4939401,372.345171 C64.3924908,337.776609 49.5608297,295.299463 49.5608297,249.406486 C49.5608297,133.783298 143.627719,39.7186378 259.253137,39.7186378 C374.871867,39.7186378 468.940986,133.783298 468.940986,249.406486 C468.940986,365.025215 374.874096,459.089875 259.253137,459.089875 Z" fill="#ffffff"></path>
              </g> &nbsp; 
        <span class="ht-ctc-s8-text s8_span ctc-analytics ctc_cta" style="color:#ffffff;"> Join Official WhatsApp Channel </span>
    </span> 
</a>
<style type="text/css">
    .kode_footer_bg .fa { margin-top: 10px; }
</style>

<style>
    .instagram-post {
        box-shadow: 0px 0px 3px 0px silver;margin-top: 5px;margin-bottom: 5px;border-radius: 5px;
    }
</style>
<script src="{{ static_asset_home('js/jquery-3.6.0.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
<script src="{{ static_asset_home('js/parsley.min.js') }}"></script>
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
{{-- <script src="{{ asset('assets/home/js/audioplayer.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/home/js/fancybox.min.js') }}"></script> --}}
<script src="{{ asset('assets/backend/plugins/fancybox/fancybox.umd.js') }}"></script>
<script src="{{ asset('assets/home/js/enquiry.js') }}"></script>
<script src="{{ asset('assets/home/js/contacts.js') }}"></script>
<script src="{{ asset('assets/home/js/jquery.dlmenu.js') }}"></script>


{{-- <script>
    const contactUrl = "{{ route('contact.submit') }}";
    const captchaUrl = "{{ url('/captcha-image') }}";
</script> --}}

<script>
    $(document).ready(function(){
        $('.bxslider').bxSlider({
            auto: true, autoControls: true,pager: 'false',nextSelector: '#slider-next',
            prevSelector: '#slider-prev',nextText: '<i class="fa fa-caret-right"></i>',prevText: '<i class="fa fa-caret-left"></i>'
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const btn = document.querySelector('.kode-back-top');
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0, behavior: 'smooth' ,
        });
    });
});
</script>
<script>
    window.routes = {
        subscribe: "{{ route('admin.enquiry.new_subscribe') }}"
    };
</script>











