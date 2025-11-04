<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormTemplate;
use Auth;
use DB;
use App\Library\Template;
use NumberToWords\Legacy\Numbers\Words\Locale\Id;
use Session;
class DynamicFormController extends Controller
{
     public function show($id)
    {
        $template = FormTemplate::select('form_fields.*','form_templates.form_templates_name','form_templates.submit_url','form_templates.redirect_url')->leftJoin('form_fields','form_fields.form_template_no_fk','=','form_templates.form_templates_no_pk')->where('form_templates.form_templates_no_pk',$id)->get();
      
        return Template::loadview("admin.settings.dynamic_form_create",['template'=>$template]);
      
    }

    public function store(Request $request){
        dd($request->all());
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function submit(Request $request, $id)
    {
        $template = FormTemplate::findOrFail($id);
        
        // Validate based on form fields
        $validationRules = [];
        foreach ($template->fields as $field) {
            $rule = [];
            if ($field->is_required) {
                $rule[] = 'required';
            }
            
            // Add more validation rules as needed based on field type
            switch ($field->field_type) {
                case 'email':
                    $rule[] = 'email';
                    break;
                case 'number':
                    $rule[] = 'numeric';
                    break;
                case 'date':
                    $rule[] = 'date';
                    break;
            }
            
            $validationRules[$field->field_name] = $rule;
        }
        
        $validated = $request->validate($validationRules);
        
        // Process the submission (save to database, send to API, etc.)
        // For now, we'll just redirect to the submit_url with the data
        
        return redirect($template->submit_url)->with('form_data', $validated);
    }
}
