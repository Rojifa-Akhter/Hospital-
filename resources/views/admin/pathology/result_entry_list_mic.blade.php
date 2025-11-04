<table class="table table-bordered table-hover table-striped m-0 mt-2">
    <thead class="global-uhl-table-bg">
        <tr>
            <th>SL#</th>
            <th>Invoice Date</th>
            <th>Invoice No </th>
            <th>LAB No</th>
            <th>LAB ID</th>
            <th>Admission Id</th>
            <th>Sample Coll. Date</th>
            <th>Exam Name</th>
            <th>Specimen</th>
            <th>Container</th>
            <th>Analyzer</th>
            <th>Status</th>
            <th>Result</th>
        </tr>
    </thead>
    <tbody>

        @if (!empty($invoice_item_arr))

            @foreach ($invoice_item_arr as $row)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                    <td>{{ $row->invoice_code }}</td>
                    <td>{{ $row->lab_no_pk }}</td>
                    <td>{{ $row->lab_code }}</td>
                    {{-- {{ $row->admission_no_pk }} --}}
                    <td> {{ $row->admission_no_pk }} </td>
                    <td>{{ date('d/m/Y', strtotime($row->sc_sample_coll_keyed_time)) }}</td>
                    <td>{{ $row->item_name }}</td>
                    <td>{{ $row->sam_name }}</td>
                    <td>{{ $row->container_name }}</td>
                    @if ($row->lab_result_prepared_key_ind == 1)
                        <td class="text-center"><span class="badge badge-success">Auto</span></td>
                    @else
                        <td class="text-center"><span class="badge badge-danger">Manual</span></td>
                    @endif



                    @if ($row->lab_result_final_key_ind == 1)
                        <td>Finalized</td>
                    @elseif($row->lab_result_verify_key_ind == 1)
                        <td>Verified</td>
                    @else
                        @if ($row->lab_result_prepared_key_ind == 1)
                            <td>Prepared</td>
                        @else
                            <td></td>
                        @endif
                    @endif

                    <td>

                        @if ($row->lab_result_final_key_ind == 1)
                            {{-- @if ($row->report_url == 'result-entry-form-column2') --}}
                            @if ($row->form_url)
                                @if ($row->form_url == 'result-entry-form-column2')
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                        target="_blank" rel="noopener noreferrer">Result</a>
                                @elseif($row->form_url == 'result-entry-form')
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                        target="_blank" rel="noopener noreferrer">Result</a>
                                @elseif($row->form_url == 'microbiology.result-entry-form')
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                        target="_blank" rel="noopener noreferrer">Result</a>
                                @elseif($row->report_url == 'path.bc-report-pdf-mic')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank"
                                        rel="noopener noreferrer">Print</a>
                                @elseif($row->form_url == 'cr.result-entry-form')
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                        target="_blank" rel="noopener noreferrer">Result</a>
                                @elseif($row->form_url == 'gram-stain-form')
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                        target="_blank" rel="noopener noreferrer">Result</a>
                                @elseif($row->form_url == 'result-entry-afb')
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                        target="_blank" rel="noopener noreferrer">Result</a>
                                @elseif($row->form_url == 'result-entry-csf')
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                        target="_blank" rel="noopener noreferrer">Result</a>
                                @elseif($row->form_url == 'result-entry-form-elisa')
                                    <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                        target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                @elseif($row->form_url == 'histopathology.result-entry-form')
                                    <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                        target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                @endif
                            @endif


                            @if ($row->report_url)
                                @if ($row->report_url == 'path.bc-report-pdf')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.bc-report-pdf-column-2')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.bc-special-pdf-column-2')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.bc-special-pdf-cbc')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.bc-report-pdf-mic')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.bc-report-pdf-cr')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.gram-stain-pdf')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.afb-report')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.csf-report')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.bc-report-pdf-elisa')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.bc-report-pdf-column-2-pbf')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'path.bc-report-stool-pdf-column-2')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @elseif($row->report_url == 'histopathology.bc-report-pdf-mic')
                                    <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                        class="btn btn-sm btn-warning" target="_blank">Print</a>
                                @endif
                            @endif
                        @else
                            @if ($row->lab_result_prepared_key_ind == 1)
                                @if ($row->form_url)
                                    @if ($row->form_url == 'result-entry-form-column2')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'microbiology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'cr.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'gram-stain-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-afb')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-csf')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form-elisa')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'histopathology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @endif
                                @endif
                                <a href="{{ route('path.bc-report-pdf', $row->report_no_fk) }}"
                                    class="btn btn-sm btn-warning disabled" target="_blank">Print</a>


                                <a href="{{ route('path.bc-draft-print-report-pdf', $row->report_no_fk) }}"
                                    class="btn btn-sm btn-success" target="_blank">Draft Print</a>
                            @elseif($row->lab_result_prepared_key_ind != 1)
                                @if ($row->form_url)
                                    @if ($row->form_url == 'result-entry-form-column2')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'microbiology.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'cr.result-entry-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'gram-stain-form')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-afb')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-csf')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @elseif($row->form_url == 'result-entry-form-elisa')
                                        <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                            target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                            @elseif($row->form_url == 'histopathology.result-entry-form')
                                            <a href="{{ route($row->form_url, [$row->report_no_fk, $type, $row->lab_code]) }}"
                                                target="_blank" class="btn btn-sm btn-info text-white">Result</a>
                                    @endif
                                @endif

                                <a href="{{ route('path.bc-report-pdf', $row->report_no_fk) }}"
                                    class="btn btn-sm btn-warning disabled" target="_blank">Print</a>
                            @elseif($row->report_url == 'path.bc-report-pdf-cr')
                                <a href="{{ route($row->report_url, $row->report_no_fk) }}"
                                    class="btn btn-sm btn-warning" target="_blank">Print</a>
                            @else
                            @endif
                        @endif
                    </td>



                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11" class="text-danger">No Data Found</td>
            </tr>
        @endif
    </tbody>
