<link href="http://localhost/h360/public/node_modules/datatables/media/css/jquery.dataTables.css" rel="stylesheet">
<section id="full_doctor_list">
<div class="container-fluid">
<table class="table data-table table-striped table-bordered table-hover datatable">
    <thead class="global-uhl-table-bg ">
        <tr>
            <th class="text-center width-50">SL</th>
            <th class="text-left">Header</th>
            <th class="text-left ">Terms & Condition</th>
            <th class="text-center width-50">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($terms))
            @foreach ($terms as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left ">
                        {{ $item->termscon_header }}
                     
                    </td>
                    <td class="text-left">
                        {{ $item->termscon_text1 ? $item->termscon_text1 : 0 }}
                       
                    </td>                    
                    <td class="text-center">
                        <input data-iteration="{{ $loop->iteration }}" class="selected-terms"
                            name="item_no_pk[]" value="{{ $item->termscon_header .'*'. $item->termscon_text1.'*'. $item->header_sl}}" type="checkbox">
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right">  <button class="btn btn-info" onclick="set_terms(this)" data-dismiss="modal">Set</button> </td>
        </tr>
    </tfoot>
</table>
</div>
</section>
<script type="application/javascript" src="http://localhost/h360/public/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
  <script>
  $('.datatable').DataTable({
        "ordering": false,
        "pageLength": 20

  });
  
  </script>
