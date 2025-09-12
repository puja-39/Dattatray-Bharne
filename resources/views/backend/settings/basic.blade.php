@extends('backend.app')
@section('page_title'){{ translate('Basic Settings') }}@endsection
@section('content')
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">{{ translate('Basic Settings') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ translate('Settings') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ translate('Basic') }}</li>
            </ol>
        </div>
    </div>
    <div class="row sidemenu-height">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
					<form action="{{ route('admin.setings.update_basic') }}" class="data-parsley-validate" method="post" data-block_form="true" accept-charset="utf-8">
						<div class="row">
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="app_title">{{ translate('App Title') }} <span class="text-danger">*</span></label><input type="text" name="app_title" value="{{ app_setting('app_title') }}" class="form-control" placeholder="{{ translate('Enter App Title') }}" required="required" />
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="app_short_title">{{ translate('App Short Title') }} <span class="text-danger">*</span></label><input type="text" name="app_short_title" value="{{ app_setting('app_short_title') }}" class="form-control" placeholder="{{ translate('Enter App Short Title') }}" required="required" />
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="app_language">{{ translate('App Language') }} <span class="text-danger">*</span></label>
									<select name="app_language" class="form-control select2" required>
										<option value="en" selected="selected">English</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							@php
								$app_timezones = timezones();
							@endphp
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="app_timezone">{{ translate('App Timezone') }} <span class="text-danger">*</span></label>
									<select name="app_timezone" class="form-control select2" data-parsley-errors-container="#error_app_timezone" required>
										@if(isset($app_timezones) && !empty($app_timezones))
											@foreach($app_timezones as $key => $value)
												<option value="{{ $value }}">{{ $key }}</option>
											@endforeach
										@endif
									</select>
									<span id="error_app_timezone"></span>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="app_date_format">{{ translate('App Date Format') }} <span class="text-danger">*</span></label>
									<select name="app_date_format" class="form-control select2" data-parsley-errors-container="#error_app_date_format" required>
										<option value="Y-m-d">(YYYY-MM-DD)     &nbsp; 2023-05-20</option>
										<option value="Y.m.d">(YYYY.MM.DD)     &nbsp; 2023.05.20</option>
										<option value="Y/m/d">(YYYY/MM/DD)     &nbsp; 2023/05/20</option>
										<option value="d/m/Y">(DD/MM/YYYY)     &nbsp; 20/05/2023</option>
										<option value="d-m-Y">(DD-MM-YYYY)     &nbsp; 20-05-2023</option>
										<option value="d-M-Y">(DD-MMM-YYYY)    &nbsp; 20-May-2023</option>
										<option value="M d, Y">(MMM DD, YYYY)   &nbsp; May 20, 2023</option>
										<option value="F d, Y">(MMMM DD, YYYY)  &nbsp; May 20, 2023</option>
									</select>
									<span id="error_app_date_format"></span>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="app_time_format">{{ translate('App Time Format') }} <span class="text-danger">*</span></label>
									<select name="app_time_format" class="form-control select2" data-parsley-errors-container="#error_app_time_format" required>
										<option value="H:i:s">24 H (HH:MM:SS)      &nbsp; 23:59:59</option>
										<option value="H:i">24 H (HH:MM)         &nbsp; 23:59</option>
										<option value="h:i:s A">12 H (HH:MM:SS PM)   &nbsp; 11:59:59 PM</option>
										<option value="h:i A">12 H (HH:MM PM)      &nbsp; 11:59 PM</option>
									</select>
									<span id="error_app_time_format"></span>
								</div>
							</div>
							<div class="col-12 col-sm-12">
								<div class="form-group">
									<label for="app_footer_credit">{{ translate('App Footer Credit') }} </label><textarea name="app_footer_credit" cols="40" class="form-control" placeholder="Enter App Footer Credit" rows="2">{{ app_setting('app_footer_credit') }}</textarea>
								</div>
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-12 col-sm-4">
								<label class="custom-switch cursor-pointer">
									<span class="custom-switch-description">{{ translate('Disable Password Reset') }}</span>
									&nbsp;&nbsp;
									<input type="checkbox" name="app_disable_password_reset" class="custom-switch-input" {{ app_setting('app_disable_password_reset')=='on' ? 'checked' : '' }}>
									<span class="custom-switch-indicator"></span>
								</label>
							</div>
							<div class="col-12 col-sm-8">
								<small class="text-muted"><i>{{ translate('Registration Of User. If You Disable This Then User Can`t Reset Password') }}</i></small>
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-12 col-sm-4">
								<label class="custom-switch cursor-pointer">
									<span class="custom-switch-description">{{ translate('Disable Registration') }}</span>
									&nbsp;&nbsp;
									<input type="checkbox" name="app_disable_registration" class="custom-switch-input" checked>
									<span class="custom-switch-indicator"></span>
								</label>
							</div>
							<div class="col-12 col-sm-8">
								<small class="text-muted"><i>{{ translate('Registration Of User. If You Disable This Then Visitor Can`t Register') }}</i></small>
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-12 col-sm-4">
								<label class="custom-switch cursor-pointer">
									<span class="custom-switch-description">{{ translate('Disable Google Font') }}</span>
									&nbsp;&nbsp;
									<input type="checkbox" name="app_disable_google_font" class="custom-switch-input">
									<span class="custom-switch-indicator"></span>
								</label>
							</div>
							<div class="col-12 col-sm-8">
								<small class="text-muted"><i>{{ translate('If You Enable It, Google Font Won`t Load In Site') }}</i></small>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<hr/>
							</div>
							<div class="col-12 text-center">
								<button type="submit" class="btn ripple btn-main-primary" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span> Please Wait...">Save</button>
							</div>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
@endsection