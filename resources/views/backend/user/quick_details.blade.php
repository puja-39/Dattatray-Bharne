<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">Users Details</h6>
             <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
             <div class="row">
                <div class="col-md-12">
                   <div class="table-responsive">      
                      <table class="table table-bordered table-hover mg-b-0">
                         <tbody>
                            <tr>
                                <td colspan="2">
                                    <div class="text-center">
                                        <img src="{{ uploads_url($user->profile_image) }}" class="rounded-circle" width="100" height="100">       
                                    </div>
                                </td>
                            </tr>
                            <tr>
                               <th>{{ translate('name') }}</th>
                               <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('Username') }}</th>
                               <td>{{ $user->username }}</td>
                            </tr>

                           <tr>
                              <th>{{ translate('Status') }}</th>
                              <td><span class="badge bg-{{ $user->is_active==='1' ? 'success' : 'danger' }}">{{ $user->is_active==='1' ? translate('Active') : translate('Inactive') }}</span></td>
                           </tr>
                            
                              <tr>
                                <th>{{ translate('Created By') }}</th>
                                <td>{{ get_crud_user_details($user->created_by,'name') }}</td>
                              </tr>
                              <tr>
                                 <th>{{ translate('Created On') }}</th>
                                 <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y h:i A') }}</td>
                              </tr>

                            <tr>
                               <th>{{ translate('Updated By') }}</th>
                               <td>{{ get_crud_user_details($user->updated_by,'name') }}</td>
                            </tr>
                              <tr>
                                 <th>{{ translate('Updated On') }}</th>
                                 <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('M d, Y h:i A') }}</td>
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
