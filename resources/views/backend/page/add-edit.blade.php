<style>
    .note-editor.note-frame {
        height: 250px;
        overflow: auto;
    }
   
    .dropdown-fontname, .dropdown-fontsize, .dropdown-style, .dropdown-line-height, .note-dropdown-menu {
        height: 210px;
        overflow: auto;
    }
</style>
@extends('backend.app')
@section('style_files')
<link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/summernote/summernote-lite.min.css') }}">
<link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/jstree/jstree.css') }}">
@endsection
@section('script_files')
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/darggable/jquery-ui-darggable.min.js') }}"></script>
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/inputtags/inputtags.js') }}"></script>
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/summernote/summernote-lite.min.js') }}"></script>
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/summernote/init.js') }}"></script>
<script type="text/javascript"  src="{{ static_asset('assets/backend/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
<script type="text/javascript"  src="{{ static_asset('assets/backend/plugins/jstree/jstree.js') }}"></script>
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/select2/select2.min.js') }}"></script>

@endsection
@section('page_title'){{ translate('Page') }}@endsection
@section('content')
    <div class="page-header">
        <div>
        <h2 class="main-content-title tx-24 mg-b-5">{{ isset($page_title) && $page_title != '' ? translate($page_title) : '' }}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="">{{ translate('Page') }} </a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ isset($page_title) && $page_title != '' ? translate($page_title) : '' }}</li>
        </ol>
        </div>
        <div class="btn btn-list">
        <a class="btn ripple btn-primary" href="{{ route('admin.page') }}"><i class="fe fe-list ml-2"></i>{{ translate('list') }}</a>
        </div>
    </div>
    <div class="row sidemenu-height">
        <div class="col-lg-12">
            <form action="{{ $page_action }}" class="data-parsley-validate" method="post" data-block_form="true" enctype='multipart/form-data' data-multipart='true' accept-charset="utf-8">
                @csrf
                <input class="form-control" name="id" type="hidden" value="{{ isset($id) && $id!= '' ? $id : '' }}">
                <div class="card custom-card">
                    <div class="card-body">
                 
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Name <span class="tx-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ isset($page['name']) ? $page['name'] : '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status <span class="tx-danger">*</span></label>
                                    <select name="is_active" class="form-control select2" data-parsley-errors-container="#error_status" tabindex="2" required>
                                        <option value="">Select</option>
                                        <option value="1" {{ isset($page['is_active']) && $page['is_active'] == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ isset($page['is_active']) && $page['is_active'] == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <span id="error_status"></span>
                                </div>
                            </div>
                        </div>
              

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ translate('description') }}<span class="text-danger">*</span></label>
                                    {!! app_html_editor("description", "description", translate('description'), isset($page['description']) ? $page['description'] : '') !!}
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-3 mt-3">
                        <div class="col-12 col-sm-12 text-center">              
                            <button type="submit" class="btn btn-primary btn-submit ripple" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span>{{ translate('please_wait...') }}" tabindex="7">{{ translate('Submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>  
        </div>
    </div>
    
    <script>
    $(document).ready(function () {
        init_select2();
    });
    </script>
@endsection