<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div id="referral_policy_form" style="width:100% !important;">
    @include('admin.pcrm.referral.referral_policy_popup')

</div>

<div id="policy-details" style="width:100% !important;">
    @include('admin.pcrm.referral.referral_policy_data')
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    // doc_ref
    $(function() {
        enable_doc_ref();
        $("#doc_ref").click(enable_doc_ref);
    });

    function enable_doc_ref() {
        if (this.checked) {
            $("input.doc_ref").removeAttr("disabled");
        } else {
            $("input.doc_ref").attr("disabled", true);
        }
    }
    // doc_ref
    $(function() {
        enable_agent_ref();
        $("#agent_ref").click(enable_agent_ref);
    });

    function enable_agent_ref() {
        if (this.checked) {
            $("input.agent_ref").removeAttr("disabled");
        } else {
            $("input.agent_ref").attr("disabled", true);
        }
    }
    // doc_ref
    $(function() {
        enable_sec_ref();
        $("#sec_ref").click(enable_sec_ref);
    });

    function enable_sec_ref() {
        if (this.checked) {
            $("input.sec_ref").removeAttr("disabled");
        } else {
            $("input.sec_ref").attr("disabled", true);
        }
    }
    // doc_ref
    $(function() {
        active_ref();
        $("#active_ref").click(active_ref);
    });

    function active_ref() {
        if (this.checked) {
            $("input.active_ref").removeAttr("disabled");
        } else {
            $("input.active_ref").attr("disabled", true);
        }
    }
</script>
