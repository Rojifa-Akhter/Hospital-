
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link" id="home-tab" data-toggle="tab"
                href="#favourite_medication" role="tab" aria-controls="home"
                aria-selected="true" onclick="prescriptionV2.loadToPresFavouritListV2(this,'MED','Medicine','#data-append-to', '{{ $action_url }}','#pres-favourit-list-med')">
                Favourite &nbsp;
            </a>
            <a class="nav-link active" id="home-tab" data-toggle="tab"
                href="#only_medication" role="tab" aria-controls="home"
                aria-selected="true">
                Medichine &nbsp;
            </a>
        </div>
      </nav>
    <div class="tab-content p-0 ml-2 mr-2 mt-0" id="nav-tabContent" style="min-height: 540px;">

        <div class="tab-pane fade" id="favourite_medication" role="tabpanel"
            aria-labelledby="absent-tab">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 mt-3">
                        <div class="card mt-0 bg-none">
                            <div class="card-header">
                                <span id="favourit_list_title" data-append-to="">Favourite List</span>
                                <span class="loading-img"></span>
                            </div>
                            <div class="card-body" style="max-height: 300px; overflow:scroll;">
                                <div class="form-group mt-2">
                                    <input type="search" class="form-control form-control-sm " id="favListSearch"
                                        name="" onkeyup="favoriteListSearch(this)" searcAttrvalue=''
                                        placeholder="Search Favourite Item">
                                </div>
                                <table class="table m-0">
                                    <tbody id="pres-favourit-list-med" class="pres-favourit-list" style="word-break: break-all;">
                                        @include('admin.prescription.uhl.pres_favourit_list')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane show active fade" id="only_medication" role="tabpanel"
            aria-labelledby="absent-tab">
            <div class="col-md-12 col-lg-12 col-sm-12 p-0 border-left shadow-sm">
                <div class="my-0 border-0">
                    @if (!empty($su_info) && $su_info->eye_ind == 1)
                        @include('admin.prescription.uhl.prescription_eye')
                    @elseif(!empty($su_info) && $su_info->dental_ind == 1)
                        @include('admin.prescription.uhl.prescription_dental')
                    @else
                            @include('admin.prescription.uhl.prescription_general')
                    @endif
                </div>
            </div>
        </div>
    </div>

    