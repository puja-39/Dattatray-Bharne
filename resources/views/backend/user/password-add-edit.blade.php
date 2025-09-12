<div class="modal d-block pos-static">
    <form action="{{ $page_action }}" method="post" class="data-parsley-validate" data-block_form="true"
        enctype='multipart/form-data' data-multipart='true'>
        @csrf
        <input class="form-control" name="id" type="hidden" value="{{ isset($id) && $id != '' ? $id : '' }}">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ $page_title }}</h6>
                    <button aria-label="Close" class="btn-close close-popup" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                @php
                    //print_r($member);
                @endphp

                    <div class="col-12 col-sm-12">
                        <div class="form-group text-left">
                            <label>New Password<span class="tx-danger">*</span></label>
                            <input type="password" class="form-control" name="password" placeholder="New Password" value="" required minlength="6">
                        </div>
                    </div>
                        
                    <div class="col-12 col-sm-12">
                        <div class="form-group text-left">
                            <label>Confirm New Password<span class="tx-danger">*</span></label>
                            <input type="password" class="form-control" name="confirmed_password" placeholder="Confirm New Password " value="" required minlength="6">
                        </div>
                    </div>

                    <div class="col-12 col-sm-12">
                        <div class="form-group text-left">
                            <label>Admin Password<span class="tx-danger">*</span></label>
                            <input type="password" class="form-control" name="admin_password" placeholder="Admin Password" value="" required>
                        </div>
                        <p><small class="text-muted"><i>Enter Your Password To Confirm Your Identity For Password Reset</i></small></p>
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
</div>