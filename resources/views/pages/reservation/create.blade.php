{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'create a new Reservation')

{{-- vendor style --}}
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
								<h5 class="center-align" style="font-weight: 900;">Create a New Reservation</h5>	
							</div>

							@if(Session::has('massage_success'))
							<div>
								<div class="card-alert card gradient-45deg-green-teal">
									<div class="card-content white-text">
										<p>
											<i class="material-icons">
												check
											</i>
											{{Session::get('message_success')}}
										</p>
									</div>
									<button type="button" class="close white-text" data-dismiss="alert" aria-label="close"><span arial-hidden="true">×</span></button>
								</div>
							</div>
							@endif							
						</div>

						<div class="row">
							<ul class="tabs">
								<li class="tab col p-5">
									<a class="active p-0" href="#details"> Reservation Details</a>
								</li>

							</ul>
						</div>						
					</div>
	@if ($errors->any())
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }} </li>
				@endforeach
			</ul>
		</div>
	@endif

<form enctype="multipart/form-data" class="formValidate" action="{{route('reservation.store')}}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
				@csrf
				<div class="row s12 right">
					<button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal">Save</button>
					<a href="{{route('reservation.index')}}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Reservation List</a>
				</div>

				<div class="row">
					<div class="details">
							<div class="row">
								<div class="input-field col s12">
									<label for="Name">Name*</label>
									<input type="text" name="reservation[name]" value="{{old('reservation.name')}}" required>
									@error('reservation.name')
									<small class="red-text">
										<p>{{$message}}</p>
									</small>
									@enderror
								</div>
							</div>
						<div class="row">
							<div class="input-field col s12">
								<label for="phone">Phone*</label>
								<input type="text" name="reservation[phone]" value="{{old('reservation.phone')}}" required>
								@error('reservation.phone')
									<small class="red-text">
										<p>{{ $message}}</p>
									</small>
								@enderror
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12">
								<label for="email">Email*</label>
								<input type="text" name="reservation[email]" value="{{old('reservation.email')}}" required>
								@error('reservation.email')
									<small class="red-text">
										<p>{{ $message}}</p>
									</small>
								@enderror
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12">
								<label for="fecha_entrada">Entry Date*</label>
								<input type="text" name="reservation[fecha_entrada]" value="{{old('reservation.fecha_entrada')}}" required>
								@error('reservation.fecha_entrada')
									<small class="red-text">
										<p>{{ $message}}</p>
									</small>
								@enderror
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12">
								<label for="fecha_salida">Departure Date*</label>
								<input type="text" name="reservation[fecha_salida]" value="{{old('reservation.fecha_salida')}}" required>
								@error('reservation.fecha_salida')
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
								<label for="country">Country*</label>
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
								<label for="gender">Gender</label>
								<input type="text" name="reservation[gender]" value="{{old('reservation.gender')}}" required>
								@error('reservation.gender')
									<small class="red-text">
										<p>{{ $message}}</p>
									</small>
								@enderror
							</div>
						</div>

						<div class="row">
							<div class="input-field col s12">
								<label for="nationality">Nationality</label>
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
								<label for="state">State</label>
								<input type="text" name="reservation[state]" value="{{old('reservation.state')}}" required>
								@error('reservation.state')
									<small class="red-text">
										<p>{{ $message}}</p>
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
										<p>{{ $message}}</p>
									</small>
								@enderror
							</div>
					</div>


					</div>
				</div>

				  <div class="row s12 right">
                   <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('reservation.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Reservation List</a>
                </div>
</form>


					
				</div>
			</div>
		</div>
	</div> 
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/jquery-validation/jquery-validate.min.js')}}"></script>

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/script/form-validation.js')}}"></script>
<script src="{{asset('js/script/ui-alerts.js')}}"></script>
@endsection

