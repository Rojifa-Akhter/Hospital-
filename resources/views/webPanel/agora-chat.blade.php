@extends('iCure-Home.admin.partials.cover_master')



@section('admin_content')
    <div id="app">
        <agora-chat :allusers="{{ \json_encode($users) }}" authuserid="{{ Auth::user()->user_no_pk }}"
            authuser="{{ Auth::user()->user_fullname }}" agora_id="{{ env('AGORA_APP_ID') }}" />
    </div>
@endsection
