@php

    $autocompleteDt = isset($autocompleteDt) && !empty($autocompleteDt) ? $autocompleteDt : [];

    $temp_text_ac_no_pk = $autocompleteDt ? $autocompleteDt->temp_text_ac_no_pk : '';
    $text_name = $autocompleteDt ? $autocompleteDt->text_name : '';
    $text_content = $autocompleteDt ? $autocompleteDt->text_content_clob : '';
@endphp

<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .redactor_editor {
        min-height: 450px !important;
    }
    #cke_1_contents{
    min-height: 650px;
    width: 630px;
}
</style>
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('radiology.store-radiology-autocomplete') }}" method="post" id="lookup-create">
        @csrf
        <input type="hidden" name="id" value="{{$temp_text_ac_no_pk}}">
        <input type="hidden" name="editor_content" id="editor_content"/>
        <div class="form-group row">
            <label for="tem_name" class="col-sm-12 col-form-label col-form-label-sm">Template Name <span
                    class="text-danger">*</span></label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="tem_name" name="tem_name"
                    value="{{$text_name}}" placeholder="Enter Template Name"  required>
            </div>

            <label for="template_description" class="col-sm-12 col-form-label col-form-label-sm">Template Description
                <span class="text-danger">*</span></label>
            <div class="col-sm-12">
                {{-- <input type="text" class="form-control form-control-sm" id="template_description"
                    name="template_description" value="{{$text_content}}" placeholder="Enter Template Description"
                    required> --}}

                    <textarea id="editor1" name="template_description" class="ckeditor"
                                    style="height: 60vh">{{ $text_content }}</textarea>



            </div>
        </div>


        <div class="modal-footer mt-1">
            @php
                $response_action = route('radiology-editor-autocomplete');
            @endphp


            <div class="col-md-12 mt-4">
                <button type="submit"
                    class="btn btn-md btn-success"onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
            </div>
    </form>
</div>

<script>
    var editor = CKEDITOR.replace( 'editor1',{tabSpaces:4} );

     editor.on( 'change', function( evt ) {
        // getData() returns CKEditor's HTML content.
        console.log( 'Total bytes: ' + evt.editor.getData() );
        $('#editor_content').val(evt.editor.getData())
    });


</script>
