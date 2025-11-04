<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\LookupData;
use App\Library\Template;
use DB;
use Session;
use Auth;
use App\Models\TeamBuild;
use App\Repositories\BaseRepository;
class TeamBuildController extends Controller
{

    use LookupData;
    private $model;
    public function __construct(TeamBuild $model)
    {
        $this->middleware('auth');
        $this->model = new BaseRepository($model);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $teams = DB::table('hrms_sales_team')->select('team_no_pk', 'team_name')->get();
      $unique_team = [];
      foreach($teams as $team)
      {
        $members = DB::table('hrms_team_build')
        ->where('team_no_fk', $team->team_no_pk)
        ->count();
        $data = [];
        $data = [
            'team_no_pk' =>$team->team_no_pk,
            'no_of_members' => $members
        ];
        $unique_team[$team->team_name] = $data;
    }
      //dd($unique_team);
    return Template::loadview("admin.sales.team_build_list", compact('unique_team'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee' => 'required',
            'area' => 'required'
        ]);
        try{
            $sequence = DB::getSequence();
            $team_build_no_pk_seq = $sequence->nextValue('team_build_no_pk_seq');
            $team_build_info = [];
            $team_build_info = [

                'team_build_no_pk' => $team_build_no_pk_seq,
                'team_no_fk' => $request->team,
                'employee_no_fk' => $request->employee,
                'area_no_fk' => $request->area,
                'status' => $request->status,
                //'delivery_assigned' => date('Y-m-d'),
                //'delivery_date' => date('Y-m-d', strtotime($request->date_pic)),
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
                'au_entry_by'=> Auth::id()
            ];
            $this->model->insert($team_build_info);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        }
        catch (\Exception $e)
        {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member_details = DB::table('hrms_sales_team_vw')
        ->where('team_no_pk', $id)
        ->select('full_name')
        ->get();
        return Template::loadview("admin.sales.member_details",[
            'member_details'  => $member_details
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team_id = $id;
        $employees = DB::table('employee_info_vw')->select('person_no_pk', 'full_name')->get();
        $areas = $this->getLookupListByCode('AREA');
        return Template::loadview("admin.sales.create_team_build_form", compact('areas','team_id','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function memberList()
    {
        $teams = DB::table('hrms_sales_team')->select('team_no_pk', 'team_name')->get();
        $unique_team = [];
        foreach($teams as $team)
        {
          $members = DB::table('hrms_team_build')
          ->where('team_no_fk', $team->team_no_pk)
          ->count();
          $data = [];
          $data = [
              'team_no_pk' =>$team->team_no_pk,
              'no_of_members' => $members
          ];
          $unique_team[$team->team_name] = $data;
      }
        //dd($unique_team);
    //  return Template::loadview("admin.sales.team_build_list", compact('unique_team'));
       return Template::loadview("admin.sales.member_list",compact('unique_team'));

    }
    public function membersByTeam()
    {
        $member_details = DB::select("select * from hrms_sales_team_vw group by team_no_pk,team_name,employee_no_fk,full_name,area_no_fk");
        //dd($member_details);
        $team_members = [];
        foreach($member_details as $member)
        {
          $team_members [$member->team_name][]=$member->full_name;
        }
       return Template::loadview("admin.sales.members_by_team",compact('team_members'));
    }
}
