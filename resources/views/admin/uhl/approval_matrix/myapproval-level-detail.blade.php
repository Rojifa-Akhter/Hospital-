
<div class="row">
<div class="col-sm-12 col-lg-12 col-xl-12">
        <div class="form-group row">
            <div class="col-md-12">
                <?php
                   $level_detail = isset($leveldetailInfo) ? $leveldetailInfo->status_text : "";
                   if(!empty($level_detail)){
                        $strArray = explode('@',$level_detail);
                   }else{
                        $strArray = [];
                   }
                ?>
               
                <table class="table table-bordered table-striped">
                    <tbody>
                        @foreach($strArray as $key => $data)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td class="text-left">{{ $data }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>     
            </div>
        </div>


    </div>
</div>


