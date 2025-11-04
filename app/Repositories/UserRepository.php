<?php

namespace App\Repositories;

use App\Models\Users;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;

class userRepository extends BaseRepository
{

    protected $user = null;
    protected $baseRepository;

    public function __construct(Users $user)
    {
        $this->user = $user;
        $this->baseRepository = new BaseRepository($user);
    }

    public function all()
    {
        return $this->user->all();
    }

    public function createOrUpdate($request, $id = null)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // au_entry_at
        // au_entry_by
        // au_entry_hospital_pk_no
        // au_entry_session
        // au_sync_at
        // au_sync_hospital_pk_no
        // au_update_at
        // au_update_by
        // au_update_hospital_pk_no
        // au_update_session
        // default_module_pk_no
        // default_page
        // person_code
        // person_no_fk
        // remember_token
        // status
        // user_no_pk

        // user_lock_ind lock_user
        // pass_expiry_ind expire_password
        // user_expire_ind expire_user

        // email user_email
        // user_code user_code
        // user_fullname user_full_name
        // user_name user_name
        // user_expire_date user_expire_date
        // user_pass user_password
        // password_expiry_date pass_expire_date
        // hospital_no_pk select_hospital


        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $data = [
                'user_code'             => $request->user_code,
                'user_lock_ind'         => isset($request->expire_user) ? 1 : null,
                'pass_expiry_ind'       => isset($request->expire_password) ? 1 : null,
                'user_expire_ind'       => isset($request->expire_user) ? 1 : null,
                'financial_ind'         => isset($request->financial_ind) ? 1 : null,
                'user_name'             => $request->user_name,
                'user_fullname'         => ucwords($request->user_full_name),
                'email'                 => $request->user_email,
                'user_expire_date'      => $request->user_expire_date != null ? date('Y-m-d', strtotime($request->user_expire_date)) : "",

                'password_expiry_date'  => $request->pass_expire_date != null ? date('Y-m-d', strtotime($request->pass_expire_date)) : "",
                'hospital_no_pk'        => $request->select_hospital,
                'user_pass'             => Hash::make($request->user_password),
                'user_name_access_code' => $request->input("user_password"),
                'status'                => isset($request->status) ? 1 : null,
                'person_no_fk'          => $request->emp_id,
                'au_entry_hospital_pk_no' => $ses_hospital_id,

            ];
            // date('Y-m-d', strtotime($request->user_expire_date))
            //    dd($request->user_expire_date);

            // return $data;

            // $this->baseRepository->create($data);


            if ($id == null) {

                $data['au_entry_by'] = $auth_id;

                $this->baseRepository->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->baseRepository->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
}
