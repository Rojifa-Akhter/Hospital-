@php

$email_format = (isset($email_format) && (!empty($email_format))) ? $email_format : [];

$email_format_no_pk = ($email_format) ? $email_format->email_format_no_pk : '';
$email_event_ddl = ($email_format) ? $email_format->email_event_lookup_no_pk : '';
$email_subject = ($email_format) ? $email_format->email_subject : '';
$email_body = ($email_format) ? $email_format->email_body1 : '';
$email_comments = ($email_format) ? $email_format->comments : '';
@endphp

<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('email-format.store') }}" method="post" id="email-format-create">
        @csrf
        <input type="hidden" name="id" value="{{ $email_format_no_pk }}">
        <div class="form-group row">
            <label for="email_event_ddl" class="col-sm-12 col-form-label col-form-label-sm">Email Event <span class="text-danger">*</span></label>
            <div class="col-sm-12">
                <select class="form-control font_size_12 m-auto required" id="email_event_ddl" name="email_event_ddl" required>
                    <option selected="selected" disabled value="">Select Email Event</option>
                    @if(isset($email_event_ddl))
                        @foreach($email_event as $key => $value )
                            <option value="{{ $key }}" @if($email_event_ddl == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <label for="email_subject" class="col-sm-12 col-form-label col-form-label-sm">Email Subject <span class="text-danger">*</span></label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm required" id="email_subject" name="email_subject" value="{{ $email_subject }}" placeholder="Enter Email Subject" required>
            </div>

            <label for="email_body" class="col-sm-12 col-form-label col-form-label-sm">Body</label>
            <div class="col-sm-12">
                <textarea class="form-control form-control-sm required" name="email_body" id="email_body" cols="30" rows="10" required>{{ $email_body }}</textarea>
            </div>

            <label for="email_comments" class="col-sm-12 col-form-label col-form-label-sm">Comments</label>
            <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="email_comments" name="email_comments" value="{{ $email_comments }}" placeholder="Enter Comments">
            </div>
        </div>
        <div class="modal-footer mt-1">
            @php
                $response_action = route('email-format.index');
            @endphp
			<button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
            <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
		</div>
    </form>
</div>

<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script>
	loadEditor("email_body");
</script>
