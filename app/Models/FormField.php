<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $table        = 'form_fields';
    protected $primaryKey   = 'form_fields_no_pk';
    public $sequence        = 'form_fields_no_pk_seq';


    protected $guarded = ['form_fields_no_pk'];
   protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean'
    ];

    public function template()
    {
        return $this->belongsTo(FormTemplate::class);
    }
}
