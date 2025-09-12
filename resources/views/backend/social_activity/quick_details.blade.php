<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Blog Details') }}</h6>
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
                                    echo '<img alt="'.$name.'" class="radius img-thumbnail image-delay" src="'.uploads_url('loader.gif').'" data-src="'.uploads_url($image).'" style="width:100px;">';
                                 ?>
                              </td>
                           </tr>
                            <tr>
                               <th>{{ translate('name') }}</th>
                               <td>{{ $name }}</td>
                            </tr>
                           <tr>
                               <th>{{ translate('short_description') }}</th>
                               <td>{{ $short_description }}</td>
                            </tr>
                              <tr>
                               <th>{{ translate('description') }}</th>
                               <td> {!! $description !!}</td>
                            </tr>
                              <tr>
                               <th>{{ translate('seo_description') }}</th>
                               <td>{{ $seo_description }}</td>
                            </tr>
                              <tr>
                               <th>{{ translate('seo_keywords') }}</th>
                               <td>{{ $seo_keywords }}</td>
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
                                <th>{{ translate('Short Description') }}</th>
                                <td>{{ get_crud_user_details($short_description,'name') }}</td>
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
                               {{-- <td>{{ \Carbon\Carbon::parse($updated_at)->format('M d, Y h:i A') }}</td> --}}
                               <td>{{ \Carbon\Carbon::parse($updated_at)->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}</td>
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