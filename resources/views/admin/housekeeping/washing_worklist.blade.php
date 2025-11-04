<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #004b7b;
        clip-path: polygon(93% 0, 100% 50%, 93% 100%, 0 100%, 0 0);
    }


    .detail-info-tab .nav-tabs {
        border-bottom: 0px;
    }

    .detail-info-tab .nav-tabs .nav-link.active {
        clip-path: inherit;
        background-color: transparent !important;
        color: #003b61;
        border-bottom: 2px solid #003b61;
        text-align: center;
        padding: 0px 10px;
        transition: all 0.3s;
    }

    .detail-info-tab .nav-tabs .nav-link {
        clip-path: inherit;
        color: #3490dc;
        background-color: transparent !important;
        border-bottom: 2px solid #5eb8e245;
        text-align: center;
        padding: 0px 10px;
        transition: all 0.3s;
        position: relative;
    }

    .detail-info-tab .nav-tabs .nav-link.active::before {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        height: 5px;
        width: 15px;
        background-color: #003b61;
        clip-path: polygon(50% 100%, 0 0, 100% 0);
    }

       .list-group-item {
        padding: 0.2rem 0.8rem !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

</style>


<div class="container-fluid">
    <div class="row align-items-center bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Washing work List</h5>
            <small>Housekeeping / Washing work List</small>
        </div>
    </div>
    <div class="form-row">
            @include('admin.housekeeping.washing_worklist_tabs')
    </div>
</div>

