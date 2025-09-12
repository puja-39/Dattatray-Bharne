<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Gallery Details') }}</h6>
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
                                 <?php echo $gallery->image ? '<img src="' . asset('public/filemanager/' . $gallery->image) . '" class="" width="70" height="50" alt="" style="object-fit:cover">': '<img src="' . asset('public/uploads/default_old.png') . '" class="" width="50" height="50" alt="">';?>

                              </td>
                           </tr>
                            <tr>
                               <th>{{ translate('name') }}</th>
                               <td>{{ $gallery->name }}</td>
                            </tr>
                             <tr>
                               <th>{{ translate('short_description') }}</th>
                               <td>{{ $gallery->short_description }}</td>
                            </tr>

                            <tr>
                                <th>{{ translate('Status') }}</th>
                               <td><span class="badge bg-{{ $gallery->is_active==='1' ? 'success' : 'danger' }}">{{ $gallery->is_active==='1' ? translate('Active') : translate('Inactive') }}</span></td>
                            </tr>
                            @php
                              $images = explode(',', $gallery->images);
                           @endphp
                           <tr>
                              <th>{{ translate('images') }}</th>
                              <td class="text-center" colspan="3">
                                 @if (!empty($images) && is_array($images))
                                       @foreach ($images as $img)
                                       <a href="{{ uploads_url(trim($img)) }}" data-fancybox="group">
                                          <img src="{{ asset('public/filemanager/' . $img) }}" width="100" height="70" style="object-fit:cover" alt="">
                                       </a>
                                       @endforeach
                                 @else
                                       <img src="{{ asset('public/uploads/default.png') }}" width="50" height="50" alt="">
                                 @endif
                              </td>
                           </tr> 
                            <tr>
                                <th>{{ translate('Created By') }}</th>
                                <td>{{ get_crud_user_details($gallery->created_by,'name') }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('Created On') }}</th>
                                <td>{{ \Carbon\Carbon::parse($gallery->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>

                            <tr>
                               <th>{{ translate('Updated By') }}</th>
                               <td>{{ get_crud_user_details($gallery->updated_by,'name') }}</td>                              
                            </tr>
                            <tr>
                                <th>{{ translate('Updated On') }}</th>
                               <td>{{ \Carbon\Carbon::parse($gallery->updated_at)->format('M d, Y h:i A') }}</td>
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