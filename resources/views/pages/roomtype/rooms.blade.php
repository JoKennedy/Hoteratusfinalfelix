<a href="{{route('rooms.index', ['room_type_id'=>$id])}}">{{$rooms_count }} {{Str::plural('Room', $rooms_count )}}</a> /
<a href="{{route('rooms.create', ['room_type_id'=>$id])}}">Add New</a>
