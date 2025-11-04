@if(!empty($category_data))
@foreach($category_data as $value)
<tr>
<input type="hidden" class="cat_id" id="cat_id" value="{{$value->assetcat_no_pk}}">
<input type="hidden" class="class_id" id="class_id" value="{{$value->assetclass_no_fk}}">
<input type="hidden" class="acat_acc_code_cost" id="class_id" value="{{$value->acat_acc_code_cost}}">
<input type="hidden" class="acat_acc_code_accum_depr" id="class_id" value="{{$value->acat_acc_code_accum_depr}}">
<input type="hidden" class="acat_acc_code_depr" id="class_id" value="{{$value->acat_acc_code_depr}}">
<input type="hidden" class="acat_acc_code_revaluation" id="class_id" value="{{$value->acat_acc_code_revaluation}}">
<input type="hidden" class="acat_acc_code_impairment" id="class_id" value="{{$value->acat_acc_code_impairment}}">
<input type="hidden" class="acat_acc_code_salesprofit" id="class_id" value="{{$value->acat_acc_code_salesprofit}}">
<input type="hidden" class="acat_acc_code_deftax_bs" id="class_id" value="{{$value->acat_acc_code_deftax_bs}}">
<input type="hidden" class="acat_acc_code_deftax_is" id="class_id" value="{{$value->acat_acc_code_deftax_is}}">
    <td>{{$loop->iteration}}</td>
    <td class="assetcat_uid">{{$value->assetcat_uid}}</td>
    <td class="assetclass_name">{{$value->assetclass_name}}</td>
    <td class="assetcat_name">{{$value->assetcat_name}}</td>
    <td class="">{{$value->cost}}</td>
    <td class="">{{$value->acc_depr}}</td>
    <td class="">{{$value->depreciation}}</td>
    <td class="">{{$value->revalue}}</td>
    <td class="">{{$value->impairment}}</td>
    <td class="">{{$value->profit}}</td>
    <td class="">{{$value->bs}}</td>
    <td class="">{{$value->is}}</td>
    <td class="depreciation_percent">{{$value->depreciation_percent}}</td>
    <td class="life_year">{{$value->life_year}}</td>
    <td>
    <span class="btn btn-sm btn-primary" onclick="editCat(this)"><i class="fa fa-pencil-alt"></i></span>
    </td>
</tr>
@endforeach
@endif