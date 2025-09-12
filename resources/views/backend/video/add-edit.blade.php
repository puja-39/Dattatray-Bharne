@section('style_files')
<link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/summernote/summernote-lite.min.css') }}">
<link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/jstree/jstree.css') }}">
@endsection
@section('script_files')
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/darggable/jquery-ui-darggable.min.js') }}"></script>
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/inputtags/inputtags.js') }}"></script>
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/summernote/summernote-lite.min.js') }}"></script>
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/summernote/init.js') }}"></script>
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/jstree/jstree.js') }}"></script>
@endsection
<div class="modal d-block pos-static">
    <form action="{{ $page_action }}" method="post" class="data-parsley-validate" data-block_form="true"
        enctype='multipart/form-data' data-multipart='true'>
        @csrf
          <input class="form-control" name="id" type="hidden" value="{{ isset($id) && $id != '' ? $id : '' }}">
           <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ $page_title }}</h6>
                    <button aria-label="Close" class="btn-close close-popup" type="button"><spanaria-hidden="true">&times;</span></button>
                </div>
            <div class="modal-body" style="margin-left: 43px;">
          <div class="row" >
            <div class="row" >
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label>{{ translate('Video') }} <span class="text-danger">*</span></label>
                  {!! rohan_file_manager_input('videos', 'videos', 'videos',  isset($video['videos']) ? $video['videos'] : '', false, '250px', '250px') !!}
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label>{{ translate('Image') }} <span class="text-danger">*</span></label>
                  {!! rohan_file_manager_input('image', 'image', 'image', isset($video['image']) ? $video['image'] : '', false, '250px', '250px') !!}
                </div>
              </div>
            </div>
          <div class="col-md-12 mb-">
          <div class="row">
            <div class="col-md-7 mb-3">
                <div class="form-group">
                    <label>{{ translate('Name') }} <span class="text-danger">*</span></label>
                    <input  type="text" class="form-control" name="name" placeholder="{{ translate('Enter Name') }}" value="{{ isset($video['name']) ? $video['name'] : '' }}" required>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label>{{ translate('Status') }} <span class="text-danger">*</span></label>
                    <select name="is_active" class="form-control select2-modal" data-parsley-errors-container="#error_status" required>
                        <option value="">{{ translate('Select') }}</option>
                        <option value="1" {{ isset($video['is_active']) && $video['is_active'] == '1' ? 'selected' : '' }}>{{ translate('Active') }}</option>
                        <option value="0" {{ isset($video['is_active']) && $video['is_active'] == '0' ? 'selected' : '' }}>{{ translate('Inactive') }}</option>
                    </select>
                    <span id="error_status" class="text-danger small"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11 mb-3">
                <div class="form-group">
                    <label>{{ translate('Short Description') }} <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control"  name="short_description"  placeholder="{{ translate(' short description') }}" value="{{ isset($video['short_description']) ? $video['short_description'] : '' }}" required>
                </div>
            </div>
        </div>
        </div>
        </div>                     
            <div class="modal-footer">
                <button class="btn ripple close-popup btn-secondary" type="button">{{ translate('Close') }}</button>
                <button type="submit" class="btn ripple btn-submit btn-primary"
                    data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span> {{ translate('please_wait...') }}"
                    tabindex="7">{{ translate('Submit') }}</button>
            </div>
        </div>
    </form>
        <script type="text/javascript">
        $(document).ready(function() {
            init_select2modal();
        });
    </script>
</div>
{!! rohan_file_manager_scripts() !!}
