@switch($status_id)
    @case(1)
    	<td><a data-token="{{ csrf_token() }}" href="#" onclick="deactive('{{$id}}', this)" class="chip lighten-5 green green-text">Completed</a></td>
        @break

    @case(2)
    	<td><a data-token="{{ csrf_token() }}" href="#" onclick="deactive('{{$id}}', this)" class="chip lighten-5 blue blue-text">Doing</a></td>
        @break

    @case(3)
    	<td><a data-token="{{ csrf_token() }}" href="#" onclick="deactive('{{$id}}', this)" class="chip lighten-5 red red-text">Pending</a></td>
        @break    
@endswitch

