<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Payment Gateway Details') }}</h6>
             <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
             <div class="row">
                <div class="col-md-12">
                   <div class="table-responsive">      
                      <table class="table table-bordered table-hover mg-b-0">
                         <tbody>
                           <tr>
                              <th>{{translate('Image') }}</th>
                              <td class="text-center" colspan="3">
                                 <?php
                                    echo '<img alt="'.$name.'" class="radius img-thumbnail image-delay" src="'.uploads_url('loader.gif').'" data-src="'.uploads_url($image).'" style="width:100px;">';
                                 ?>
                              </td>
                           </tr>
                            <tr>
                               <th>{{ translate('Name') }}</th>
                               <td>{{ $name }}</td>
                            </tr>
                            @php
                                $payment_gateway_type = $slug;
                                $details = json_decode($details);
                            @endphp
                            @if($payment_gateway_type=='razorpay')
                                <tr>
                                    <th>{{ translate('Key ID') }} </th>
                                    <td>{{ $payment_gateway_type=='razorpay' && isset($details->key_id) ? $details->key_id : '' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ translate('Secret') }} </th>
                                    <td>{{ $payment_gateway_type=='razorpay' && isset($details->secret) ? $details->secret : '' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ translate('Webhook URL') }}</th>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <th>{{ translate('Webhook Secret') }}</th>
                                    <td>{{ $payment_gateway_type=='payu' && isset($details->merchant_key) ? $details->merchant_key : '' }}</td>
                                </tr>
                            @elseif ($payment_gateway_type=='payu')
                                <tr>
                                    <th>{{ translate('Merchant Key') }}</th>
                                    <td>{{ $payment_gateway_type=='payu' && isset($details->merchant_key) ? $details->merchant_key : '' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ translate('Merchant Salt') }}</th>
                                    <td>{{ $payment_gateway_type=='payu' && isset($details->merchant_salt) ? $details->merchant_salt : '' }}</td>
                                </tr>
                                @php
                                    $environment_list = array(
                                        ''   => translate("select"),
                                        'prod'  => translate("production"),
                                        'test'  => translate("test")
                                    );
                                    $environment = $payment_gateway_type=='payu' && isset($details->environment) ? $details->environment : '';
                                @endphp
                                <tr>
                                    <th>{{ translate('Environment') }}</th>
                                    <td>{{ isset($environment_list[$environment]) ? $environment_list[$environment] : translate('unknown') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ translate('Webhook URL') }}</th>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <th>{{ translate('Webhook Secret') }}</th>
                                    <td>{{ $payment_gateway_type=='payu' && isset($details->wh_secret) ? $details->wh_secret : '' }}</td>
                                </tr>
                            @endif
                            <tr>
                               <th>{{ translate('Status') }}</th>
                               <td><span class="badge bg-{{ $is_active==='1' ? 'success' : 'danger' }}">{{ $is_active==='1' ? translate('Active') : translate('Inactive') }}</span></td>
                            </tr>
                            <tr>
                               <th>{{ translate('Created By') }}</th>
                               <td>{{ get_crud_user_details($created_by,'name') }}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('Created On') }}</th>
                               <td>{{ $created_at }}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('Updated By') }}</th>
                               <td>{{ get_crud_user_details($updated_by,'name') }}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('Updated On') }}</th>
                               <td>{{ $updated_at }}</td>
                            </tr>
                         </tbody>
                      </table>
                   </div>
                </div>
             </div>
          </div>
          <div class="modal-footer">
             <button class="btn ripple close-popup btn-secondary" type="button">{{ translate('Close') }}</button>
          </div>
       </div>
    </div>
 </div>