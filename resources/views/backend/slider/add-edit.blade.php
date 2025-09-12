<div class="modal d-block pos-static">
    <form action="{{ $page_action }}" method="post" class="data-parsley-validate" data-block_form="true"
        enctype='multipart/form-data' data-multipart='true'>
        @csrf
        <input class="form-control" name="id" type="hidden" value="{{ isset($id) && $id != '' ? $id : '' }}">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ $page_title }}</h6>
                    <button aria-label="Close" class="btn-close close-popup" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label>{{ translate('Image') }}</label>
                                {!! rohan_file_manager_input('image', 'image', 'image', isset($slider['image']) ? $slider['image'] : '', false, '250px', '250px') !!}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <div class="form-group">
                                        <label>{{ translate('Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Name"
                                            value="{{ isset($slider['name']) ? $slider['name'] : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>{{ translate('Status') }} <span class="text-danger">*</span></label>
                                        <select name="is_active" class="form-control select2-modal" data-parsley-errors-container="#error_status" required>
                                            <option value="">{{ translate('Select') }}</option>
                                            <option value="1" {{ isset($slider['is_active']) && $slider['is_active'] == '1' ? 'selected' : '' }}>{{ translate('Active') }}</option>
                                            <option value="0" {{ isset($slider['is_active']) && $slider['is_active'] == '0' ? 'selected' : '' }}>{{ translate('Inactive') }}</option>
                                        </select>
                                        <span id="error_status" class="text-danger small"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label>{{ translate('type') }} <span class="text-danger">*</span></label>
                                        <select name="type" class="form-control select2-modal" data-parsley-errors-container="#error_type" required>
                                            <option value="">{{ translate('Select') }}</option>
                                            <option value="Desktop" {{ isset($slider['type']) && $slider['type'] == 'Desktop' ? 'selected' : '' }}>{{ translate('Desktop') }}</option>
                                            <option value="Mobile" {{ isset($slider['type']) && $slider['type'] == 'Mobile' ? 'selected' : '' }}>{{ translate('Mobile') }}</option>
                                        </select>
                                        <span id="error_type" class="text-danger small"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>{{ translate('Title') }}</label>
                                          <input type="text" class="form-control" name="title" placeholder="Enter Title" value="{{ isset($slider['title']) ? $slider['title'] : '' }}" >
                                    </div>
                                </div>
                                 <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>{{ translate('SubTitle') }}</label>
                                          <input type="text" class="form-control" name="subtitle" placeholder="Enter SubTitle" value="{{ isset($slider['subtitle']) ? $slider['subtitle'] : '' }}">
                                    </div>
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
     <script type="text/javascript">
        function responsive_filemanager_callback(field_id){
         var url = $('#'+field_id).val();
            $('#img_'+field_id).attr('src', url);
        }
    </script>
    {!! rohan_file_manager_scripts() !!}
</div>