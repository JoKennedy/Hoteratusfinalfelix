


<select data-token="{{ csrf_token() }}" data-campo="Deparment" data-name="property_department_id" data-id="{{$phoneExtension->id}}"  onchange="saveChange(this)"  name="deparment[{{$phoneExtension->id}}]" value="{{$phoneExtension->property_department_id}}" class="browser-default p-0">
    <option value="">Select a Department</option>
    @foreach ($property_departments as $item)
        <option value="{{$item->id}}" {{$phoneExtension->property_department_id == $item->id? 'selected':''}}>{{$item->name}}</option>
    @endforeach
</select>

