@extends('layouts.contentLayoutMaster')


@section('content')


<h3 class="text-center title-color"> </h3>
	<div class="well" id="app">
		<drag :tasks-completed="{{$tasksCompleted }}" :tasks-not-completed="{{ $tasksNotCompleted }}">
			
		</drag>
	</div><!-- end app -->
	 <button class="btn btn-default" onclick="window.location.reload()"><b>REFRESH</b></button>
                                                                                                       
	<script src="{{ asset('js/app.js')}}"></script>
</div>


@stop