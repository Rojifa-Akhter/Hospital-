<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table        = 'wsec_hospital';
    protected $primaryKey   = 'hospital_no_pk';
    public $sequence        = 'wsec_hospital_no_pk_seq';


    protected $guarded = ['hospital_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
    protected $fillable = [
        'website',
        'village',
        'thana',
        'telephone2',
        'telephone1',
        'status',
        'sl_no',
        'report_footer2',
        'report_footer1',
        'mail_smtp_port',
        'mail_smtp_host',
        'mail_auth_email_password',
        'mail_auth_em',
        'logon_url',
        'logo',
        'hospitalchain_no_fk',
        'hospital_slogan',
        // 'hospital_no_pk',
        'hospital_name',
        'hospital_code',
        'hospital_alias',
        'email',
        'division',
        'district',
        'country',
        'au_update_session',
        'au_update_hospital_pk_no',
        'au_update_by',
        'au_update_at',
        'au_sync_hospital_pk_no',
        'au_sync_at',
        'au_entry_session',
        'au_entry_hospital_pk_no',
        'au_entry_by',
        'au_entry_at',
        'addrress2',
        'addrress1',
        'logo_background_color',
        'width_logo',
        'width_nav',
        'width_landing',
        'company_name_text_size',
        'company_slogan_text_size',
        'company_address_text_size',
        'login_background_img',
        'border_colur',
        'landing_img',
        'background_position',
        'hospital_name_bangla',
        'report_header_image_prshde_ind',
        'report_header_image',
        'h360_app_version',
        'email_send_ind',
    ];
}
