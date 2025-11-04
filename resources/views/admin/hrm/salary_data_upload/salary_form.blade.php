<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .upload-signature {
        cursor: pointer;
        color: #595757;
        border: 1px dashed #97dad4;
    }
</style>
<div class="row mb-3">
    <div class="col-md-3 col-12">
        <div class="form-group">
            <label for="month" class="col-form-label">Month<span style="color:red">
                    *</span></label>
            <div class="input-group">
                <select class="form-control font_size_12  " id="month" name="month" width="200px" required>
                    <option value="">Select Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="form-group">
            <label for="year" class="col-form-label">Year<span style="color:red">
                    *</span></label>
            <div class="input-group">
                <select class="form-control font_size_12 m-auto" id="year" name="year" required>
                    <option value="">Select Year</option>
                    @php
                    $date = date('Y');
                    @endphp
                    @for ($i = $date; $i < $date + 7; $i++) <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="form-group">
            <label for="attachment" class="col-form-label">Attachment<span style="color:red">
                    *</span></label>
            <div class="input-group">
                <input type="file" id="attachment" name="attachment" class="upload-signature form-control form-control-sm" style="line-height: 1.0 !important" accept=".xlsx, .xls, .csv" required/>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-12">
        @php
            $response_action = route('hrm.salary-excel-data-upload');
        @endphp
        <div class="text-left mt-4">
            <button class="btn btn-success" onclick="saveUpdateBtn(this)" id="save_button">Save</button>
        </div>
    </div>
</div>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
<script>
    function formatExcelDate(serial) {
    var epoch = Date.UTC(1899, 11, 31); // Excel's epoch starts on 31st Dec 1899
    var ms = serial * 86400000; // Excel's days are 86400000 milliseconds long
    var date = new Date(epoch + ms); // Convert to JavaScript Date object
    var day = String(date.getUTCDate()-1).padStart(2, '0');
    var month = String(date.getUTCMonth() + 1).padStart(2, '0'); // Months are zero-indexed
    var year = date.getUTCFullYear();
    return day + '-' + month + '-' + year;
    
}
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('#load_data').on('click', function() {
            var fileInput = document.getElementById('attachment');
            var file = fileInput.files[0];
            if (!file) {
                alert('Please select a file.');
                return;
            }
            var fileName = file.name;
            var fileExtension = fileName.split('.').pop().toLowerCase();
            if (fileExtension !== 'xls' && fileExtension !== 'xlsx') {
                alert('Please select an Excel file.');
                return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, {
                    type: 'array'
                });
                // Assuming the first sheet is the one you want to parse
                var sheet = workbook.Sheets[workbook.SheetNames[0]];

                // Get the range of the sheet
                var range = XLSX.utils.decode_range(sheet['!ref']);

                var headerRow = [];
                    for (var colNum = range.s.c; colNum <= range.e.c; colNum++) {
                        var address = XLSX.utils.encode_cell({
                            r: range.s.r, // First row (header)
                            c: colNum
                        });
                        var cell = sheet[address];
                        headerRow.push(cell ? cell.v : '');
                    }

                // Convert the sheet data into JSON format
                var recruitmentData = [];
                for (var rowNum = range.s.r; rowNum <= range.e.r; rowNum++) {
                    var row = [];
                    for (var colNum = range.s.c; colNum <= range.e.c; colNum++) {
                        var address = XLSX.utils.encode_cell({
                            r: rowNum,
                            c: colNum
                        });
                        var cell = sheet[address];
                       // var cellValue = cell ? cell.v : ''; // Get cell value or set as null if empty
                       var cellValue = '';
                       if (cell) {
                            if (cell.t === 'n') { // Number type (could also be date or general number)
                                // Check if the value is a valid date by comparing it with the range of Excel dates
                                // if (typeof cell.v === 'number' && cell.v > 0 && cell.v < 2958465) { 
                                //     // Format the date (ensure it's in 'dd-mm-yyyy' format)
                                //     cellValue = formatExcelDate(cell.v);
                                // } else {
                                //     // If it's not a date, just store the number
                                //     cellValue = cell.v;
                                // }
                                if (headerRow[colNum] && headerRow[colNum].toLowerCase() === 'dob') {
                                        // If header is "DOB", treat as a date
                                        cellValue = formatExcelDate(cell.v);
                                    } else {
                                        // Otherwise treat as a regular number
                                        cellValue = cell.v;
                                    }
                            } else if (cell.t === 's') { // String
                                cellValue = cell.v;
                            } else if (cell.t === 'b') { // Boolean
                                cellValue = cell.v ? 'TRUE' : 'FALSE';
                            } else {
                                // For other types (e.g., formula results)
                                cellValue = cell.v || '';
                            }
                        }
                        row.push(cellValue);
                    }
                    recruitmentData.push(row);
                }
                // console.log('recruitmentData', recruitmentData);
                // Display the parsed data in a table
                var tableHtml =
                    '<table border="1" class ="table table-striped table-bordered table-hover">';
                recruitmentData.forEach(function(row, rowIndex) {
                    if (row[0] !== '') {
                        tableHtml += '<tr>';
                        row.forEach(function(cell, cellIndex) {
                            // Use header row to add th for table header
                            if (rowIndex === 0) {
                                tableHtml += '<th class="">' + cell +
                                    '</th>';
                            } else {
                                // Use data rows to add td for table data
                                tableHtml += '<td class="text-center">' + cell + '</td>';
                                // Add hidden input fields with values and names
                                tableHtml +=
                                    '<input type="hidden" name="column' +
                                    cellIndex + '[]" value="' + cell + '">';
                            }
                        });
                        tableHtml += '</tr>';
                    }
                });
                tableHtml += '</table>';
                // Display the table
                $('#recruitment_data_list_id').html(tableHtml);
            };
            reader.onerror = function(event) {
                console.error("File could not be read! Code " + event.target.error.code);
            };
            reader.readAsArrayBuffer(file);

        });
    });

    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    function saveUpdateBtn(thisElement) {
        // alert(thisElement);
        event.preventDefault();
        var tableRowCount = $('#recruitment_data_list_id table tbody tr').length;
        var year = $('#year').val();
        var month = $('#month').val();
        var file = $("#attachment")[0].files[0];
        if (month === '') {
            alert('Please Select Month !!');
            return false;
        } else if (year === '') {
            alert('Please Select Year !!');
            return false;
        } else if (!file) {
            alert("Please select an Excel file !!");
            return;
        } else {
            // btnSaveUpdateUpload(thisElement, '', '', '', '', dynamicFunc.afterSaveLoadPage,
            //     '{{ $response_action }}')
            var reader = new FileReader();
                reader.readAsBinaryString(file);
                reader.onload = function(e) {
                    var data = e.target.result;
                    var workbook = XLSX.read(data, { type: "binary" });
                    var firstSheet = workbook.SheetNames[0];
                    var sheetData = XLSX.utils.sheet_to_json(workbook.Sheets[firstSheet]);
                    $.ajax({
                        url: "{{ route('hrm.salary-info-save') }}",
                        type: "POST",
                        data: { 
                            excelData: sheetData,
                            month: month,
                            year : year
                        },
                        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        success: function(data) {
                            if (data.title == "Success") {
                                $(".common-modal-notify").modal("show");
                                $(".common-modal-notify .modal-body").html(
                                    "<i class='fas fa-stroopwafel fa-spin'></i>"
                                );
                                $(".common-modal-notify .modal-title").html(data.title);
                                $(".common-modal-notify .modal-body").html(data.msg);
                            } else {
                                $(".common-modal-notify-error").modal("show");
                                $(".common-modal-notify-error .modal-title").html(
                                    data.title
                                );
                                $(".common-modal-notify-error .modal-body").html(
                                    data.msg
                                );
                            }
                        },
                        error: function(xhr) {
                            alert("Upload failed!");
                        }
                    });
                }
        }
    }
</script>