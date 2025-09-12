<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Video Details') }}</h6>
             <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
             <div class="row">
                <div class="col-md-12">
                   <div class="table-responsive">      
                      <table class="table table-bordered table-hover mg-b-0">
                         <tbody>
                           <tr>
                            <th><?php echo translate('Video'); ?></th>
                              <td>
                                 <?php echo $videos ? '<video src="' . asset('public/filemanager/' . $videos) . '" class="" width="70" height="50" alt="" style="object-fit:cover"></video>': '<video src="' . asset('public/uploads/default_old.mp4') . '" class="" width="50" height="50" alt=""></video>';?>
                              </td>
                           </tr>                     
                            <tr>
                           <th><?php echo translate('Image'); ?></th>
                              <td >
                                 <?php echo $image ?? asset('public/uploads/default.png') ;?>
                              </td> 
                           </tr>
                            <tr>
                               <th>{{ translate('name') }}</th>
                               <td>{{ $name }}</td>
                            </tr>
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
                                <td>{{ \Carbon\Carbon::parse($created_at)->format('M d, Y h:i A') }}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('Updated By') }}</th>
                               <td>{{ get_crud_user_details($updated_by,'name') }}</td>                            
                            </tr>
                            <tr>
                                <th>{{ translate('Updated On') }}</th>
                               <td>{{ \Carbon\Carbon::parse($updated_at)->format('M d, Y h:i A') }}</td>
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