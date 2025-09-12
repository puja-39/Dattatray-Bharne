@extends('backend.app')
@section('page_title'){{ translate('Dashboard') }}@stop
@section('content')
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">{{ translate('Welcome To Dashboard') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{ translate('Dashboard') }}</li>
            </ol>
        </div>
    </div>

	@php
		//print_r($role_id);
	@endphp

	@if($role_id == 1 || $role_id == 3 )

		<div class="row row-sm">
			<div class="col-sm-6 col-xl-4 col-lg-6">
				<div class="card custom-card">
					<div class="card-body dash1">
						<div class="d-flex">
							<p class="mb-1 tx-inverse">{{ translate('Number Of Blogs') }}</p>
							<div class="ms-auto">
								<i class="fa fa-list fs-20 text-secondary"></i>
							</div>
						</div>
						<div>
							<h3 class="dash-25">{{$blog_count }}</h3>
							</div>
						<div class="progress mb-1">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="70"
								class="progress-bar progress-bar-xs wd-60p bg-secondary" role="progressbar">
							</div>
						</div>
						<div class="expansion-label d-flex text-muted">
						<span class="ms-auto "><a href="{{ route('admin.blog') }}">{{ translate('view all') }}</a></span>
					</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-4 col-lg-6">
				<div class="card custom-card">
					<div class="card-body dash1">
						<div class="d-flex">
							<p class="mb-1 tx-inverse">{{ translate('Our Indapur') }}</p>
							<div class="ms-auto">
								<i class="fa fa-users fs-20 text-success"></i>
							</div>
						</div>
						<div>
							<h3 class="dash-25">{{ $our_indapur_count }}</h3>
							</div>
						<div class="progress mb-1">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="70"
								class="progress-bar progress-bar-xs wd-50p bg-success" role="progressbar"></div>
						</div>
						<div class="expansion-label d-flex text-muted">
						<span class="ms-auto "><a href="{{ route('admin.our_indapur') }}">{{ translate('view all') }}</a></span>
					</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-4 col-lg-6">
				<div class="card custom-card">
					<div class="card-body dash1">
						<div class="d-flex">
							<p class="mb-1 tx-inverse">{{ translate('Number Of Enquiry') }}</p>
							<div class="ms-auto">
								<i class="fa fa-signal fs-20 text-info"></i>
							</div>
						</div>
							<div>
							<h3 class="dash-25">{{ $enquiry_count}}</h3>
							</div>
						<div class="progress mb-1">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="70"
								class="progress-bar progress-bar-xs wd-40p bg-info" role="progressbar"></div>
						</div>
						<div class="expansion-label d-flex text-muted">
						<span class="ms-auto "><a href="{{ route('admin.enquiry.contact') }}">{{ translate('view   all') }}</a></span>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row sidemenu-height">
			<div class="row sidemenu-height">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card-header custom-card-header bg-primary">
					<h5 class="card-title tx-white mb-0"><?php echo translate('Enquire'); ?></h5>	
					<div class="card-options">
						<a href="javascript:void(0);" class="card-options-collapse" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
						<a href="javascript:void(0);" class="card-options-fullscreen" data-bs-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
					</div>
				</div>
				<div class="card custom-card">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table data-list-table">
								<thead>
									<tr>
										<th>#</th>
										<th>{{ translate('Name') }}</th>
										<th>{{ translate('Email_Id') }}</th>
										<th>{{ translate('Phone_Number') }}</th>
										<th>{{ translate('Message') }}</th>
										<th>{{ translate('Created On') }}</th>
										<th>{{ translate('Actions') }}</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>#</th>
										<th>{{ translate('Name') }}</th>
										<th>{{ translate('Email_Id') }}</th>
										<th>{{ translate('Phone_Number') }}</th>
										<th>{{ translate('Message') }}</th>
										<th>{{ translate('Created_on') }}</th>
										<th>{{ translate('Actions') }}</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card custom-card">
					<div class="card-body">
						<h6>{{ translate('Welcome to dashboard') }}</h6>
					</div>
				</div>
			</div>
		</div>
	@endif		
@endsection
@section('script_files')
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/datatable/datatables.min.js') }}"></script>
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/datatable/dataTables.responsive.min.js') }}"></script>
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
@endsection
@section('script')
	<script>
		$(document).ready(function () {
			$('.data-list-table').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "{{ route('admin.dashboard.contact_list') }}",
					"dataType": "json",
					"type": "POST",
					"data": {action : 'contact_list'},
					"headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					"error": function(){ $(".data-list-table").css("display","none"); },
					"beforeSend": function () { },
					"complete": function () {
						initDatatableOptions();
					}
				},
				"columns": [
					{"data": "id", orderable: false, searchable: false, className: 'text-center'},
					{"data": "name", orderable: false, className: 'text-center'},
					{"data": "email_id", searchable: false, className: 'text-center'},
					{"data": "phone_no", searchable: false, className: 'text-center'},
					{"data": "message", searchable: false, className: 'text-center'},
					{"data": "created_at", searchable: false, className: 'text-center'},
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
				order: [[4, "desc"]],
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
    </div>
@endsection