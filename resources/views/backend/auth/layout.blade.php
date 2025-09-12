<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="app-url" content="{{ getBaseURL() }}">
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		<?php /*if(app_setting('seo_author')!=''){ ?>
            <meta name="author" content="<?php echo app_setting('seo_author'); ?>">
        <?php } ?>
        <?php if(app_setting('seo_visit_after')!=''){ ?>
            <meta name="revisit-after" content="<?php echo app_setting('seo_visit_after'); ?> days">
        <?php } ?>
        <?php if(app_setting('seo_description')!=''){ ?>
            <meta name="description" content="<?php echo app_setting('seo_description'); ?>">
        <?php } ?>
        <?php if(app_setting('seo_keywords')!=''){ ?>
            <meta name="keywords" content="<?php echo $this->seo_keywords; ?>">
        <?php }*/ ?>
		<link rel="icon" href="{{ static_asset('images/favicon.png') }}" type="image/x-icon"/>
        
		<title>@yield('page_title', translate('System')) - {{ app_setting('app_title') }} {{ app_setting('seo_title')!='' ? ' | '.app_setting('seo_title') : '' }}</title>
		<style>
            @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap");
            :root {
                --primary-bg-color:{{ app_setting('app_primary_color') }};
                --primary-bg-hover: #7c59e6;
                --primary-bg-border: #8c68f8;
                --dark-primary-hover: #233ac5;
                --primary-transparentcolor: #eaedf7;
                --darkprimary-transparentcolor: #2b356e;
                --transparentprimary-transparentcolor: rgba(255, 255, 255, 0.05);
            }
        </style>
        @if(app_setting("app_rtl","off") == 'on')
            <link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/bootstrap/css/bootstrap.rtl.min.css') }}">
        @else
            <link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/bootstrap/css/bootstrap.min.css') }}">
        @endif
        <link rel="stylesheet" href="{{ static_asset('assets/backend/css/icons.css') }}">
        <link rel="stylesheet" href="{{ static_asset('assets/backend/css/style.css') }}">
        <link rel="stylesheet" href="{{ static_asset('assets/backend/css/skins.css') }}">
        <link rel="stylesheet" href="{{ static_asset('assets/backend/css/dark-style.css') }}">
        <link rel="stylesheet" href="{{ static_asset('assets/backend/css/boxed.css') }}">
        <link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/notify/css/notify.css') }}">
        <link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/parsley/parsley.css') }}">

        <link rel="stylesheet" href="{{ static_asset('assets/backend/css/custom.css') }}">        

        <script type="text/javascript" src="{{ static_asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ static_asset('assets/backend/plugins/bootstrap/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
		<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/notify/js/notify.min.js') }}"></script>
		<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/parsley/parsley.min.js') }}"></script>
		<script type="text/javascript" src="{{ static_asset('assets/backend/js/custom.js') }}"></script>
        
		<script type="text/javascript" src="{{ static_asset('assets/backend/js/external.js') }}"></script>

	</head>
    @php
        $rtl = app_setting("app_rtl") == "on" ? 'rtl' : 'ltr';
        $layout = app_setting("app_layout") == "boxed" ? 'layout-boxed' : 'ltr';
    @endphp
	<body class="main-body {{ $rtl }} {{ $layout }} login-img">
		<div id="global-loader">
			<img src="<?php echo static_asset('images/loader.gif'); ?>" class="loader-img" alt="{{ translate('loader') }}">
		</div>
		<div class="page main-signin-wrapper">
			<div class="row ps-0 pe-0 ms-0 me-0">
				<div class=" col-xl-4 col-lg-4 col-md-4 d-block mx-auto">
					<div class="text-center mb-2">
						<a  href="{{ url('admin') }}">
                            <img src="{{ static_asset('images/logo.png') }}" class="header-brand-img" alt="{{ app_setting('app_title') }}">
                            <img src="<?php //echo uploads_url('logo-light.png'); ?>" class="header-brand-img theme-logos" alt="{{ app_setting('app_title') }}">
                        </a>
					</div>
					<div class="card custom-card">
						<div class="card-body pd-45">
                            @yield('content')
						</div>
							<div class="card-footer text-center">
                            <span>
                            	<p><?php echo translate('copyright') ?> © <?php echo date('Y') ?> <?php echo app_setting('app_title'); ?> <?php echo app_setting('app_footer_credit'); ?></p>
                            	<div class="dropdown">
									<a class="nav-link icon theme-layout nav-link-bg cursor-pointer layout-setting">
										<span class="dark-layout"><i class="fe fe-moon"></i></span>
										<span class="light-layout"><i class="fe fe-sun"></i></span>
									</a>
								</div>
                            </span>
                        </div>
					</div>
				</div>
			</div>
		</div>
        @yield('script');
	</body>
</html>