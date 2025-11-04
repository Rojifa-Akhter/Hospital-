{{--<div class="form-row">--}}
{{--    <div class="col-12 table-responsive" >--}}
{{--        <table class="table table-striped table-bordered table-hover mb-0">--}}
{{--            <thead class="bg-primary">--}}
{{--                <tr>--}}
{{--                    <th class="text-center w-5">SL#</th>--}}
{{--                    <th class="text-center">Date</th>--}}
{{--                    <th class="text-center">Activity Name</th>--}}
{{--                   <!--  <th class="text-center">Age</th>--}}
{{--                    <th class="text-center">Gender</th> -->--}}
{{--                    <th class="text-center">Pathology</th>--}}
{{--                    <th class="text-center">Radiology</th>--}}
{{--                    <th class="text-center">Doctor App.</th>--}}
{{--                    <th class="text-center">Vitals</th>--}}
{{--                    <th class="text-center">Overall Status</th>--}}
{{--                    <th class="text-center"> Hospital</th>--}}
{{--                    <th class="text-center w-10">Form</th>--}}
{{--                    <th class="text-center w-10">Approval</th>--}}
{{--                </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--                @if(!empty($pat_med_activities_wl))--}}
{{--                @foreach($pat_med_activities_wl as $pat_activity)--}}
{{--                <tr>--}}
{{--                    <td class="text-center">{{ $loop->iteration }}</td>--}}
{{--                    <td class="text-left">{{ !empty($pat_activity->au_entry_at)? date('d/m/Y', strtotime($pat_activity->au_entry_at)): '' }}</td>--}}
{{--                    <td class="text-left">{{ !empty($pat_activity->activity_name)? $pat_activity->activity_name: '' }}</td>--}}

{{--                    <!-- <td class="text-left">{{ !empty($pat_activity->age)? $pat_activity->age: '' }}</td> -->--}}
{{--                    <!-- <td class="text-left">{{ !empty($pat_activity->gender_txt)? $pat_activity->gender_txt: '' }}</td> -->--}}
{{--                    <td class="text-left">{{ !empty($pat_activity->pathology_cnt)? $pat_activity->pathology_cnt: 0 }}</td>--}}
{{--                    <td class="text-left">{{ !empty($pat_activity->radiology_cnt)? $pat_activity->radiology_cnt: 0 }}</td>--}}
{{--                    <td class="text-left">{{ !empty($pat_activity->appoint_cnt)? $pat_activity->appoint_cnt: 0 }}</td>--}}
{{--                    <td class="text-left">{{ !empty($pat_activity->vitals_cnt)? $pat_activity->vitals_cnt: 0 }}</td>--}}
{{--                    <td class="text-left">{{ !empty($pat_activity->overall_status)? $pat_activity->overall_status: '' }}</td>--}}
{{--                    <td class="text-left">{{ $pat_activity->hospital_name}}</td>--}}
{{--                    <td class="text-center ">--}}
{{--                        @if(!empty($pat_activity->final_form))--}}
{{--                        <span class="d-block">--}}
{{--                            <a href="{{url($pat_activity->final_form_url)}}" class="btn-sm" target="_blank" title="Final Form">{{$pat_activity->final_form}}</a>--}}
{{--                            <a href="#" class="btn btn-warning btn-sm open-modal" title="Print"><i class="fa fa-print"></i></a>--}}
{{--                        </span>--}}
{{--                        @endif--}}
{{--                        @if(!empty($pat_activity->final_report))--}}
{{--                        <span class="d-block">--}}
{{--                            <a href="{{url($pat_activity->final_report_url)}}" class="btn-sm" target="_blank" title="Final Report">{{$pat_activity->final_report}}</a>--}}
{{--                            <a href="#" class="btn btn-warning btn-sm open-modal" title="Print"><i class="fa fa-print"></i></a>--}}
{{--                        </span>--}}
{{--                        @endif--}}
{{--                        @if(!empty($pat_activity->certificate_name))--}}
{{--                        <span class="d-block">--}}
{{--                            <a href="{{url($pat_activity->certificate_url)}}" class="btn-sm" target="_blank" title="Certificate Name">{{$pat_activity->certificate_name}}</a>--}}
{{--                            <a href="{{ route('cmb.medical-certificate-print-pdf') }}" class="btn btn-warning btn-sm open-modal" title="Print"><i class="fa fa-print"></i></a>--}}
{{--                        </span>--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                    <td class="text-left">--}}
{{--                     <span class="d-sm-block p-0 bg-white border-bottom">DMS--}}
{{--                      @if($pat_activity->dms_ind==1) <span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>--}}
{{--                      @elseif($pat_activity->dms_ind==2)<span class="badge badge-danger btn-danger"><i class="fa fa-times"></i></span>--}}
{{--                      @endif--}}
{{--                  </span>--}}
{{--                  <span class="d-sm-block p-0 bg-white border-bottom">OC CMB--}}
{{--                      @if($pat_activity->occmb_ind==1) <span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>--}}
{{--                      @elseif($pat_activity->occmb_ind==2)<span class="badge badge-danger btn-danger"><i class="fa fa-times"></i></span>--}}
{{--                      @endif--}}
{{--                  </span>--}}
{{--                  <span class="d-sm-block p-0 bg-white border-bottom">SMO--}}
{{--                      @if($pat_activity->smo_ind==1) <span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>--}}
{{--                      @elseif($pat_activity->smo_ind==2)<span class="badge badge-danger btn-danger"><i class="fa fa-times"></i></span>--}}
{{--                      @endif--}}
{{--                  </span>--}}
{{--                  <span class="d-sm-block p-0 bg-white border-bottom">FLIGHT SUR--}}
{{--                      @if($pat_activity->flightsur_ind==1)<span class="badge badge-success btn-success"><i class="fa fa-check"></i></span>--}}
{{--                      @elseif($pat_activity->flightsur_ind==2)<span class="badge badge-danger btn-danger"><i class="fa fa-times"></i></span>--}}
{{--                      @endif--}}
{{--                  </span>--}}
{{--              </td>--}}

{{--          </tr>--}}
{{--          @endforeach--}}

{{--          @else--}}

{{--          <tr>--}}
{{--            <td colspan="12" class="text-center">No Data Found</td>--}}
{{--        </tr>--}}
{{--        @endif--}}
{{--    </tbody>--}}
{{--</table>--}}
{{--</div>--}}
{{--</div>--}}
