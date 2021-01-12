
<td>
    <div class="invoice-action" style="display: flex;">
        <a href="{{ route('departments.show', $id)}}" class="invoice-action-view mr-6"> <i class="material-icons">remove_red_eye</i> </a>
        @if ($editable == 0)
            <a href="{{ route('departments.edit', $id)}}"  class="invoice-action-edit mr-6" > <i class="material-icons">edit</i> </a>
        @endif
    </div>
</td>
