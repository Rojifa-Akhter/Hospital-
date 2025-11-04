@if (!empty($radiology_data))
    @foreach ($radiology_data as $value)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $value->invoice_code }}</td>
            <td class="text-left">{{ $value->item_name }}</td>
            <td class="text-left">
                {{ $value->report_delivary_date !="" ? date('d/m/Y', strtotime($value->report_delivary_date)) : '' }}
            </td>
            <td class="text-left">{{ $value->hospital_code }}</td>
            <td class="text-center">
                
                @if($value->finalize_key_ind == 1)
                    {{-- <a class="btn btn-outline-primary btn-sm bg-none cursor-pointer "
                    href="{{ route('radiology.rad-report-pdf', $value->radinvoicedtl_no_pk) }}" target="_blank"><i
                        class="fa fa-file-pdf"></i></a> --}}
                    <a class="btn btn-outline-primary btn-sm bg-none cursor-pointer "
                    href="{{ route('v3.radiology.rad-report-pdf', $value->radinvoicedtl_no_pk) }}" target="_blank"><i
                        class="fa fa-file-pdf"></i></a>
                    <button type="button" class="btn btn-sm btn-outline-info bg-none cursor-pointer" data-report_id="{{$value->radinvoicedtl_no_pk}}"><i class="fa fa-envelope"></i></button> 
                @else
                    Pending
                @endif
               
            </td>
            <td class="text-center">
                @if ($image_capture)
                    <?php $i = 0; ?>
                    @foreach ($image_capture as $key => $val)
                        @if ($value->radinvoicedtl_no_pk == $val->radinvoicedtl_no_pk)
                            <?php $i += 1; ?>
                        @endif
                    @endforeach
                    <button class="btn btn-sm rounded-circle border-primary border btn-capture open-modal"
                        data-id=""
                        data-action="{{ route('radiology.radiology-image-capture-popupemr', $value->radinvoicedtl_no_pk) }}"
                        data-title="PACS Image" title="PACS Image" data-modal="common-modal-sm">
                        <?php echo $i; ?></button>
                @endif


            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="10" class="text-center">No Data Found</td>
    </tr>
@endif
