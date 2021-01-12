
<td style="text-align: center;">
    <div style="text-align: center !important; color: #1b5e20;">
            @if ($active == 2)
                <a href="{{ route('frontdesk-packages.edit', $id)}}"  class="invoice-action-edit mr-6" > <i   style="text-align: center !important; color: #1b5e20;" class="material-icons">settings</i> </a>
            @else
                <a href="{{ route('frontdesk-packages.edit', $id)}}"  class="invoice-action-edit mr-6" > <i   style="text-align: center !important; color: #1b5e20;" class="material-icons">edit</i> </a>
            @endif
    </div>

</td>
