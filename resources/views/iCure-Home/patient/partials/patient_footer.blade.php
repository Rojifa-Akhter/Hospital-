@php
$hospital_code = strtoupper(Session::get('user.ses_hospital_code'));
@endphp
<footer class="footer">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            @if ($hospital_code == 'CHPC')
                <div class="col-md-12 col-sm-12 text-center">Copyright © {{ date('Y') }} <a href="#">
                        Sarina</a> All rights reserved. Designe & Developed by <a href="#">NEXTGEN INNOVATION LTD.</a>
                </div>
            @else
                <div class="col-md-12 col-sm-12 text-center">Copyright © {{ date('Y') }} <a href="#">
                        Mcare</a> All rights reserved. Designe & Developed by <a href="#">NEXTGEN INNOVATION LTD.</a>
                </div>
            @endif
        </div>
    </div>
</footer>
