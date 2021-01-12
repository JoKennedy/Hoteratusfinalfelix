
<td>
    <div class="invoice-action" style="display: flex;">
            @if ($featured == 1)
                <a data-token="{{ csrf_token() }}" href="javascript:void(0)" onclick="featured('{{$id}}', this)"  class="invoice-action-edit mr-6" > <i class="material-icons">star</i> </a>
            @else
                <a data-token="{{ csrf_token() }}" href="javascript:void(0)" onclick="featured('{{$id}}', this)"  class="invoice-action-edit mr-6" > <i class="material-icons">star_border</i> </a>
            @endif
    </div>
</td>

