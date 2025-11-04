<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Models\Users;
use App\Http\Controllers\Controller;
use App\Library\Template;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use App\Repositories\BaseRepository as Repo;
use App\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use DB;
use Session;

class UserController extends Controller
{
    use DatatablesLoader;
    protected $model;
    protected $userRepository;

    /**
     * PostController constructor.
     *
     * @param PostRepositoryInterface $user
     */
    public function __construct(Users $user)
    {
        $this->model = new Repo($user);
        $this->userRepository = new UserRepository($user);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->model->all();
        return Template::loadView("admin.settings.user.user_list", $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospital = DB::table('wsec_hospital')->select('hospital_name', 'hospital_no_pk')->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadView("admin.settings.user.create_new_user",['hospital'=>$hospital]);
    }

    public function create_form()
    {
        $person_name_qurey = [];
        $hospital = DB::table('wsec_hospital')->select('hospital_name', 'hospital_no_pk')->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->get();
        // dd($hospital );

        return Template::loadView("admin.settings.user.create_new_user_form", ['person_name_qurey' => $person_name_qurey, 'hospital' => $hospital]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        return $this->userRepository->createOrUpdate($request, $request->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = $this->model->show($id);

        $person_name_qurey = DB::table("employee_info_vw")->select("full_name", "person_no_pk")->where('person_no_pk', $data->person_no_fk)->first();
        $hospital = DB::table('wsec_hospital')->select('hospital_name', 'hospital_no_pk')->get();

        return Template::loadView("admin.settings.user.create_new_user_form", ['data' => $data, 'person_name_qurey' => $person_name_qurey, 'hospital' => $hospital]);
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

    public function getUserInfoById($id)
    {
        return $id;
    }

    public function getAllUsers(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";

        $table = 'wsec_user';
        // Table's primary key
        $primaryKey = 'user_no_pk';



        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'user_name', 'dt' => 1),
            array('db' => 'user_code',  'dt' => 2),
            array('db' => 'user_fullname',   'dt' => 3),
            array('db' => 'email',   'dt' => 4),
            array('db' => 'status',   'dt' => 5),
            array('db' => 'user_no_pk',   'dt' => 6),
        );
        // echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
        //        $columns = array(
        //                'sl',
        //                'user_name' ,
        //                'user_code' ,
        //                'user_fullname' ,
        //                'email',
        //                'status',
        //                'user_no_pk'
        //        );
        //
        //        $sql = "SELECT '' as sl,  user_name, user_code, user_fullname, email, case when status=1 then 'Active' else 'Inactive' end as status, user_no_pk, rownum rownumber, au_update_at, au_entry_at
        //        FROM wsec_user"
        //        ;
        //        $order_by_column = "user_no_pk";
        //
        //        $json_data = $this->datatable( $request, $sql, $order_by_column, 'DESC', $columns );
        //
        //        echo json_encode($json_data);

    }
}
