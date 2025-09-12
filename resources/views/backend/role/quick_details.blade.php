<div class="modal d-block pos-static">
   <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h6 class="modal-title">{{ translate('Role Details') }}</h6>
            <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="table-responsive">
                     <table class="table table-bordered table-hover mg-b-0">
                        <tbody>
                           <tr>
                              <th>{{ translate('name') }}</th>
                              <td>{{ $role->name }}</td>
                           </tr>
                           <tr>
                              <th>{{ translate('Status') }}</th>
                              <td><span class="badge bg-{{ $role->is_active==='1' ? 'success' : 'danger' }}">{{ $role->is_active==='1' ? translate('Active') : translate('Inactive') }}</span></td>
                           </tr>
                           <tr>
                              <th>{{ translate('Created By') }}</th>
                              <td>{{ get_crud_user_details($role->created_by,'name') }}</td>
                           </tr>
                           <tr>
                              <th>{{ translate('Created On') }}</th>
                                <td>{{ \Carbon\Carbon::parse($role->created_at)->format('M d, Y h:i A') }}</td>
                           </tr>
                           <tr>
                              <th>{{ translate('Updated By') }}</th>
                              <td>{{ get_crud_user_details($role->updated_by,'name') }}</td>
                           </tr>
                           <tr>
                              <th>{{ translate('Updated On') }}</th>
                               <td>{{ \Carbon\Carbon::parse($role->updated_at)->format('M d, Y h:i A') }}</td>
                           </tr>
                           <?php /*<tr>
                              <th><?php echo translate('permissions'); ?></th>
                              <td>
                                 <table class="table table-striped">
                                    <tbody>
                                       <tr>
                                          <th><?php echo translate('module') ?></th>
                                          <th class="text-center"><?php echo translate('permissions') ?></th>
                                       </tr>
                                       <?php $permissions = json_decode(get_column_value(TBL_ROLE,array('id'=>$id),'permissions','[]')); if(!empty($permissions)){foreach ($permissions as $pkey => $permission) { ?>
                                          <tr>
                                             <td><?php echo translate($pkey); ?></td>
                                             <td class="text-center">
                                                <?php if(isset($permission) && !empty($permission)){foreach ($permission as $pkey => $pvalue) { ?>
                                                   <span class="badge bg-primary"><?php echo translate($pkey); ?></span>
                                                <?php } } ?>
                                             </td>
                                          </tr>
                                       <?php } }else{ ?>
                                          <tr>
                                             <td class="text-center" colspan="2"><?php echo translate('no_data_found'); ?></td>
                                          </tr>
                                       <?php } ?>
                                   </tbody>
                               </table>
                              </td>
                           </tr>*/ ?>
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