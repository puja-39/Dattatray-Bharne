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
@section('page_title'){{ translate('Our Indapur') }}@endsection
@section('content')
    <div class="page-header">
        <div>
        <h2 class="main-content-title tx-24 mg-b-5">{{ isset($page_title) && $page_title != '' ? translate($page_title) : '' }}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="">{{ translate('Our Indapur') }} </a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ isset($page_title) && $page_title != '' ? translate($page_title) : '' }}</li>
        </ol>
        </div>
        <div class="btn btn-list">
        <a class="btn ripple btn-primary" href="{{ route('admin.our_indapur') }}"><i class="fe fe-list ml-2"></i>{{ translate('list') }}</a>
        </div>
    </div>
    <div class="row sidemenu-height">
        <div class="col-lg-12">
            <form action="{{ $page_action }}" class="data-parsley-validate" method="post" data-block_form="true" enctype='multipart/form-data' data-multipart='true' accept-charset="utf-8">
                <input class="form-control" name="id" type="hidden" value="{{ isset($id) && $id!= '' ? $id : '' }}">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                   <div class="col-12 col-sm-12">
                                  <div class="form-group">
                                <label>{{ translate('Image') }} <span class="text-danger">*</span></label>
                                {!! rohan_file_manager_input('image', 'image', 'image', isset($our_indapur['image']) ? $our_indapur['image'] : '', false, '215px', '250px') !!}
                            </div>
                            </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Name <span class="tx-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ isset($our_indapur['name']) ? $our_indapur['name'] : '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Status <span class="tx-danger">*</span></label>
                                            <select name="is_active" class="form-control select2" data-parsley-errors-container="#error_status" tabindex="2" required>
                                                <option value="">Select</option>
                                                <option value="1" {{ isset($our_indapur['is_active']) && $our_indapur['is_active'] == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ isset($our_indapur['is_active']) && $our_indapur['is_active'] == '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            <span id="error_status"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                    <label>{{ translate('Short Description') }} <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="short_description" placeholder="{{ translate('Short Description') }}" tabindex="4" required>{{ isset($our_indapur['short_description']) && $our_indapur['short_description'] != '' ? $our_indapur['short_description'] : '' }}</textarea>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>                       
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ translate('description') }}<span class="text-danger">*</span></label>
                                      <textarea name="description"  class="rohan-textarea" required>
                                        {{ old('description', $our_indapur['description'] ?? '') }}
                                      </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-12 col-sm-12 text-center">              
                        <button type="submit" class="btn ripple btn-submit btn-primary" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span>{{ translate('please_wait...') }}" tabindex="7">{{ translate('Submit') }}</button>
                        <a class="btn ripple btn-secondary" href="{{ route('admin.our_indapur.list') }}">{{ translate('close') }}</a>
                    </div>
                    </div><br>
                </div>
            </form>  
        </div>
    </div>
    <script>
    $(document).ready(function () {
        init_select2();
    });
    </script>
        <script type="text/javascript">
        function responsive_filemanager_callback(field_id){
         var url = $('#'+field_id).val();
            $('#img_'+field_id).attr('src', url);
        }
    </script>
        {!! rohan_file_manager_scripts() !!}
@endsection
