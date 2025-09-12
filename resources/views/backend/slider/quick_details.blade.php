<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Slider Details') }}</h6>
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
                                 <?php echo $slider->image ? '<img src="' . asset('public/filemanager/' . $slider->image) . '" class="" width="70" height="50" alt="" style="object-fit:cover">': '<img src="' . asset('public/uploads/default_old.png') . '" class="" width="50" height="50" alt="">';?>
                              </td>
                           </tr>
                            <tr>
                               <th>{{ translate('name') }}</th>
                               <td>{{ $slider->name }}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('title') }}</th>
                               <td>@empty($slider->title) - @else {{ $slider->title }} @endempty</td>
                            </tr>
                            <tr>
                               <th>{{ translate('sub title') }}</th>
                               <td>@empty($slider->subtitle) - @else {{ $slider->subtitle }} @endempty</td>
                            </tr>
                            <tr>
                               <th>{{ translate('type') }}</th>
                               <td>{{ $slider->type }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('Status') }}</th>
                               <td><span class="badge bg-{{ $slider->is_active==='1' ? 'success' : 'danger' }}">{{ $slider->is_active==='1' ? translate('Active') : translate('Inactive') }}</span></td>
                            </tr>
                            <tr>
                                <th>{{ translate('Created By') }}</th>
                                <td>{{ get_crud_user_details($slider->created_by,'name') }}</td>
                            </tr>

                            <tr>
                                <th>{{ translate('Created On') }}</th>
                                <td>{{ \Carbon\Carbon::parse($slider->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>

                            <tr>
                               <th>{{ translate('Updated By') }}</th>
                               <td>{{ get_crud_user_details($slider->updated_by,'name') }}</td>
                              
                            </tr>

                            <tr>
                                <th>{{ translate('Updated On') }}</th>
                               {{-- <td>{{ \Carbon\Carbon::parse($updated_at)->format('M d, Y h:i A') }}</td> --}}
                               <td>{{ \Carbon\Carbon::parse($slider->updated_at)->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}</td>
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