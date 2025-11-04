<?php

namespace App\Http\Controllers;

use App\Models\FormTemplate;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Library\Template;
use NumberToWords\Legacy\Numbers\Words\Locale\Id;
use Session;
class FormTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $templates = FormTemplate::with('fields')->get();
        return Template::loadview("admin.settings.dynamic_form_templates_list",['templates'=>$templates]);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          return Template::loadview("admin.settings.dynamic_form_templates");
         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
             $validated = $request->validate([
                'name' => 'required|string|max:255',
            // 'submit_url' => 'required|url',
            ]);
            $auth_id=Auth::id();
            $toDate=date('Y-m-d');
            $hospital_id=Session::get('user.ses_hospital_no_pk');
            $data=[
                'form_templates_name'=>$request->name,
                'submit_url'=>$request->submit_url,
                'redirect_url'=>$request->redirect_url,
                'status'=>1,               
            ];
            $id='';
            if ($id=='') {
                $sequence = DB::getSequence();
                $seq = $sequence->nextValue('form_templates_no_pk_seq');
                $data['form_templates_no_pk']=$seq;
                $data['au_entry_by']=$auth_id;
                $data['au_entry_at']=$toDate;
                $data['au_entry_session']='form';
                $data['au_entry_hospital_pk_no']=$hospital_id;
                FormTemplate::insert($data);
            }else {
                $data['au_update_by']=$auth_id;
                $data['au_update_at']=$toDate;
                $data['au_update_session']='form';
                $data['au_update_hospital_pk_no']=$hospital_id;
                FormTemplate::where('form_templates_no_pk',$id)->update($data);
            }
            
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['msg' => $th->getMessage(), 'title' => 'Error'];
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
        $template = FormTemplate::with('fields')->findOrFail($id);
        return view('templates.edit', compact('template'));
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
}
