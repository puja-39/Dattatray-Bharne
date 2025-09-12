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
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label>Username<span class="tx-danger">*</span></label>
                                        <input type="text" class="form-control" name="username" placeholder="Enter Username" value="{{ isset($user['username']) ? $user['username'] : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label>Email Address<span class="tx-danger">*</span></label>
                                        <input type="text" class="form-control" name="email" placeholder="Enter Email Address" value="{{ isset($user['email_id']) ? $user['email_id'] : '' }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label>Name<span class="tx-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ isset($user['name']) ? $user['name'] : '' }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label>Role<span class="tx-danger">*</span></label>
                                        <select class="form-control select2-modal" name="role" data-parsley-errors-container="#error_role" required>
                                            <option value="">Select</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role['id'] }}" {{ isset($user['role_id']) && $user['role_id'] == $role['id'] ? 'selected' : '' }}>
                                                    {{ $role['name'] }}
                                                </option>
                                            @endforeach
                                    </select>
                                        <span id="error_role"></span>
                                    </div>
                                </div>
                            </div>            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label>Phone Number<span class="tx-danger">*</span></label>
                                        <input type="text" class="form-control mobile_no" name="mobile_no" id="mobile_no" placeholder="Enter Phone Number" value="{{ isset($user['mobile_no']) ? $user['mobile_no'] : '' }}" required>
                                        <span id="error_mobile_no" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label>Status <span class="tx-danger">*</span></label>
                                        <select name="is_active" class="form-control select2-modal" data-parsley-errors-container="#error_status" tabindex="2" required>
                                            <option value="">Select</option>
                                            <option value="1" {{ isset($user['is_active']) && $user['is_active'] == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ isset($user['is_active']) && $user['is_active'] == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <span id="error_status"></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <img class="app-image-input img-thumbnail" data-name="user_profile" data-show-delete="true" 
                                 src="{{ isset($user['profile_image']) && $user['profile_image'] != '' ? asset('public/uploads/profile/' . $user['profile_image']) : asset('public/uploads/default_old.png') }}" 
                                 style="height: 230px;width: 230px;"/>
                            <p><small class="text-muted"><i><?php echo translate('click_on_the_image_to_change').'<br/>'.translate('best_size_is_400px_X_400px'); ?></i></small></p>
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

                $('#phone_number').on('input', function () {
                    var phone = $(this).val().trim();
                    var firstDigitPattern = /^[6-9]/;
                    var fullPattern = /^[6-9]\d{9}$/;

                    if (phone.length > 0) {
                        if (!firstDigitPattern.test(phone)) {
                            $('#error_phone_number').text("Phone number must start with a digit between 6 and 9.");
                        } else if (phone.length < 10) {
                            $('#error_phone_number').text("Phone number must be exactly 10 digits long.");
                        } else if (!fullPattern.test(phone)) {
                            $('#error_phone_number').text("Phone number must contain only 10 digits.");
                        } else {
                            $('#error_phone_number').text("");
                        }
                    } else {
                        $('#error_phone_number').text("");
                    }
                });

                $('input[name="password"]').attr('minlength', 6);
                $('input[name="password"]').on('input', function() {
                    if ($(this).val().length > 0 && $(this).val().length < 6) {
                        $(this).get(0).setCustomValidity("Password must be at least 6 characters.");
                    } else {
                        $(this).get(0).setCustomValidity("");
                    }
                });
            });
        </script>
    </div>
</div>