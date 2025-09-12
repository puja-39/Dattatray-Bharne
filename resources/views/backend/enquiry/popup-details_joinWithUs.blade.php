 <div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Join With Us  Details') }}</h6>
             <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
             <div class="row">
                <div class="col-md-12">
                   <div class="table-responsive"> 
                    {{-- @php print_r('subscribe') @endphp      --}}
                      <table class="table table-bordered table-hover mg-b-0">
                         <tbody>
                            <tr>
                               <th>{{ translate(' Newsletter Email') }}</th>
                               <td>{{ $subscribe->newsletter_email}}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('Created at') }}</th>
                               <td>{{ \Carbon\Carbon::parse($subscribe->created_at)->format('M d, Y h:i A') }}</td>
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