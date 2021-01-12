


<select data-token="{{ csrf_token() }}" data-campo="Room" data-name="room_id" data-id="{{$phoneExtension->id}}"  onchange="saveChange(this)" name="phoneExtension[{{$phoneExtension->id}}]" value="{{$phoneExtension->room_id}}" class="browser-default p-0">
    <option value="">Select a Room</option>
    @foreach ($rooms as $item)
        <option value="{{$item->id}}" {{$phoneExtension->room_id == $item->id? 'selected':''}}>{{$item->name}}</option>
    @endforeach
</select>

