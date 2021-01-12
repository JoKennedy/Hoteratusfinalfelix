{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')


{{-- page title --}}
@section('title', 'Reservaciones')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
<!-- invoice list -->
<section class="invoice-list-wrapper section">
	

<!-- create invoice button -->
	<div class=" invoice-create-btn">
		<a href="{{ route('reservation.create')}}" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
			<i class="material-icons">add</i>
			<span class="hide-on-small-only">Create Reservation</span>
		</a>
	</div>


<div class="filter-btn">
	<a class='dropdown-trigger btn waves-effect waves-light purple darken-1 border-round' href="#" data-target='btn-filter'>
		<span class="hide-on-small-only">Filter Reservation</span>
		<i class="material-icons">keyboard_arrow_down</i>
	</a>
	<ul id='btn-filter' class="dropdown-content">
		<li><a href="javascript:void(0)" onclick="filter('1')">Active</a></li>
		<li><a href="javascript:void(0)" onclick="filter('0')">Inactive</a></li>
		<li><a href="javascript:void(0)" onclick="filter('')">All</a></li>
	</ul>
</div>


<div class="responsive-table">
	<table class="table invoice-data-table white border-radius-4 pt-1">
		<thead>
			<tr>

				<!-- data table checkbox -->
				<th></th>

				<th>
					<spane>name</spane>
				</th>
				<th>phone</th>
				<th>email</th>
				<th>fecha entrada</th>
				<th>fecha salida</th>
				<th>address</th>
				<th>country</th>
				<th>gender</th>
				<th>nationality</th>
				<th>state</th>
				<th>zip code</th>
			</tr>
			</thead>
			<thead>
				@foreach ($reservations as $reser)
					<tr>
						<th></th>
						<td>{{$reser->name}}</td>
						<td>{{$reser->phone}}</td>
						<td>{{$reser->email}}</td>
						<td>{{$reser->fecha_entrda}}</td>
						<td>{{$reser->fecha_salida}}</td>
						<td>{{$reser->address}}</td>
						<td>{{$reser->country}}</td>
						<td>{{$reser->gender}}</td>
						<td>{{$reser->nationality}}</td>
						<td>{{$reser->state}}</td>
						<td>{{$reser->zip_code}}</td>
					</tr>
				@endforeach
			</thead>
		

	</table>

	<div>
		<h1>Informe de asistencia</h1>
<p>Por este medio se le informa que el
    alumno  no ha asistido a clases el
    día de hoy</p></div>
</div>
<input type="hidden" id="filter" />
@csrf
</section>
@endsection

{{-- vendor stripts --}}
@section('vendor-script')
<script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
@endsection


{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>

<script >
	function deactive(id, obj){

		swal({
			title: "Are you sure?",
			text: "You can activate it, when you need it!",
			icon: 'Warning',
			dangerMode: true,
			buttons: {
				cancel: 'No, Please!',
				delete: 'Yes, Deactivate It'
			}
		}).then(function (willDelete) {
			if(willDelete){
				$.ajax({
					url: "{!!URL::to('reservation/"+id+"' )!!}",
					method: 'DELETE',
					data: {_token: $(obj).data("token")}
				}).done(function(response){
					if(response.active == 1){
						$(obj).html('Active');
						$(obj).removeClass(['red', 'red-text']);
						$(obj).addClass(['green', 'green-text']);
					}else{
						$(obj).html('Deactivated');
						$(obj).removeClass(['green', 'green-text']);
						$(obj).addClass(['red', 'red-text']);
					}
					swal("Reservation has been deactive!", {
						icon: "success",
					});
				}).fail(function(response){
					console.log(respose)
				});
			} else {
				swal("Your reservation is safe", {
					title: 'Cancelled',
					icon: 'error',
				});
			}
		});
	}

	function filter(active){
		$('#filter').val(active);
		$('.invoice-data-table').DataTable().ajax.reload();
	}
	function fetch_data( active = '') {
		$('#filter').val(active);
		var dataListView = $(".invoice-data-table").DataTable({
			"processing": true,
			serverSide: true,
			bAutoWidth: false,
			aaSorting: [],
		"ajax": {
			"url": "{{ url('reservation')}}",
			"data": function( d ) {
				d.active= $('#filter').val();
			}
		} ,
		columns: [
			{data: 'id'},
			{data: 'name'},
			{data: 'btnrooms'},
			{data: 'btn'},
			{data: 'status'},
		],

		columnDefs: [
			{
				orderable: true,
				targets: 0,

				checkboxes: {selectRow: true}
			},

			{ "orderable": false, "targets": 3 },
		],

		order: [1, 'asc'],
		dom:
			'<"top display-flex mb-2"<"action-filters"f><"actions action-btns display-flex align-items-center">><"clear">rt<"bottom"p>',
		language: {
			search: "",
			searchPlaceholder: "Search Reservation"
		},
		select: {
			style: "multi",
			selector: "td:first-child",
			items: "row"
		},
		responsive:{
			details:{
				type: "column",
				target: 0
			}
		}
		});

		var invoiceFilterAction = $(".invoice-filter-action");
		var invoiceCreateBtn = $(".invoice-create-btn");
		var filterButton = $(".filter-btn");
		$(".action-btns").append(invoiceFilterAction, invoiceCreateBtn);
		$(".dataTables_filter label").append(filterButton);


	}
	$(document).ready(function() {
		fetch_data();
	});

</script>
@endsection

