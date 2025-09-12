<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate(' Blog Details') }}</h6>
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
                                    echo '<img alt="'.$blog->name.'" class="radius img-thumbnail image-delay" src="'.uploads_url('loader.gif').'" data-src="'.uploads_url($blog->image).'" style="width:100px;">';
                                 ?>
                              </td>
                           </tr>
                            <tr>
                               <th>{{ translate('name') }}</th>
                               <td>{{ $blog->name }}</td>
                            </tr>
                           <tr>
                               <th>{{ translate('short_description') }}</th>
                               <td>{{ $blog->short_description }}</td>
                            </tr>
                              <tr>
                               <th>{{ translate('description') }}</th>
                               <td> {!! $blog->description !!}</td>
                            </tr>
                              <tr>
                               <th>{{ translate('seo_description') }}</th>
                               <td>{{ $blog->seo_description }}</td>
                            </tr>
                              <tr>
                               <th>{{ translate('seo_keywords') }}</th>
                               <td>{{ $blog->seo_keywords }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('Status') }}</th>
                               <td><span class="badge bg-{{ $blog->is_active==='1' ? 'success' : 'danger' }}">{{ $blog->is_active==='1' ? translate('Active') : translate('Inactive') }}</span></td>
                            </tr>
                            
                            <tr>
                                <th>{{ translate('Created By') }}</th>
                                <td>{{ get_crud_user_details($blog->created_by,'name') }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('Created On') }}</th>
                                <td>{{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>

                            <tr>
                               <th>{{ translate('Updated By') }}</th>
                               <td>{{ get_crud_user_details($blog->updated_by,'name') }}</td>
                              
                            </tr>

                            <tr>
                                <th>{{ translate('Updated On') }}</th>
                               <td>{{ \Carbon\Carbon::parse($blog->updated_at)->format('M d, Y h:i A') }}</td>
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