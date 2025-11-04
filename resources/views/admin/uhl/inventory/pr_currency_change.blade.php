<div id="default_item_table" style="height: 300px;">
    <form id="currency" action="{{route('update-pr-currency')}}" method="post">
    <input type="hidden" name="pr_no" value="{{$id}}">
   
    <table>
        <tr>
            <td class="mr-2 "><label > Currency  </label></td>
            <td class="mr-2 ">  : </td>
            <td class="">
                @if (!empty($currency))
                <select class="form-control" name="currency_sign">
                    <option>select</option>
                    @foreach ($currency as $kye=>$value)
                    <option value="{{$value}}" @if($pr_data->currency_sign==$value) selected @endif >{{ $value}}</option>
                    @endforeach
                </select>
                @endif
            </td>
        </tr>
        <tr>
            <td  class="mr-2 "><label> Currency Rate  </label></td>
            <td class="mr-2 ">  : </td>
            <td class=""> 
               <input type="number" class="form-control" name="dollar_rate" value="{{$pr_data->dollar_rate}}">
            </td>
        </tr>
        <tr>
            @php
                $url=route('v1.pr-worklist');
            @endphp
            <td  class="mr-2 "></td>
            <td class="mr-2 ">   </td>
            <td class="text-right"> 
            <button type="button" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{$url}}')">Save</button>
            </td>
        </tr>
    </table>
    </form>
</div>