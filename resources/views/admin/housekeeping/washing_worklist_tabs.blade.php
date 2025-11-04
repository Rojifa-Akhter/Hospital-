<div class="col-md-12 mt-2">
    <ul class="nav nav-tabs" id="myTab" role="tablist">

        <li class="nav-item " role="presentation">
            <a class="nav-link cursor-pointer active" href="#hkpending" id="pending-tab" data-toggle="tab" role="tab"
                aria-controls="hkpending" onclick="housekeepingTabData(this)" data-tab-type="1"
                data-action="{{ route('housekeeping.washed-worklist') }}" aria-selected="true">Pending</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link cursor-pointer" href="#hkreceived" id="received-tab" data-toggle="tab"
                aria-controls="hkreceived" onclick="housekeepingTabData(this)" data-tab-type="2"
                data-action="{{ route('housekeeping.washed-worklist') }}" aria-selected="false">Received</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link cursor-pointer" href="#hkreports" id="reports-tab" data-toggle="tab"
                aria-controls="hkreports" aria-selected="false">Housekeeping Reports</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="hkpending" role="tabpanel" aria-labelledby="pending-tab">
            @include('admin.housekeeping.unwashed_worklist')
        </div>

        <div class="tab-pane fade" id="hkreceived" role="tabpanel" aria-labelledby="received-tab">
            @include('admin.housekeeping.washed_worklist')
        </div>
        <div class="tab-pane fade" id="hkreports" role="tabpanel" aria-labelledby="reports-tab">
            @include('admin.housekeeping.housekeeping_report')

        </div>
    </div>
</div>



<script type="text/javascript">
    function housekeepingTabData(thisElement) {
        var action = $(thisElement).attr("data-action");
        var tab_type = $(thisElement).attr("data-tab-type");
        $.ajax({
            data: {
                tab_type: tab_type
            },
            url: action,
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $(thisElement).parents("#myTab").siblings("#myTabContent").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
</script>
