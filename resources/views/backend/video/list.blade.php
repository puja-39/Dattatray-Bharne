@extends('backend.app')
@section('page_title'){{ translate('Video') }} @endsection
@section('style_files')
<link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/summernote/summernote-lite.min.css') }}">
<link rel="stylesheet" href="{{ static_asset('assets/backend/plugins/jstree/jstree.css') }}">
@endsection
@section('script_files')
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/datatable/datatables.min.js') }}"></script>
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/datatable/dataTables.responsive.min.js') }}"></script>
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/summernote/summernote-lite.min.js') }}"></script>
	<script type="text/javascript" src="{{ static_asset('assets/backend/plugins/summernote/init.js') }}"></script>
@endsection
@section('content')
	<div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">{{ translate('Video') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ translate('Dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ translate('List') }}</a></li>
            </ol>
        </div>
		<div class="btn btn-list">
				<a class="btn ripple popup-page btn-primary" href="{{ route('admin.video.new') }}"><i class="fe fe-plus-circle ml-2"></i> {{ translate('Add New') }}</a>
		</div>
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
									<th>{{ translate('Date') }}</th>
									<th>{{ translate('Status') }}</th>
									<th>{{ translate('Actions') }}</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>#</th>
									<th>{{ translate('Image') }}</th>
									<th>{{ translate('Name') }}</th>
									<th>{{ translate('Date') }}</th>
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
					"url": "{{ route('admin.video.list') }}",
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
					{"data": "image", orderable: false, searchable: false, className: 'text-center'},
					{"data": "name", orderable: false, className: 'text-center'},
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
				order: [[2, "desc"]],
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