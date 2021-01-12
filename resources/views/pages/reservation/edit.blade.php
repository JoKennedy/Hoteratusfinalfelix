@extends('layaouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Reservation Information')

{{-- Vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
	<div class="row">
		<div class="col s12">
			
			<div id="validation" class="card card-tabs">
				
				<div class="card-content">

					<div class="card-title">
						
						<div class="row center">
							<div class="col s12">
								<h5 class="center-align" style="font-weight: 900;">
									Reservation Information							
								</h5>
								<div class="input-field col s12 center-align">
									<img class="z-depth-4 circle responsive-img" width="75" src="{{$hotel->get_logo ?? 'https://ui-avatars.com/api/?name='.$hotel['name'].'&size=255'}}" alt=""/>
									<p>{{$hotel['name']}}</p>
								</div>

							</div>

						</div>

						@if(Session::has('message_success'))
							<div class="row">

								<div class="card-alert card gradient-45deg-green-teal">
									<div class="card-content white-text">
										<p>
											<i class="material-icons">check</i>
											{{Session::get('message_success')}}.
										</p>
									</div>
									<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								</div>
							</div>
						@endif
					<div class="row">
						<ul class="tabs">

							<li class="tab col p-5">
								<a class="active p-0" href="#details">Reservation Details</a>
							</li>
						</ul>
					</div>

					<form enctype="multipart/form-data" class="formValidate" action="{{ route('reservation.edit', $reservation['slug']) }}" style="margin-bottom: 20px;" id="formsumit" method="POST" >
						@csrf
						@method('PUT')
						<div class="row s12 right">
							<button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal"> Update</button>
							<a href="{{ route('reservation.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Reservation List</a>
						</div>
						<div class="row">
							<div id="details">
									<div class="row">
										<div class="input-field col s12">
											<label for="name">Name*</label>
											<input type="text" name="reservation[name]" value="{{old('reservation.name', $reservation['name'])}}" required>
											@error('reservation.name')
												<smal class="red-text">
													<p>{{ $message }}</p>
												</smal>
											@enderror
										</div>
									</div>			
								<div class="row">
									<div class="file-field input-field">
										<div class="btn">
											<label for="name">Phone</label>
											<input type="text" name="reservation[phone]" value="{{old('reservation.phone')}}" required>
											@error('reservation.phone')
												<small class="red-text">
													<p>{{ $message }}</p>
												</small>
											@enderror
										</div>
									</div>
								</div>		

								<div class="row">
									<div class="input-field col s12">
										<label for="email">Email*</label>
										<input type="text" name="reservation[email]" value="{{old('reservation.email')}}" required>
										@error('resservation.email')
											<small class="red-text">
												<p>{{ $message }}</p>
											</small>
										@enderror
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="fecha_entrada">Entry Date*</label>
										<input type="text" name="reservation[fecha_entrada]" value="{{old('reservation.fecha_entrada')}}">
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="fecha_salida">Departure Date*</label>
										<input type="text" name="reservation[fecha_salida]" value="{{old('reservation.fecha_salida')}}" required>
										@error('reservation.cfecha_salida')
											<small class="red-text">
												<p>{{ $message}}</p>
											</small>
										@enderror
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="address">Address*</label>
										<input type="text" name="reservation[address]" value="{{old('reservation.address')}}" required>
									@error('reservation.address')
										<small class="red-text">
											<p>{{ $message}}</p>
										</small>
									@enderror
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="conutry">Country*</label>
										<input type="text" name="reservation[country]" value="{{old('reservation.country')}}" required>
										@error('reservation.country')
											<small class="red-text">
												<p>{{ $message}}</p>
											</small>
										@enderror
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="gender">
											Gender
										</label>
										<input type="text" name="reservation[gender]" value="{{old('reservation.gender')}}" required>
										@error('reservation.gender')
											<small class="red-text">
												<p>{{ $message }}</p>
											</small>
										@enderror
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="nationality">
											Nationality
										</label>
										<input type="text" name="reservation[nationality]" value="{{old('reservation.nationality')}}" required>
										@error('reservation.nationality')
											<small class="red-text">
												<p>{{ $message}}</p>
											</small>
										@enderror
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="state">
											State
										</label>
										<input type="text" name="reservation[state]" value="{{('reservation.state')}}" required>
									@error('reservation.state')
										<small class="red-text">
											<p>{{ $message }}</p>
										</small>
									@enderror
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
										<label for="zip_code">Zip Code</label>
										<input type="text" name="reservation[zip_code]" value="{{old('reservation.zip_code')}}" required>
										@error('reservation.zip_code')
											<small class="red-text">
												<p>{{ $message }}</p>
												
											</small>
										@enderror
									</div>
								</div>

							</div>
						</div>

						<div class="row s12 right">
							
							<button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal">Update		
							</button>
							<a href="{{ route('reservation.index')}}" class="mb-6 btn waves-light gradient-45deg-purple-deep-orange"></a>
						</div>


					</form>
				</div>



					
				</div>
			</div>
		</div>
	</div>
</div>


	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Edit Reservation</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-primary" href="{{route('reservation.index')}}" title="Go back">
					<i class="fas fa-backward"></i> </a>
			</div>
		</div>
	</div>

	@if ($error->any())
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors-all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form action="{{ route('reservation.update', $reserva->id) }}" method="POST" >
		@csrf
		@method('PUT')

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<strong>Name</strong>
				<input type="text" name="name" value="{{$reserva->name}}" class="form-control" placeholder="Name">
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<strong>Phone</strong>
				<input type="text" name="phone" value="{{$reserva->phone}}" class="form-control" placeholder="Phone">
			</div>
		</div>

	</form>
@endsection	