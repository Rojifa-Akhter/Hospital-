<?php

namespace App\Models;

use App\Models\MenuFeature;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table        = 'wsec_menutree';
    protected $primaryKey   = 'menu_no_pk';
    public $sequence        = 'wsec_menutree_menu_no_pk_seq';
    protected $guarded = ['menu_no_pk'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_code','parent_menu_no_fk','menu_name','menu_name_nls','sl_no', 'menu_link','menu_icon','status','au_entry_hospital_pk_no'];


    // public function setDobAttribute($value)
    // {
    //     $this->attributes['DOB'] = date('Y-m-d H:i:s', strtotime($value));
    // }
    // public function setRegDateAttribute($value)
    // {
    //     $this->attributes['REG_DATE'] = date('Y-m-d H:i:s', strtotime($value));
    // }

    //public $incrementing = false;
    // timestamp associate with it
   // protected $guarded = ['PATIENT_NO_PK'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';


    public function submenu(){
        return $this->hasMany(Menu::class, 'parent_menu_no_fk', 'menu_no_pk');
  
    }

    public function pages(){
        return $this->hasMany(MenuFeature::class, 'menu_no_pk', 'menu_no_pk');
    }
}