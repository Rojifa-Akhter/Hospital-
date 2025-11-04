<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormTemplate;
use App\Models\FormField;
use Auth;
use DB;
use App\Library\Template;
use NumberToWords\Legacy\Numbers\Words\Locale\Id;
use Session;
class FormFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id="")
    {   
        $id=682;
        $templates = FormTemplate::where('form_templates_no_pk',$id)->first();       
        return Template::loadview("admin.settings.dynamic_form_fields",['templates'=>$templates]);
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
            // 'form_template_id' => 'required|exists:form_templates',
            'label' => 'required|string|max:255',
            'field_name' => 'required|string|max:255|regex:/^[a-zA-Z_]+$/',
            'db_column_name' => 'required|string|max:255|regex:/^[a-zA-Z_]+$/',
            'field_type' => 'required|in:text,textarea,radio,checkbox,select,number,date',
            'options' => 'nullable|string',
            // 'is_required' => 'boolean',
            'sort_order' => 'integer'
        ]);

        // Convert options from textarea to array
        if (!empty($validated['options'])) {
            $options = explode("*", $validated['options']);
            $options = array_map('trim', $options);
            $options = array_filter($options);
            $validated['options'] = $options;
        } else {
            $validated['options'] = null;
        }
        
        $auth_id=Auth::id();
        $toDate=date('Y-m-d');
        $hospital_id=Session::get('user.ses_hospital_no_pk');
            $id='';

            $data=[
                'form_template_no_fk'=>$request->form_template_id,
                'field_name'=>$request->field_name,
                'label_name'=>$request->label,
                'db_column_name'=>$request->db_column_name,
                'field_type'=>$request->field_type,
                'options'=>$request->options,
                'is_required'=>$request->is_required,
                'sort_order'=>$request->sort_order,
                'status'=>1,               
            ];
            // dd($data);
            if ($id=='') {
                $sequence = DB::getSequence();
                $seq = $sequence->nextValue('form_fields_no_pk_seq');
                $data['form_fields_no_pk']=$seq;
                $data['au_entry_by']=$auth_id;
                $data['au_entry_at']=$toDate;
                $data['au_entry_session']='form';
                $data['au_entry_hospital_pk_no']=$hospital_id;
                FormField::insert($data);
            }else {
                $data['au_update_by']=$auth_id;
                $data['au_update_at']=$toDate;
                $data['au_update_session']='form';
                $data['au_update_hospital_pk_no']=$hospital_id;
                FormField::where('form_fields_no_pk',$id)->update($data);
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
