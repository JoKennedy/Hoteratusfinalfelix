@php
    $total = $roomType->images->count();
    if($total >0){
        $image =$roomType->images[rand(0,$total-1)];
        $url =url($image ->get_image);
        $alt = $image->caption;
    }else{
        $url = "https://ui-avatars.com/api/?name={$roomType->name}&size=255";
        $alt =$roomType->name;
    }
@endphp
<td>
    <div class="responsive-img border-radius-4" >
    <img style="width: 122px; height: 77px;"
    src="{{$url}}"
    alt="{{$alt}}">
    </div>
</td>
