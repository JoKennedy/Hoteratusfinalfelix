    @if ($active == 1)
        <td><a data-token="{{ csrf_token() }}" href="javascript:void(0)" onclick="deactive('{{$id}}', this)" class="chip lighten-5 green green-text">Active</a></td>
    @else
        <td><a data-token="{{ csrf_token() }}" href="javascript:void(0)" onclick="deactive('{{$id}}', this)" class="chip lighten-5 red red-text">Deactivated</a></td>
    @endif
