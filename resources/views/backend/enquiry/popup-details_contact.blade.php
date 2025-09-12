 <div class="modal d-block pos-static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h6 class="modal-title">{{ translate('Enquiry  Details') }}</h6>
             <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
             <div class="row">
                <div class="col-md-12">
                   <div class="table-responsive">      
                      <table class="table table-bordered table-hover mg-b-0">
                         <tbody>
                            <tr>
                               <th>{{ translate('Name') }}</th>
                               <td>{{ $name }}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('Subject') }}</th>
                               <td>{{ $subject }}</td>
                            </tr>
                             <tr>
                               <th>{{ translate('Email_id') }}</th>
                               <td>{{ $email}}</td>
                            </tr>
                             <tr>
                               <th>{{ translate('Phone_Number') }}</th>
                               <td>{{ $phone_no }}</td>
                            </tr>
                              <tr>
                               <th>{{ translate('Message') }}</th>
                               <td>{{ $message }}</td>
                            </tr>
                            <tr>
                               <th>{{ translate('Created on') }}</th>
                                <td>{{ \Carbon\Carbon::parse($created_at)->format('M d, Y h:i A') }}</td>
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