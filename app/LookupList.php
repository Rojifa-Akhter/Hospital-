<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LookupList extends Model
{
    protected $table        = 'sys_lookuplist';
    protected $primaryKey   = 'lookuplist_no_pk';
    public $sequence        = 'lookuplist_no_pk_seq';


    protected $guarded = ['lookuplist_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['lookuplist_uid','lookuplist_name','lookuplist_desc','lookup_no_fk','serial_no','status', 'lookuplist_no_pk_parent'];

    public function lookup()
    {
        return $this->belongsTo('App\Models\Lookup');
    }
}
