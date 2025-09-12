@php $permissions_array = isset($id) && !empty(json_decode(getColumnValue('role',['id'=>decode_string($id)],'permissions'))) ? json_decode(getColumnValue('role',['id'=>decode_string($id)],'permissions'),true) : array();  @endphp
<div class="modal d-block pos-static">
   <form action="{{ $page_action }}" method="post" class="data-parsley-validate"  data-block_form="true">
      <input class="form-control" name="id" type="hidden" value="{{ isset($id) && $id!= '' ? $id : '' }}">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document"> 
         <div class="modal-content">
            <div class="modal-header">
               <h6 class="modal-title">{{ $page_title }}</h6>
               <button aria-label="Close" class="btn-close close-popup" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-8">
                     <div class="form-group text-left">
                        <label>{{ translate('Name') }} <span class="tx-danger">*</span></label>
                        <input class="form-control txt-submit" name="name" placeholder="{{ translate('Enter Name') }}" type="text" tabindex="1" value="{{ isset($user['name']) && $user['name'] != '' ? $user['name'] : ''  }}" required>
                     </div>
                  </div>
               @php
                  $status_list = ['' => translate("Select"), '1' => translate("Active"), '0' => translate("Inactive")];
               @endphp
               <div class="col-md-4">
                  <div class="form-group text-left">
                     <label>{{ translate('Status') }} <span class="tx-danger">*</span></label>
                     <select name="is_active" class="form-control select2-modal" data-parsley-errors-container="#error_status" tabindex="2" required>
                        @if(isset($status_list) && !empty($status_list))
                           @foreach($status_list as $key => $value)
                              @php $selected = isset($user['is_active']) && $user['is_active'] == $key ? 'selected' : ''  @endphp
                              <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
                           @endforeach
                        @endif
                     </select>
                     <span id="error_status"></span>
                  </div>
               </div>
            </div>
            @php
               $role_data['dashboard'] = array('dashboard');
               $role_data['enquiry'] = array('enquiry');
               $role_data['slider'] = array('list','add','edit');
               $role_data['blog'] = array('list','add','edit');
               $role_data['video'] = array('list','add','edit');
               $role_data['journey'] = array('list','add','edit');
               $role_data['hospital_help'] = array('list','add','edit');
               $role_data['ringtone'] = array('list','add','edit');
               $role_data['our_indapur'] = array('list','add','edit');
               $role_data['gallery'] = array('list','add','edit');
               $role_data['wallpapers'] = array('list','add','edit');
               $role_data['page'] = array('list','add','edit');
               $role_data['role'] = array('list','add','edit');
               $role_data['filemanager'] = array('browse','upload','create','delete','rename');
               $role_data['user'] = array('list','add','edit','password','2FA');
               $role_data['settings'] = array('basic','theme','application','security');
            @endphp
            <div class="row">
               @foreach ($role_data as $role => $actions)
                  @if(isset($permissions[$role]) || empty($permissions))             
                     <div class="col-md-4">
                        <div class="card custom-card">
                           <div class="card-header tx-medium tx-white bg-primary">{{ translate($role) }} </div>
                           <div class="card-body">
                           <div class="row">
                              @foreach ($actions as $action) 
                                 @if(isset($permissions[$role][$action]) || empty($permissions))
                                    <div class="col-md-6">
                                       <div class="custom-control custom-checkbox mr-2">
                                          <input type="checkbox" class="custom-control-input" id="{{ $role.'_'.$action }}" name="permissions[{{ $role }}][{{ $action }}]"  {{ isset($permissions_array[$role][$action]) ? 'checked' : '' }}  />
                                          <label class="custom-control-label" for="{{ $role.'_'.$action }}"> {{ translate($action) }}</label>
                                       </div>
                                    </div>
                                 @endif
                              @endforeach
                           </div>
                           </div>
                        </div>
                     </div>
                  @endif
               @endforeach
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn ripple btn-submit btn-primary" data-loading-text="<span aria-hidden='true' class='spinner-border spinner-border-sm'></span> {{ translate('please_wait...') }}" tabindex="7">{{ translate('Submit') }}</button>
            <button class="btn ripple close-popup btn-secondary" type="button">{{ translate('Close') }}</button>
         </div>
      </div>
   </form>
   <script type="text/javascript">
      $(document).ready(function () {
         init_select2modal();
      });
   </script>
</div>