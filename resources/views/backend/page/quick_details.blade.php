<style>
   .desc{
      max-height: 200px;
      overflow-y: auto;
   }

   ::-webkit-scrollbar-thumb {
      background: #512d56 !important;
   }

</style>
<div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Page Details') }}</h6>
             <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
             <div class="row">
                <div class="col-md-12">

                   <div class="table-responsive">      
                      <table class="table table-bordered mg-b-0">
                         <tbody>
                           <tr>
                               <th>{{ translate('name') }}</th>
                               <td>{{ $page->name }}</td>
                                <th>{{ translate('Status') }}</th>
                               <td><span class="badge bg-{{ $page->is_active==='1' ? 'success' : 'danger' }}">{{ $page->is_active==='1' ? translate('Active') : translate('Inactive') }}</span></td>
                            </tr>
                            <tr>
                              <th>{{ translate('Description') }}</th>
                              <td colspan="3">
                                 <div class="desc">
                                    {!! $page->description ? $page->description : '-' !!}
                                 </div>
                              </td>
                            </tr>            
                            <tr>
                                <th>{{ translate('Created By') }}</th>
                                <td>{{ get_crud_user_details($page->created_by,'name') }}</td>
                            
                                <th>{{ translate('Created On') }}</th>
                                <td>{{ \Carbon\Carbon::parse($page->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('Updated By') }}</th>
                               <td>{{ get_crud_user_details($page->updated_by,'name') }}</td>
                              
                                <th>{{ translate('Updated On') }}</th>
                               <td>{{ \Carbon\Carbon::parse($page->updated_at)->format('M d, Y h:i A') }}</td>
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