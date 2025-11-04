@if (!empty($data))
@foreach ($data as $datas)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td class="text-left">{{ $datas->features_name }}</td>
        <td class="text-center">{{ $datas->header_sl }}</td>
        <td class="text-center">{{ $datas->header_title }}</td>
        <td class="text-center">
            <span Class="btn btn-sm open-modal" style="background-color: #0e9219" title="View Description"
            data-modal="common-modal-xl" data-title="Description"
            data-action="{{ route('view-user-manual-description', $datas->userm_mst_no_pk) }}"><i
            class="fa fa-eye text-white"></i></span>

            <span>
                <a class="btn btn-sm btn-info nav-link active" id="manualID"
                onclick="fetchData({{ $datas->userm_mst_no_pk }})"><i class="fas fa-edit"></i></a> 
            </span>
            <span class="btn btn-sm btn-danger"
            onclick="deleteUserManual({{ $datas->userm_mst_no_pk }})"><i class="fas fa-trash"></i></span>
        </td>
    </tr>
@endforeach
@endif