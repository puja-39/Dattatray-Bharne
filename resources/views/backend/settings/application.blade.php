@extends('backend.app')
@section('script_files')
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/inputtags/inputtags.js') }}"></script>
@endsection
@section('page_title'){{ translate('Application Settings') }}@endsection
@section('content')
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">{{ translate('Application Settings') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ translate('Settings') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ translate('Application') }}</li>
            </ol>
        </div>
    </div>
    <div class="row sidemenu-height">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
					<form action="{{ route('admin.setings.update_application') }}" class="data-parsley-validate" method="post" data-block_form="true" accept-charset="utf-8">
<div class="row">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <label for="front_page_access">{{ translate('Front Page Access') }}</label>
            <select name="front_page_access" class="form-control select2" required>
                <option value="" selected="selected">Select</option>
                <option value="on" {{ app_setting('front_page_access') == 'on' ? 'selected' : '' }}>Allow</option>
                <option value="off" {{ app_setting('front_page_access') == 'off' ? 'selected' : '' }}>Deny</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <label for="app_maintenance_mode">{{ translate('Maintenance Mode') }} <span class="text-danger">*</span></label>
            <select name="app_maintenance_mode" class="form-control select2" required>
                <option value="" selected="selected">Select</option>
                <option value="on" {{ app_setting('app_maintenance_mode') == 'on' ? 'selected' : '' }}>On</option>
                <option value="off" {{ app_setting('app_maintenance_mode') == 'off' ? 'selected' : '' }}>Off</option>
            </select>
        </div>
    </div>
            @php
               $app_maintenance_mode_details = app_setting('app_maintenance_mode_details','[]');
               $app_maintenance_mode_details = !empty(json_decode($app_maintenance_mode_details)) ? json_decode($app_maintenance_mode_details) : (object)[];
            @endphp
            <div class="col-12 col-sm-4">
               <div class="form-group">
                     <label for="app_phone_number">{{ translate('Maintenance  Mode Phone  No') }} <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" data-role="tagsinput" name="app_maintenance_mode_details[phone]" placeholder="{{ translate('Phone for Maintenance Mode') }}" value="{{ $app_maintenance_mode_details->phone ?? '' }}" required />
               </div>
            </div>
            <div class="col-12 col-sm-4">
               <div class="form-group">
                     <label for="app_email">{{ translate('Maintenance Mode Email') }} <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" data-role="tagsinput" name="app_maintenance_mode_details[email]" placeholder="{{ translate('Email for Maintenance Mode') }}" value="{{ $app_maintenance_mode_details->email ?? '' }}" required />
               </div>
            </div>
            <div class="col-12 col-sm-4">
               <div class="form-group">
                     <label for="app_address">{{ translate('Maintenance Mode Address') }} <span class="text-danger">*</span></label>
                     <textarea  class="form-control" data-role="tagsinput" name="app_maintenance_mode_details[address]" placeholder="{{ translate('Address for Maintenance Mode') }}"  required />{{ $app_maintenance_mode_details->address ?? '' }}</textarea>
               </div>
            </div>
             <div class="col-12 col-sm-4">
               <div class="form-group">
                     <label>Maintenance  Mode  Map</label>
                     <textarea class="form-control" name="app_maintenance_mode_details[map]" placeholder="{{ translate('Map Embed Code or Description') }}">{{ $app_maintenance_mode_details->map ?? '' }}</textarea>
               </div>
            </div>
         </div>
      <div class="row" >
      <div class="col-12 col-sm-6 px-3">
      <div class="form-group">
         <label for="terms_and_conditions_page">
            Terms and Conditions Page <span class="text-danger">*</span>
         </label>
         <select id="terms_and_conditions_page" name="terms_and_conditions_page" class="form-control select2" required data-parsley-errors-container="#error_terms_and_conditions_page">
    <option value="0" {{ (isset($selectedPageId1) && $selectedPageId1 == 0) ? 'selected' : '' }}>{{ __('No Page') }}</option>
    @if(isset($page) && $page->count())
        @foreach($page as $p)
            <option value="{{ $p->id }}" {{ (isset($selectedPageId1) && $selectedPageId1 == $p->id) ? 'selected' : '' }}>
                {{ $p->name }}
            </option>
        @endforeach
    @endif
</select>

         <span id="error_terms_and_conditions_page"></span>
      </div>
      </div>
         <div class="col-12 col-sm-6 text-left">
            <div class="form-group">
               <label for="return_refund_and_cancellation_policy_page">Return, Refund and Cancellation Policy Page <span class="text-danger">*</span></label>
      <select id="return_refund_and_cancellation_policy_page" name="return_refund_and_cancellation_policy_page" class="form-control select2" required data-parsley-errors-container="#error_return_refund_and_cancellation_policy_page">
           <option value="0" {{ (isset($selectedPageId2) && $selectedPageId2 == 0) ? 'selected' : '' }}>{{ __('No Page') }}</option>
        @if(isset($page) && $page->count())
        @foreach($page as $p)
            <option value="{{ $p->id }}" {{ (isset($selectedPageId2) && $selectedPageId2 == $p->id) ? 'selected' : '' }}>
                {{ $p->name }}
            </option>
        @endforeach
    @endif
      </select>
      <span id="error_return_refund_and_cancellation_policy_page"></span>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12 col-sm-6 text-left">
            <div class="form-group">
               <label for="privacy_policy_page">Privacy Policy Page <span class="text-danger">*</span></label>
      <select id="privacy_policy_page" name="privacy_policy_page" class="form-control select2" required data-parsley-errors-container="#error_privacy_policy_page">
           <option value="0" {{ (isset($selectedPageId3) && $selectedPageId3 == 0) ? 'selected' : '' }}>{{ __('No Page') }}</option>
        @if(isset($page) && $page->count())
        @foreach($page as $p)
            <option value="{{ $p->id }}" {{ (isset($selectedPageId3) && $selectedPageId3 == $p->id) ? 'selected' : '' }}>
                {{ $p->name }}
            </option>
        @endforeach
    @endif
      </select>
      <span id="error_privacy_policy_page"></span>
            </div>
         </div>
         <div class="col-12 col-sm-6 text-left">
            <div class="form-group">
            <label for="disclaimer_page">Disclaimer Page <span class="text-danger">*</span></label>
      <select id="disclaimer_page" name="disclaimer_page" class="form-control select2" required data-parsley-errors-container="#error_disclaimer_page">
        <option value="0" {{ (isset($selectedPageId4) && $selectedPageId4 == 0) ? 'selected' : '' }}>{{ __('No Page') }}</option>
               @if(isset($page) && $page->count())
        @foreach($page as $p)
            <option value="{{ $p->id }}" {{ (isset($selectedPageId4) && $selectedPageId4 == $p->id) ? 'selected' : '' }}>
                {{ $p->name }}
            </option>
        @endforeach
    @endif
      </select>
      <span id="error_disclaimer_page"></span>
            </div>
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