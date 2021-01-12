<div>
<a href="{{route('rooms.index', ['block_id'=>$id])}}">{{$rooms_count }} {{Str::plural('Room', $rooms_count )}}</a> /
<a href="{{route('rooms.create', ['block_id'=>$id])}}">Add New</a>
</div>
