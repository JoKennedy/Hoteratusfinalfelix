<div>
<a href="{{route('rooms.index', ['floor_id'=>$id])}}">{{$rooms_count }} {{Str::plural('Room', $rooms_count )}}</a> /
<a href="{{route('rooms.create', ['floor_id'=>$id])}}">Add New</a>
</div>
