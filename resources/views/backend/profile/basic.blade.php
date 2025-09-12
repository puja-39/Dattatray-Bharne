@extends('backend.app')
@section('page_title'){{ translate('Profile') }}@endsection
@section('content')
<div class="page-header">
	<div>
		<h2 class="main-content-title tx-24 mg-b-5">{{ translate('Profile') }}</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('Dashboard') }}</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{ translate('Profile') }}</li>
		</ol>
	</div>
</div>
<div class="row sidemenu-height">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
        <div class="card custom-card">
            <div class="card-body">
				<form action="{{ $page_action }}" class="data-parsley-validate" method="post" data-block_form="true" enctype="multipart/form-data" data-multipart="true"> 
                	<div class="row">
	                    <div class="col-12 col-sm-12 text-center">
	                      	<img class="app-image-input img-thumbnail" data-name="profile_image" src="<?php //echo user_setting('profile_image'); ?>" style="height:128px;cursor:pointer;" data-bs-toggle="tooltip" data-placement="top" title="{{ translate('click_on_the_image_to_change') }}"/>
	                      	<p><small class="text-muted"><i>{{ translate('Click on the image to change').' '.translate('Best size is 400px X 400px') }}</i></small></p>
	                    </div>
                  	</div>
					<div class="row">
						<div class="col-12 col-sm-12 text-center"><hr/>
							<div class="form-group">
								<button type="submit" class="btn ripple btn-primary btn-block" tabindex="1" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span>{{ translate('Please Wait...') }}">{{ translate('update') }} </button>
								<?php /*if(user_setting('profile_image')!=uploads_url('profile/default.png')){ ?>
								<button type="button" class="btn ripple btn-danger btn-block btn-remove-profile-picture" tabindex="2" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span> {{ translate('please_wait...') }}" data-url="<?php //echo admin_site_url('profile/crud') ?>" data-action="remove_profile">{{ translate('remove') }}</button>
								<?php } */?>
							</div>
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="card custom-card main-content-body-profile">
            <nav class="nav main-nav-line">
                <a class="nav-link active" data-bs-toggle="tab" href="#basic">{{ translate('Basic Details') }}</a>
            </nav>
            	<div class="card-body tab-content h-100">
					<div class="tab-pane active">
						<form action="{{ $page_action }}" class="data-parsley-validate" method="post" data-block_form="true">
							<div class="row">
								<div class="col-12 col-sm-6">
									<div class="form-group">
									<label>{{ translate('Username') }}<span class="text-danger">*</span></label>
									<input type="text" class="form-control" placeholder="{{ translate('username') }}" value="{{ isset($user['username']) && $user['username'] != '' ? $user['username'] : ''  }}" readonly disabled/>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
									<label>{{ translate('Name') }} <span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="name" placeholder="{{ translate('name') }}" tabindex="1" value="{{ isset($user['name']) && $user['name'] != '' ? $user['name'] : ''  }}" autofocus required />
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
									<label>{{ translate('Mobile') }}<span class="text-danger">*</span></label><br/>
									<input type="tel" class="form-control mobile_no" name="mobile_no" placeholder="<?php echo translate('mobile no'); ?>" tabindex="2" value="{{ isset($user['mobile_no']) && $user['mobile_no'] != '' ? $user['mobile_no'] : ''  }}" data-parsley-errors-container="#error_mobile_no" required />
									<input type="hidden" name="country_code" id="country_code" value="{{ isset($user['country_code']) && $user['country_code'] != '' ? $user['country_code'] : ''  }}" required />
									<span id="error_mobile_no"></span>
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
									<label>{{ translate('email') }}<span class="text-danger">*</span></label>
									<input type="text" class="form-control" name="email_id" placeholder="{{ translate('email id') }}" tabindex="3" value="{{ isset($user['email_id']) && $user['email_id'] != '' ? $user['email_id'] : ''  }}" required />
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12"><hr/></div>
							<div class="col-12 text-center">
								<button type="submit" class="btn btn-primary mt-2 mr-1" tabindex="4" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span> <?php echo translate('please_wait...'); ?>"><i data-feather='save'></i> <?php echo translate('save'); ?></button>
							</div>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
	<?php /*<script type="text/javascript">
		var input = document.querySelector(".mobile_no");
		@if(isset($user['country_code']) && $user['country_code'] != '' ? $user['country_code'] : '')
		   var iti = window.intlTelInput(input, {
			  initialCountry: "IN",
			  separateDialCode: true,
			  nationalMode: true,
			  setCountry: 'iso2',
			  utilsScript: "{{ static_asset('assets/backend/plugins/intl-tel-input/js/utils.js') }}",
		   });
		@else
		   var iti = window.intlTelInput(input, {
			  initialCountry: "auto",
			  separateDialCode: true,
			  nationalMode: true,
			  geoIpLookup: function(success, failure) {
				 $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
					var countryCode = (resp && resp.country) ? resp.country : "in";
					success(countryCode);
				 });
			  },
			  utilsScript: "{{ static_asset('assets/backend/plugins/intl-tel-input/js/utils.js') }}",
		   });
		@endif
		input.addEventListener("countrychange", function() {
		   $("#country_code").val(iti.getSelectedCountryData().dialCode);
		});
		window.ParsleyValidator.addValidator('mnvalidator',function (value, requirement) {
			return iti.isValidNumber();
		}, 3);
	</script> */ ?>
</div>
@endsection