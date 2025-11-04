<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">


        @csrf
        <section class="paitent__registration_details">
        <div class="container-fluid">
                
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                <thead class="global-uhl-table-bg">
                <tr>
                        <th rowspan="2">SL#</th>
                        <th class="text-left "  rowspan="2">Service Type</th>
                        <th class="text-left"  style="width: 50px;" rowspan="2">No of Item</th>
                        <th class="text-left"  style="width: 50px;" rowspan="2">Total Qty</th>
                        <th class="text-right"  style="width: 100px;" rowspan="2">Total Sales</th>
                        <th class="text-right"  style="width: 100px;" rowspan="2">Total Service Charge</th>
                        <th class="text-right"  style="width: 100px;" rowspan="2">Total Discount</th>                    
                        <th class="text-center" style="width: 100px;" colspan="2">Hospital Discount</th>
                        <th class="text-center"  style="width: 100px;"colspan="2">Doctor Discount</th>
                        <th class="text-left"  style="width: 50px;" rowspan="2">Discount Return</th>
                    </tr> 

                    <tr>
                        <th style="width: 100px;">(%)</th>
                        <th style="width: 100px;">Amt.</th>
                        <th style="width: 100px;">(%)</th>
                        <th style="width: 100px;">Amt.</th>
                    </tr>
                    
                </thead>

                <tbody id="body">
                           
                @if(isset($payment_details) && !empty($payment_details))
                @php
                 $total_sales=0;
                 $total_service_charge=0;
                 $total_discount=0;
                 $total_hos_dis=0;
                 $total_doc_dis=0;
                
                
                @endphp
                    @foreach($payment_details as $value)
                    @php
                    $total_sales +=$value->total_sales;
                    $total_service_charge +=$value->service_charge;
                    $total_discount +=$value->tot_discount;
                     $total_hos_dis=0;
                     $total_doc_dis=0;
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            {{$value->service_type}}                          
                        </td>
                        <td>
                            {{$value->no_of_item}}
                           
                        </td>
                        <td>
                            {{$value->tot_qty}}
                           
                        </td>
                        <td>
                           
                            <input type="text" class="total_salse text-right form-control" id="total_salse" name="total_salse" value="{{$value->total_sales !='' ? $value->total_sales :''}}" readonly>
                        </td>
                        <td>
                           
                            <input type="text" class="total_service_charge text-right form-control" id="total_service_charge" name="total_service_charge" value="{{$value->service_charge !='' ? $value->service_charge :''}}" readonly>
                        </td>
                        <td>
                            <input type="text" class="total_discount text-right form-control" id="total_discount" name="total_discount" value="{{$value->tot_discount !='' ? number_format("$value->tot_discount", 2, '.', '') :''}}" readonly>
                        </td>
                      
                        <td>
                            <input type="text" class="hos_percent text-right form-control number_only" id="hos_percent" name="hos_percent" value="" onkeyup="discountCalculate(this)" >
                        </td>
                        <td>
                            <input type="text" class="hos_amt text-right form-control number_only" data-service_type="{{$value->itemtype_no_fk}}" id="hos_amt" name="hos_amt_{{$value->itemtype_no_fk}}[]" value=""  onkeyup="discountCalculate(this)">
                        </td>
                        <td>
                            <input type="text" class="doc_perce text-right form-control number_only" id="doc_perce" name="doc_perce" value=""  onkeyup="discountCalculate(this)">
                        </td>
                        <td>
                            <input type="text" class="doc_amt text-right form-control number_only" data-service_type="{{$value->itemtype_no_fk}}" id="doc_amt" name="doc_amt_{{$value->itemtype_no_fk}}[]" value=""  onkeyup="discountCalculate(this)">
                        </td>
                        <td>
                            <input type="text" class="discount_return text-right form-control number_only" data-service_type="{{$value->itemtype_no_fk}}" id="discount_return" name="discount_return_{{$value->itemtype_no_fk}}[]" value=""  onkeyup="discountCalculate(this)">
                        </td>
                       
                    </tr>
                    
                 
                    @endforeach
                @endif 
                <tr>
                        <td colspan="4" class="text-right">Total</td>
                        <td> <input type="text" class="grand_salse text-right form-control" id="grand_salse" name="grand_salse" value="{{$total_sales}}" readonly></td>
                        <td> <input type="text" class="grand_service_charge text-right form-control" id="grand_service_charge" name="grand_service_charge" value="{{$total_service_charge}}" readonly></td>
                        <td> <input type="text" class="grand_discount text-right form-control" id="grand_discount" name="grand_discount" value="{{ number_format("$total_discount", 2, '.', '')}}" readonly></td>
                        <td> <input type="text" class=" text-right form-control" id="total_hos_perc" name="" value="" readonly></td>
                        <td>   <input type="text" class=" text-right form-control" id="total_hos_amt" name="" value="" readonly></td>
                        <td> <input type="text" class=" text-right form-control" id="total_doc_perc" name="" value="" readonly></td>
                        <td> <input type="text" class=" text-right form-control" id="total_doc_amt" name="" value="" readonly></td>
                        <td> <input type="text" class=" text-right form-control" id="total_discount_return" name="" value="" readonly></td>
                    </tr>
                    <tr><td colspan="14" class="text-right"> <button type="button" class="btn btn-md btn-success p-5" data-dismiss="modal" onclick="setDiscount(this)">Set</button><button type="button" class="btn btn-md btn-info p-5" data-dismiss="modal" onclick="returnDiscount(this)">Return Discount</button></td></tr> 
                </tbody>
              
              </table>
              <span id="save_popupInfo" class="d-none"> </span>
            </div>
        </div>
        </section>



</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>


function discountCalculate(element) {
        var input_element=$(element);
        var total_salse =$(element).parents('td').parents('tr').find('.total_salse');
        var total_dis =$(element).parents('td').parents('tr').find('.total_discount');
        var hos_perc=$(element).parents('td').parents('tr').find('.hos_percent');
        var hos_amt=$(element).parents('td').parents('tr').find('.hos_amt');
        var doc_perc=$(element).parents('td').parents('tr').find('.doc_perce');
        var doc_amt=$(element).parents('td').parents('tr').find('.doc_amt');


        if (($(element).parents('td').parents('tr').find('.total_salse').val())  <=0 ) {
            alert('Sales Amount less then  0');
            $(element).val('');
            gross_calculate()
            return false;
        }      

        if (input_element.attr('id') =="discount_return") {
            console.log($(element).parents('tr').find('.total_discount').val() , input_element.val() +'____dis_return')
            if (parseFloat($(element).parents('tr').find('.total_discount').val()) < parseFloat(input_element.val())) {
            alert('Invalid Discount Return Amount')
            $(element).val('');           
            gross_calculate()
            return false;
            }
            
            // var cal_amt=parseFloat(total_salse.val() - total_dis.val())*parseFloat(input_element.val() *1) / 100;
            // hos_amt.val(cal_amt.toFixed(2));            
        }
        if (input_element.attr('id') =="hos_percent") {
            if ((parseFloat(hos_perc.val() *1) + parseFloat(doc_perc.val() *1)) > 100) {
            alert('Enter percent less then or equel 100')
            $(element).val('');
            hos_amt.val('');
            gross_calculate()
            return false;
            }
            var cal_amt=parseFloat(total_salse.val() - total_dis.val())*parseFloat(input_element.val() *1) / 100;
            hos_amt.val(cal_amt.toFixed(2));            
        }
        if (input_element.attr('id') =="doc_perce") {
            if ((parseFloat(hos_perc.val() *1) + parseFloat(doc_perc.val() *1)) > 100) {
            alert('Enter percent less then or equel 100')
            $(element).val('');
            doc_amt.val('');
            gross_calculate()
            return false;
            }
            var cal_amt=parseFloat(total_salse.val() - total_dis.val())*parseFloat(input_element.val() *1) / 100;
            doc_amt.val(cal_amt.toFixed(2));            
        }

        if (input_element.attr('id') =="hos_amt") {
            if ((parseFloat(hos_amt.val() *1) + parseFloat(doc_amt.val() *1)) > (total_salse.val() - total_dis.val())) {
            alert('Enter discount less then t  or equel Sales amoun')
            $(element).val('');
            hos_perc.val('');
            gross_calculate()
            return false;
            }          
            var cal_perc=parseFloat(input_element.val()*1) * 100 / parseFloat(total_salse.val() - total_dis.val()) ;
            hos_perc.val(cal_perc.toFixed(2));            
        }
        if (input_element.attr('id') =="doc_amt") {
            if ((parseFloat(hos_amt.val() *1) + parseFloat(doc_amt.val() *1)) > total_salse.val() - total_dis.val()) {
            alert('Enter discount less then t  or equel Sales amoun')
            $(element).val('');
            doc_perc.val('');
            gross_calculate()
            return false;
            }            
            var cal_perc=parseFloat(input_element.val()*1) * 100 / parseFloat(total_salse.val() - total_dis.val());
            doc_perc.val(cal_perc.toFixed(2));            
        }
        gross_calculate()
       

}

function gross_calculate() {
    var total_hos_perc=0;
        var total_hos_amt=0;
        var total_doc_perc=0;
        var total_doc_amt=0;
        var total_discount_return=0;
        $('.hos_percent').each(function(){
            var hos_perc=$(this).parents('td').parents('tr').find('.hos_percent');
            var hos_amt=$(this).parents('td').parents('tr').find('.hos_amt');
            var doc_perc=$(this).parents('td').parents('tr').find('.doc_perce');
            var doc_amt=$(this).parents('td').parents('tr').find('.doc_amt');
            var discount_return=$(this).parents('td').parents('tr').find('.discount_return');

            total_hos_perc +=parseFloat(hos_perc.val() *1);
            total_hos_amt +=parseFloat(hos_amt.val() *1);
            total_doc_perc +=parseFloat(doc_perc.val() *1);
            total_doc_amt +=parseFloat(doc_amt.val() *1);
            total_discount_return +=parseFloat(discount_return.val() *1);
        })
        $('#total_hos_perc').val(total_hos_perc.toFixed(2))
        $('#total_hos_amt').val(total_hos_amt.toFixed(2))
        $('#total_doc_perc').val(total_doc_perc.toFixed(2))
        $('#total_doc_amt').val(total_doc_amt.toFixed(2))
        $('#total_discount_return').val(total_discount_return.toFixed(2))
}

function setDiscount(element) {
    
    var hos_dis = $('#total_hos_perc').val();
    var hos_amt = $('#total_hos_amt').val();
    var doc_dis = $('#total_doc_perc').val();
    var doc_amt = $('#total_doc_amt').val();
    

        var hos_doc_amt=[];
        $('.doc_amt').each((key,amt)=>{
        var hos_s_type=$(amt).parents('td').parents('tr').find('.hos_amt').attr('data-service_type');
        var doc_s_type=$(amt).attr('data-service_type');
        if($(amt).parents('td').parents('tr').find('.hos_amt').val() || $(amt).val()){
            var srv_type_dis=hos_s_type +'_'+$(amt).parents('td').parents('tr').find('.hos_amt').val()+'_'+$(amt).val();
            hos_doc_amt[key]='<input type="hidden" name="srv_type_discount[]" value="'+srv_type_dis+'">';
    
        }
    }) 

    if(hos_amt > 0 && doc_amt > 0 ){
      

        $('#discount_percent_hospital').val(0);
        $('#discount_amount_by_hospital').val(0);
        $('#discount_percent_doctor').val(0);
        $('#discount_amount_by_doctor').val(0);

        $('#discount_block').removeClass('d-none');
        $('.hospital_disc').removeClass('d-none');
        $('.percent_hospital').removeClass('d-none');
        $('#discount_block').removeClass('d-none');
        $('.percent_doctor').removeClass('d-none');
        $('#cmb_discount').val('BOTH');
        $('#discount_percent_hospital').val(hos_dis);
        $('#discount_amount_by_hospital').val(hos_amt);
        $('#discount_percent_doctor').val(doc_dis);
        $('#discount_amount_by_doctor').val(doc_amt);
        calculateTotalinAmount($('#total_hos_amt'));
    } else if(hos_amt > 0){
        
        $('#discount_percent_hospital').val(0);
        $('#discount_amount_by_hospital').val(0);
        $('#discount_percent_doctor').val(0);
        $('#discount_amount_by_doctor').val(0);

        $('#discount_block').removeClass('d-none');
        $('.hospital_disc').removeClass('d-none');
        $('.percent_hospital').removeClass('d-none');
        $('.percent_doctor').addClass('d-none');
        $('#cmb_discount').val('GENERAL');
        $('#discount_percent_hospital').val(hos_dis);
        $('#discount_amount_by_hospital').val(hos_amt);
        calculateTotalinAmount($('#total_hos_amt'));
    } else if(doc_amt > 0){
        console.log(doc_dis , doc_amt)
        $('#discount_percent_hospital').val(0);
        $('#discount_amount_by_hospital').val(0);
        $('#discount_percent_doctor').val(0);
        $('#discount_amount_by_doctor').val(0);

        $('#discount_block').removeClass('d-none');
        $('.percent_doctor').removeClass('d-none');
        $('.hospital_disc').addClass('d-none');
        $('.percent_hospital').addClass('d-none');
        $('#cmb_discount').val('DOCTOR');
        $('#discount_percent_doctor').val(doc_dis);
        $('#discount_amount_by_doctor').val(doc_amt);
        calculateTotalinAmount($('#total_doc_amt'));
    }else{
        $('#discount_percent_hospital').val(0);
        $('#discount_amount_by_hospital').val(0);
        $('#discount_percent_doctor').val(0);
        $('#discount_amount_by_doctor').val(0);
        $('#discount_block').addClass('d-none');
        calculateTotalinAmount($('#total_doc_amt'));
        hos_doc_amt ='';
    }
    $('#set_service_type_dis').html(hos_doc_amt);
    $('#save_popupInfo').html($('#body').html());
// console.log(hos_doc_amt);
}
function returnDiscount(element) {
    
    // var hos_dis = $('#total_hos_perc').val();
    // var hos_amt = $('#total_hos_amt').val();
    // var doc_dis = $('#total_doc_perc').val();
    // var doc_amt = $('#total_doc_amt').val();
    var discount_return_amt = $('#total_discount_return').val();
    $('#return_discount').removeClass('d-none')
    $('#discount_return_amt').val(discount_return_amt);
    $('#discount_return_amt').prop('readonly',true)
  

        var discount_return=[];
        $('.discount_return').each((key,amt)=>{
        var hos_s_type=$(amt).parents('td').parents('tr').find('.hos_amt').attr('data-service_type');
        // var doc_s_type=$(amt).attr('data-service_type');
        if($(amt).parents('td').parents('tr').find('.hos_amt').val() || $(amt).val()){
            var srv_type_dis=hos_s_type +'_'+$(amt).parents('td').parents('tr').find('.discount_return').val();
            discount_return[key]='<input type="hidden" name="discount_return[]" value="'+srv_type_dis+'">';
    
        }
    }) 

    // if(hos_amt > 0 && doc_amt > 0 ){ 
      

    //     $('#discount_percent_hospital').val(0);
    //     $('#discount_amount_by_hospital').val(0);
    //     $('#discount_percent_doctor').val(0);
    //     $('#discount_amount_by_doctor').val(0);

    //     $('#discount_block').removeClass('d-none');
    //     $('.hospital_disc').removeClass('d-none');
    //     $('.percent_hospital').removeClass('d-none');
    //     $('#discount_block').removeClass('d-none');
    //     $('.percent_doctor').removeClass('d-none');
    //     $('#cmb_discount').val('BOTH');
    //     $('#discount_percent_hospital').val(hos_dis);
    //     $('#discount_amount_by_hospital').val(hos_amt);
    //     $('#discount_percent_doctor').val(doc_dis);
    //     $('#discount_amount_by_doctor').val(doc_amt);
    //     calculateTotalinAmount($('#total_hos_amt'));
    // } else if(hos_amt > 0){
        
    //     $('#discount_percent_hospital').val(0);
    //     $('#discount_amount_by_hospital').val(0);
    //     $('#discount_percent_doctor').val(0);
    //     $('#discount_amount_by_doctor').val(0);

    //     $('#discount_block').removeClass('d-none');
    //     $('.hospital_disc').removeClass('d-none');
    //     $('.percent_hospital').removeClass('d-none');
    //     $('.percent_doctor').addClass('d-none');
    //     $('#cmb_discount').val('GENERAL');
    //     $('#discount_percent_hospital').val(hos_dis);
    //     $('#discount_amount_by_hospital').val(hos_amt);
    //     calculateTotalinAmount($('#total_hos_amt'));
    // } else if(doc_amt > 0){
    //     console.log(doc_dis , doc_amt)
    //     $('#discount_percent_hospital').val(0);
    //     $('#discount_amount_by_hospital').val(0);
    //     $('#discount_percent_doctor').val(0);
    //     $('#discount_amount_by_doctor').val(0);

    //     $('#discount_block').removeClass('d-none');
    //     $('.percent_doctor').removeClass('d-none');
    //     $('.hospital_disc').addClass('d-none');
    //     $('.percent_hospital').addClass('d-none');
    //     $('#cmb_discount').val('DOCTOR');
    //     $('#discount_percent_doctor').val(doc_dis);
    //     $('#discount_amount_by_doctor').val(doc_amt);
    //     calculateTotalinAmount($('#total_doc_amt'));
    // }else{
    //     $('#discount_percent_hospital').val(0);
    //     $('#discount_amount_by_hospital').val(0);
    //     $('#discount_percent_doctor').val(0);
    //     $('#discount_amount_by_doctor').val(0);
    //     $('#discount_block').addClass('d-none');
    //     calculateTotalinAmount($('#total_doc_amt'));
    //     hos_doc_amt ='';
    // }
    $('#set_discount_return').html(discount_return);
    $('#save_popupInfo').html($('#body').html());
// console.log(hos_doc_amt);
}

</script>

