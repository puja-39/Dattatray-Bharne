
<div class="modal d-block pos-static">
    <form action="{{ $page_action }}" method="post" class="data-parsley-validate"  data-block_form="true" enctype='multipart/form-data' data-multipart='true'>
       <input class="form-control" name="id" type="hidden" value="{{ isset($id) && $id!= '' ? $id : '' }}">
       <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document"> 
          <div class="modal-content">
             <div class="modal-header">
                <h6 class="modal-title">{{ $page_title }}</h6>
                <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                            <div class="form-group text-left">
                                <label>{{ translate('Image') }} <span class="tx-danger">*</span></label>
                                <?php echo secure_file_manager('image','image','image',isset($payment_details['image']) && $payment_details['image'] != '' ? $payment_details['image'] : ''); ?>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group text-left">
                                    <label>{{ translate('Name') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control txt-submit" name="name" placeholder="{{ translate('Enter Name') }}" type="text" tabindex="1" value="{{ isset($payment_details['name']) && $payment_details['name'] != '' ? $payment_details['name'] : ''  }}" required>
                                </div>
                            </div>
                            @php
                            $status_list = ['' => translate("Select"), '1' => translate("Active"), '0' => translate("Inactive")];
                            @endphp
                            <div class="col-md-4">
                                <div class="form-group text-left">
                                    <label>{{ translate('Status') }} <span class="tx-danger">*</span></label>
                                    <select name="is_active" class="form-control select2-modal" data-parsley-errors-container="#error_status" tabindex="2" required>
                                        @if(isset($status_list) && !empty($status_list))
                                            @foreach($status_list as $key => $value)
                                            @php $selected = isset($payment_details['is_active']) && $payment_details['is_active'] == $key ? 'selected' : ''  @endphp
                                            <option value="{{ $key }}" {{ $selected }}>{{ ucfirst($value) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span id="error_status"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-left">
                                    <label>{{ translate('Description') }} <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" name="description" placeholder="{{ translate('Enter Description') }}" required>{{ isset($payment_details['description']) && $payment_details['description'] != '' ? $payment_details['description'] : ''  }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $payment_gateway_type = $payment_details['slug'];
                    $details = $payment_details['details'];
                    $details = json_decode($details);
                @endphp
                @if($payment_gateway_type=='razorpay')
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>{{ translate('Key ID') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " name="payment_gateway[key_id]" placeholder="{{ translate('Key ID') }}" value="{{ $payment_gateway_type=='razorpay' && isset($details->key_id) ? $details->key_id : '' }}" tabindex="2" required />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>{{ translate('Secret') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " name="payment_gateway[secret]" placeholder="{{ translate('Secret') }}" tabindex="3" value="{{ $payment_gateway_type=='razorpay' && isset($details->secret) ? $details->secret : '' }}" required />
                            </div>
                        </div>
                        <div class="col-12 col-sm-8">
                            <div class="form-group">
                                <label>{{ translate('Webhook URL') }}</label>
                                <div class="input-group">
                                    <input class="form-control rounded-start-0" value="" type="text" readonly>
                                    <span class="input-group-btn">
                                        <button class="btn ripple btn-primary app-copy-btn rounded-start-0" title="{{ translate('Copy Webhook URL') }}" data-clipboard-text="" type="button">
                                        <span class="input-group-btn"><i class="fa fa-clipboard"></i></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label>{{ translate('Webhook Secret') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control action-fld rp-action" name="payment_gateway[wh_secret]" placeholder="{{ translate('Webhook Secret') }}" value="{{ $payment_gateway_type=='razorpay' && isset($details->wh_secret) ? $details->wh_secret : '' }}" tabindex="5" required />
                            </div>
                        </div>
                    </div>
                @elseif ($payment_gateway_type=='payu')
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>{{ translate('Merchant Key') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control " name="payment_gateway[merchant_key]" placeholder="{{ translate('Key ID') }}" value="{{ $payment_gateway_type=='payu' && isset($details->merchant_key) ? $details->merchant_key : '' }}" tabindex="2" required />
                            </div>
                        </div>
                        @php
                            $environment_list = ['' => translate("Select"), 'prod' => translate("Production"), 'test' => translate("Test")];
                        @endphp
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>{{ translate('Environment') }} <span class="text-danger">*</span></label>
                                <select name="payment_gateway[environment]" class="form-control select2-modal" data-parsley-errors-container="#error_env" tabindex="2" required>
                                    @if(isset($environment_list) && !empty($environment_list))
                                        @foreach($environment_list as $key => $value)
                                        @php $selected = isset($payment_details['environment']) && $payment_details['environment'] == $key ? 'selected' : ''  @endphp
                                        <option value="{{ $key }}" {{ $selected }}>{{ ucfirst($value) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span id="error_env"></span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12">
                            <div class="form-group">
                                <label>{{ translate('Merchant Salt') }}<span class="text-danger">*</span></label>
                                <textarea type="text" class="form-control" name="payment_gateway[merchant_salt]" placeholder="{{ translate('Merchant Salt') }}" tabindex="2" required>{{ $payment_gateway_type=='payu' && isset($details->merchant_salt) ? $details->merchant_salt : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-12 col-sm-8">
                            <div class="form-group">
                                <label>{{ translate('Webhook URL') }}</label>
                                <div class="input-group">
                                    <input class="form-control rounded-start-0" value="" type="text" readonly>
                                    <span class="input-group-btn">
                                        <button class="btn ripple btn-primary app-copy-btn rounded-start-0" title="{{ translate('Copy Webhook URL') }}" data-clipboard-text="" type="button">
                                        <span class="input-group-btn"><i class="fa fa-clipboard"></i></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label>{{ translate('Webhook Secret') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control action-fld rp-action" name="payment_gateway[wh_secret]" placeholder="{{ translate('Webhook Secret') }}" value="{{ $payment_gateway_type=='razorpay' && isset($details->wh_secret) ? $details->wh_secret : '' }}" tabindex="5" required />
                            </div>
                        </div>
                    </div>
                @endif
          </div>
          <div class="modal-footer">
             <button type="submit" class="btn ripple btn-submit btn-primary" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span> {{ translate('please_wait...') }}" tabindex="7">{{ translate('Submit') }}</button>
             <button class="btn ripple close-popup btn-secondary" type="button">{{ translate('Close') }}</button>
          </div>
       </div>
    </form>
    <script type="text/javascript">
        $(document).ready(function () {
            init_select2modal();
        });
    </script>
 </div>