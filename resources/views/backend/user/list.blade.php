@extends('backend.app')
@section('page_title'){{ translate('User') }}@endsection
@section('script_files')
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/datatable/datatables.min.js') }}"></script>
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/datatable/dataTables.responsive.min.js') }}"></script>
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/intl-tel-input/js/intlTelInput.min.js') }}"></script>

@endsection
@section('content')
	<div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">{{ translate('user') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ translate('List') }}</a></li>
            </ol>
        </div>
		@if (valid_session('user', 'add', false))
			<div class="btn btn-list">
				<a class="btn ripple popup-page btn-primary" href="{{ route('admin.user.new') }}"><i class="fe fe-plus-circle ml-2"></i> {{ translate('Add New') }}</a>
			</div>
		@endif

    </div>

	
	<div class="row sidemenu-height">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card custom-card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table data-list-table">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ translate('Image') }}</th>
									<th>{{ translate('Name') }}</th>
									<th>{{ translate('Email ID') }}</th>
									<th>{{ translate('Mobile No') }}</th>
									<th>{{ translate('Role') }}</th>
									<th>{{ translate('Created On') }}</th>
									<th>{{ translate('Status') }}</th>
									<th>{{ translate('Actions') }}</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>#</th>
									<th>{{ translate('Image') }}</th>
									<th>{{ translate('Name') }}</th>
									<th>{{ translate('Email ID') }}</th>
									<th>{{ translate('Mobile No') }}</th>
									<th>{{ translate('Role') }}</th>
									<th>{{ translate('Created On') }}</th>
									<th>{{ translate('Status') }}</th>
									<th>{{ translate('Actions') }}</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script>
		$(document).ready(function () {
			$('.data-list-table').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "{{ route('admin.user.list') }}",
					"dataType": "json",
					"type": "POST",
					"data": {action : 'list'},
					"headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					"error": function(){ $(".data-list-table").css("display","none"); },
					"beforeSend": function () { },
					"complete": function () {
						initDatatableOptions();
					}
				},
				"columns": [
					{"data": "id", orderable: false, searchable: false, className: 'text-center'},
					{"data": "profile_image", orderable: false, className: 'text-center'},
					{"data": "name", orderable: false, className: 'text-center'},
					{"data": "email_id", orderable: false, className: 'text-center'},
					{"data": "mobile_no", orderable: false, className: 'text-center'},
					{"data": "Role", orderable: false, className: 'text-center'},
					{"data": "created_at", searchable: false, className: 'text-center'},
					{"data": "status", orderable: false, searchable: false, className: 'text-center'},
					{"data": "actions", orderable: false, searchable: false, className: 'text-center'}
				],
				bAutoWidth: false,
				responsive: true,
				searchDelay: 1500,
				columnDefs: [{
					orderable: false,
					targets: 0
				}],
				fixedHeader: {
					header: true,
					footer: true
				},
				oLanguage: {
					sZeroRecords: "{{ translate('No Results Available') }}",
					sSearch: "{{ translate('Search') }}",
					sProcessing: "{{ translate('Please Wait...') }}",
					oPaginate: {
						sFirst: "{{ translate('First') }}",
						sPrevious: "{{ translate('Previous') }}",
						sNext: "{{ translate('Next') }}",
						sLast: "{{ translate('Last') }}"
					}
				},
				aLengthMenu: {{ create_dt_length_menu(app_setting('records_per_page','10')) }},
				order: [[6, "desc"]],
				bInfo: true,
				pageLength: {{ app_setting('records_per_page','10') }},
				buttons: [],
				initComplete: function () {
					initDatatableOptions();
				}
			}).on( 'responsive-display', function ( e, datatable, row, showHide, update ) {
				initDatatableOptions();
			});
		});
	</script>
@endsection