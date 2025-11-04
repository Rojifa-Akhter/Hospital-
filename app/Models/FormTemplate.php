<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormTemplate extends Model
{
    protected $table        = 'form_templates';
    protected $primaryKey   = 'form_templates_no_pk';
    public $sequence        = 'form_templates_no_pk_seq';


    protected $guarded = ['form_templates_no_pk'];
   public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('sort_order');
    }
}
