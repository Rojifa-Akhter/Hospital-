@for ($i = 1; $i <= $installment; $i++)
    <tr>
        <td>{{ $i }}</td>
        <td> <input type="text" name="date_arr[]" class="form-control form-control-sm date_picker" id="month" name="month" placeholder=""
                value="{{ date('d-m-Y', strtotime($date)) }}" /> </td>
        <td class="text-right">{{ $install_amt }}</td>
    </tr>
    @php
        $date = date('Y-m-d', strtotime($date));
        $date = date('Y-m-d', strtotime('+1 month', strtotime($date)));
    @endphp
@endfor
