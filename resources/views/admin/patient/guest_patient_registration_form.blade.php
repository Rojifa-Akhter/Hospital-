<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="form-group row">
    <label for="patient_name" class="col-sm-2 col-form-label col-form-label-sm">Patient Name <span class="text-danger">*</span></label>
    <div class="col-sm-10">
        <div class="input-group">
            <div class="input-group-prepend">
                <select class="form-control font_size_12 m-auto" id="pat_salutation" name="pat_salutation" style="width:100px;">
                    <option value="MR.">MR.</option>
                    <option value="MRS.">MRS.</option>
                </select>
            </div>
            <input type="text" class="form-control form-control-sm" id="pat_f_name" name="pat_f_name" value="" placeholder="First Name" required>
            <input type="text" class="form-control form-control-sm" id="pat_l_name" name="pat_l_name" value="" placeholder="Last Name" >
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="mobile_no" class="col-sm-2 col-form-label col-form-label-sm">Phone <span class="text-danger">*</span></label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm number_only" id="mobile_no" name="phone_no" value="" minlength="10" maxlength="15" placeholder="Enter Phone Number" required>
    </div>
    <label for="pat_gender" class="col-sm-2 col-form-label col-form-label-sm">Gender <span class="text-danger">*</span></label>
    <div class="col-sm-4">
        <select class="form-control font_size_12 m-auto" id="pat_gender" name="pat_gender" required>
            <option value="0">Select Gender</option>
            @if(isset($gender))
                @foreach($gender as $key => $value )
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="patient_age_dd" class="col-sm-2 col-form-label col-form-label-sm">Patient Age</label>
    <div class="col-sm-4">
        <div class="input-group">
            <div class="input-group-prepend w-100">
                <input type="number" class="form-control form-control-sm" id="pat_age_y" onkeyup="get_dob_by_age()"   name="pat_age_y" value="" placeholder="YY" style="width: 35%;">
                <input type="number" class="form-control form-control-sm" id="pat_age_m" onkeyup="get_dob_by_age()"   name="pat_age_m" value="" placeholder="MM" style="width: 33%;"  max="12">
                <input type="number" class="form-control form-control-sm" id="pat_age_d" onkeyup="get_dob_by_age()"   name="pat_age_d" value="" placeholder="DD" style="width: 32%;" max="31">
            </div>
        </div>
    </div>
    <label for="pat_dob" class="col-sm-2 col-form-label col-form-label-sm" >DOB</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm date_picker" id="patient_dob" name="pat_dob" value="" placeholder="Patient DOB" onclick="datepic(this)"   onchange="dob(this)">
    </div>
    <label for="pat_marital_status" class="col-sm-2 col-form-label col-form-label-sm" title="Marital Status">M. Status</label>
    <div class="col-sm-4">
        <select class="form-control font_size_12 m-auto" id="pat_marital_status" name="pat_marital_status">
            <option value="0">Select Marital Status</option>
            @if(isset($marital_status))
                @foreach($marital_status as $key => $value )
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            @endif

        </select>
    </div>
    <label for="pat_blood_group" class="col-sm-2 col-form-label col-form-label-sm">Blood Group</label>
    <div class="col-sm-4">
        <select class="form-control font_size_12 m-auto" id="pat_blood_group" name="pat_blood_group">
            <option value="0">Select Blood Group</option>
            @if(isset($bloodg))
                @foreach($bloodg as $key => $value )
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            @endif
        </select>
    </div>

</div>

<div class="form-group row">
    <label for="pat_email" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
    <div class="col-sm-4">
        <input type="email" class="form-control form-control-sm" maxlength="50" id="pat_email" name="pat_email" value="" placeholder="Enter Patient Emal ID">
    </div>
    <label for="pat_address" class="col-sm-2 col-form-label col-form-label-sm">Address</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm" id="pat_address" maxlength="100" name="pat_address" value="" placeholder="Enter Patient Address">
    </div>
</div>


<div class="form-group row">
    <label for="password" class="col-sm-2 col-form-label col-form-label-sm">Password</label>
    <div class="col-sm-4">
        <input type="password" class="form-control form-control-sm" maxlength="50" id="password" name="password" value="" placeholder="Enter Password" autocomplete="off">
    </div>
    <label for="expire_date" class="col-sm-2 col-form-label col-form-label-sm">Expire Date</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm date-picker" id="expire_date" maxlength="100" name="expire_date" value="" placeholder="Enter Expire Date" autocomplete="off">
    </div>

    {{--    <label for="c_password" class="col-sm-2 col-form-label col-form-label-sm">Confirm Password</label>--}}
{{--    <div class="col-sm-4">--}}
{{--        <input type="password" class="form-control form-control-sm" id="c_password" maxlength="100" name="c_password" value="" placeholder="Confirm Password" autocomplete="off">--}}
{{--    </div>--}}
</div>

<div class="form-group row">

    <label for="guest_ind" class="col-sm-2 col-form-label col-form-label-sm">Status</label>
    <div class="col-sm-4">
        <div class="form-check form-check-inline">
            {{--                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" >--}}
            <input class="form-check-input" type="checkbox" name="guest_ind" id="guest_ind" value="1" >
            <label class="form-check-label" for="status">Active</label>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    function get_dob_by_agee()
    {
        // var pat_age_y = $('#pat_age_y').val();
        // var pat_age_m = $('#pat_age_m').val();
        // var pat_age_d = $('#pat_age_d').val();

        // var cur_date = new Date();
        // var cur_y = cur_date.getFullYear();

        //     var dob = pat_age_d + "-" +  (pat_age_m  )+ "-" + (cur_y - pat_age_y);
        //     var dob_year = cur_y - pat_age_y;
        //     if((pat_age_m.length && pat_age_d.length) > 0){
        //         $("#patient_dob").val(dob);
        //     }else{
        //         $("#patient_dob").val(dob_year);
        //     }

        //     $('.date_picker').datepicker({
        //         format: 'dd-mm-yyyy',
        //         autoclose: true,
        //         todayHighlight: true,
        //         clearBtn: true,
        //     });
    }
    // $('.date_picker').datepicker({
    //     format: 'dd-mm-yyyy',
    //     autoclose: true,
    //     todayHighlight: true,
    //     clearBtn: true,
    // });


    function get_dob_by_age()
    {
        var pat_age_y = $('#pat_age_y').val();
        var pat_age_m = $('#pat_age_m').val();
        var pat_age_d = $('#pat_age_d').val();

        var today = new Date();
        // var birthDate = new Date(dateString);
        var age = today.getFullYear() - pat_age_y;
        var m = today.getMonth() - pat_age_m;
        var d = today.getDate() - pat_age_d;
        var month =0;
        var date =0;



        if ( today.getDate() < pat_age_d) {
            var pre_month = (today.getMonth() -1);
            var add_days=0;
            if (pre_month == 1) {
                add_days = 31;
            }else if(pre_month == 2){
                add_days = 28;
            }else if(pre_month == 3){
                add_days = 31;
            }else if(pre_month == 4){
                add_days = 30;
            }else if(pre_month == 5){
                add_days = 31;
            }else if(pre_month == 6){
                add_days = 30;
            }else if(pre_month == 7){
                add_days = 31;
            }else if(pre_month == 8){
                add_days = 31;
            }else if(pre_month == 9){
                add_days = 30;
            }else if(pre_month == 10){
                add_days = 31;
            }else if(pre_month == 11){
                add_days = 30;
            }else if(pre_month == 12){
                add_days = 30;
            }


            date= (today.getDate() + add_days) - pat_age_d;
        }else{
            var dates= today.getDate() - pat_age_d;
            if (dates ==0 ) {
                date= (today.getDate() - pat_age_d)+1;
            }else{
                date= (today.getDate() - pat_age_d);
            }

        }

        if ( (today.getMonth() ) < pat_age_m) {

            months= (today.getMonth() + 12) - pat_age_m;
            if ((today.getDate() - pat_age_d) == 0) {
                month= (today.getMonth() + 12) - (pat_age_m);
                if (month ==0) {
                    month+=1;
                }
            }else{
                month= (today.getMonth() + 12) - pat_age_m;
                if (month ==0) {
                    month+=1;
                }
            }
        }else{

            // month= today.getMonth() - pat_age_m;
            if ((today.getDate() - pat_age_d) == 0) {
                month= (today.getMonth()) - (pat_age_m);
                if (month ==0) {
                    month+=1;
                }
            }else{
                month= (today.getMonth())  - pat_age_m;
                if (month ==0) {
                    month+=1;
                }
            }
        }
// alert(today.getMonth()-1);

        if (m < 0 || (m === 0 && today.getDate() < pat_age_d))
        {
            age--;


        }

        if((pat_age_m.length && pat_age_d.length) > 0){

            $("#patient_dob").val(('0' + date).slice(-2)+"-"+('0' + month).slice(-2)+"-"+age);

        }else{
            $("#patient_dob").val(age);
        }


    }

    $(function() {
        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            clearBtn: true,
            autoclose: true,
            startDate: '+0d'
        });
    });

    function datepic(element){

        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            // todayHighlight: true,
            clearBtn: true,


        });

    }
    function dob(element){

        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            // todayHighlight: true,
            clearBtn: true,

        });
        var dateString =$(element).val();
        // $(element).val();

        var dob = dateString.split("-");

        var now = new Date();
        var today = new Date(now.getYear(),now.getMonth(),now.getDate());

        var yearNow = now.getFullYear();
        var monthNow = now.getMonth();
        var dateNow = now.getDate();

        var yearDob = dob[2];
        var monthDob = dob[1];
        var dateDob = dob[0];
        var age = {};
        var ageString = "";
        var yearString = "";
        var monthString = "";
        var dayString = "";

        yearAge = yearNow - yearDob;

        if ((parseFloat(monthNow) ) >= monthDob)
            var monthAge = (parseFloat(monthNow) ) - monthDob;
        else {
            yearAge--;
            var monthAge = (12 + parseFloat(monthNow)) - monthDob;

        }

        if (dateNow >= dateDob)
            var dateAge = dateNow - dateDob;
        else {
            // monthAge--;
            var pre_month = (monthNow - 1);
            var add_days=0;
            if (pre_month == 1) {
                add_days = 31;
            }else if(pre_month == 2){
                add_days = 28;
            }else if(pre_month == 3){
                add_days = 31;
            }else if(pre_month == 4){
                add_days = 30;
            }else if(pre_month == 5){
                add_days = 31;
            }else if(pre_month == 6){
                add_days = 30;
            }else if(pre_month == 7){
                add_days = 31;
            }else if(pre_month == 8){
                add_days = 31;
            }else if(pre_month == 9){
                add_days = 30;
            }else if(pre_month == 10){
                add_days = 31;
            }else if(pre_month == 11){
                add_days = 30;
            }else if(pre_month == 12){
                add_days = 30;
            }
            var dateAge = (parseFloat(add_days) + parseFloat(dateNow)) - dateDob;

        }

        age = {
            years: yearAge,
            months: monthAge,
            days: dateAge
        };

        var m = now.getMonth() - monthDob;
        if (m < 0 || (m === 0 && today.getDate() < dateDob))
        {
            yearAge--;

        }
        if ( (age.years >= 0) && (age.months >= 0) && (age.days >= 0) )
            ageString = age.years + "-"+ age.months + "-" + age.days;


        var pieces = ageString.split("-");
        $("#pat_age_y").val(pieces[0]);
        $("#pat_age_m").val(pieces[1]);
        $("#pat_age_d").val(pieces[2]);

    }

</script>
