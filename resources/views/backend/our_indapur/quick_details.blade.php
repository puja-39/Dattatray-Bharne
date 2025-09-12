<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Our Indapur Details') }}</h6>
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
                                 <?php
                                    echo '<img alt="'.$our_indapur->name.'" class="radius img-thumbnail image-delay" src="'.uploads_url('loader.gif').'" data-src="'.uploads_url($our_indapur->image).'" style="width:100px;">';
                                 ?>
                              </td>
                           </tr>
                            <tr>
                               <th>{{ translate('name') }}</th>
                               <td>{{ $our_indapur->name }}</td>
                            </tr>
                           <tr>
                               <th>{{ translate('short_description') }}</th>
                               <td>{{ $our_indapur->short_description }}</td>
                            </tr>
                              <tr>
                               <th>{{ translate('description') }}</th>
                               <td> {!! $our_indapur->description !!}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('Status') }}</th>
                               <td><span class="badge bg-{{ $our_indapur->is_active==='1' ? 'success' : 'danger' }}">{{ $our_indapur->is_active==='1' ? translate('Active') : translate('Inactive') }}</span></td>
                            </tr>
                            
                            <tr>
                                <th>{{ translate('Created By') }}</th>
                                <td>{{ get_crud_user_details($our_indapur->created_by,'name') }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('Created On') }}</th>
                                <td>{{ \Carbon\Carbon::parse($our_indapur->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>

                            <tr>
                               <th>{{ translate('Updated By') }}</th>
                               <td>{{ get_crud_user_details($our_indapur->updated_by,'name') }}</td>
                              
                            </tr>

                            <tr>
                                <th>{{ translate('Updated On') }}</th>
                               <td>{{ \Carbon\Carbon::parse($our_indapur->updated_at)->format('M d, Y h:i A') }}</td>
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