<?php

namespace App\Http\Controllers;
use App\Library\Template;

use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    public function obstetricUrgencyForm(){

        return Template::loadview('admin.settings.classification.classification_obstetric_urgency_form');


    }

    public function obstetricUrgencyExportPDF(){
        return view('admin.settings.classification.classification_obstetric_urgency_form_print');

    }



    public function surgicalUrgencyForm(){

        return Template::loadview('admin.settings.classification.classification_surgical_urgency_form');

    }

    public function surgicalUrgencyExportPDF(){
        return view('admin.settings.classification.classification_surgical_urgency_form_print');

    }






}
