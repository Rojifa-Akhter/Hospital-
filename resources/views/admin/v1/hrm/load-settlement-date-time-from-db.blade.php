@if (!empty($loanDtls))
    @foreach ($loanDtls as $loan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td> <input type="text" name="date_arr[]" class="form-control form-control-sm date_picker" id="month"
                    name="month" placeholder="" value="{{ date('d-m-Y', strtotime($loan->installment_date)) }}"></td>
            <td class="text-right">{{ $loan->installment_amt }}</td>

        </tr>
    @endforeach
@endif
