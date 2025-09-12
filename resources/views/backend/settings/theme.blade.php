@extends('backend.app')

@section('page_title'){{ translate('Theme Settings') }}@endsection

@section('content')
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">{{ translate('Theme Settings') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ translate('Settings') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ translate('Theme') }}</li>
            </ol>
        </div>
    </div>
    <div class="row sidemenu-height">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
					<form action="{{ route('admin.setings.update_theme') }}" class="data-parsley-validate" method="post" data-block_form="true" enctype="multipart/form-data" data-multipart="true" accept-charset="utf-8">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <label>{{ translate('App Logo') }} <span class="text-danger">*</span></label>
                                <br/>
                                <img class="app-image-input img-thumbnail" data-name="app_logo" src="{{ static_asset('images/logo.png') }}" style="max-height: 80px;"/>
                                <p><small class="text-muted"><i>{{ translate('Click on the image to replace it.') }} {{ translate('Best size is 80px X 80px') }}</i></small></p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <label>{{ translate('App Favicon') }} <span class="text-danger">*</span></label>
                                <br/>
                                <img class="app-image-input img-thumbnail" data-name="app_favicon" src="{{ static_asset('images/favicon.png') }}" style="height: 80px;"/>
                                <p><small class="text-muted"><i>{{ translate('Click on the image to replace it.') }} {{ translate('best_size_is_80px_X_80px') }}</i></small></p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <label>{{ translate('App PWA Icon') }} <span class="text-danger">*</span></label>
                                <br/>
                                <img class="app-image-input img-thumbnail" data-name="app_pwa" src="{{ static_asset('images/favicon.png') }}" style="height: 80px;"/>
                                <p><small class="text-muted"><i>{{ translate('Click on the image to replace it.') }} {{ translate('best_size_is_80px_X_80px') }}</i></small></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                <label>{{ translate('App Primary Color') }} <span class="text-danger">*</span></label><br/>
                                <input type="color" class="form-control" name="app_primary_color" placeholder="{{ translate('App Primary Color') }}" tabindex="1" value="{{ app_setting('app_primary_color') }}" autofocus required />
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                <label>{{ translate('App Secondary Color') }} <span class="text-danger">*</span></label><br/>
                                <input type="color" class="form-control" name="app_secondary_color" placeholder="{{ translate('App Secondary Color') }}" tabindex="2" value="{{ app_setting('app_secondary_color') }}" required />
                                </div>
                            </div>
                            @php
                                $menubar = array('left'=>translate('Left'),'top'=>translate('Top'));
                            @endphp
                            <div class="col-12 col-sm-2">
                                <div class="form-group">
                                    <label>{{ translate('App Menubar') }} <span class="text-danger">*</span></label>
                                    <select name="app_menubar" class="form-control select2" data-parsley-errors-container="#error_app_menubar" tabindex="3" required>
                                        @if(isset($menubar) && !empty($menubar))
                                            @foreach($menubar as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span id="error_app_menubar"></span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <label>{{ translate('App RTL Mode') }} <span class="text-danger">*</span></label>
                                <label class="custom-switch cursor-pointer">
                                    <input type="checkbox" name="app_rtl_mode" class="custom-switch-input" <?php //echo app_setting('app_rtl','off')=='on' ? 'checked' : ''; ?>>
                                    <span class="custom-switch-indicator"></span>
                                    &nbsp;&nbsp;
                                    <span class="custom-switch-description"><small class="text-muted"><i>{{ translate('If you enable it, then the panel will be in the RTL direction.') }}</i></small></span>
                                </label>
                            </div>
                        </div>
                        <hr/>
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