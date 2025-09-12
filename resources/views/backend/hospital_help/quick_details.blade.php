<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Hospital Help Details') }}</h6>
             <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
             <div class="row">
                <div class="col-md-12">
                   <div class="table-responsive">      
                      <table class="table table-bordered table-hover mg-b-0">
                         <tbody>
                             <tr>
                                 <th><?php echo translate('image'); ?></th>
                                 <td class="text-center" colspan="3">
                                     <?php if (!empty($image)) : ?>
                                           <img src="<?php echo asset('public/filemanager/' . $image); ?>" width="70" height="50" alt="Image" style="object-fit:cover;">
                                     <?php else : ?>
                                           <img src="<?php echo asset('public/uploads/default.png'); ?>" width="70" height="50" alt="Default Image" style="object-fit:cover;">
                                     <?php endif; ?>
                                 </td>
                              </tr>
                           <tr>
                               <th>{{ translate('name') }}</th>
                               <td>{{ $hospital_help->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('Status') }}</th>
                               <td><span class="badge bg-{{ $hospital_help->is_active==='1' ? 'success' : 'danger' }}">{{ $hospital_help->is_active==='1' ? translate('Active') : translate('Inactive') }}</span></td>
                            </tr>
                            <tr>
                                <th>{{ translate('Created By') }}</th>
                                <td>{{ get_crud_user_details($hospital_help->created_by,'name') }}</td>
                            </tr>

                            <tr>
                                <th>{{ translate('Created On') }}</th>
                                <td>{{ \Carbon\Carbon::parse($hospital_help->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>

                            <tr>
                               <th>{{ translate('Updated By') }}</th>
                               <td>{{ get_crud_user_details($hospital_help->updated_by,'name') }}</td>
                              
                            </tr>

                            <tr>
                                <th>{{ translate('Updated On') }}</th>
                               <td>{{ \Carbon\Carbon::parse($hospital_help->updated_at)->format('M d, Y h:i A') }}</td>
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