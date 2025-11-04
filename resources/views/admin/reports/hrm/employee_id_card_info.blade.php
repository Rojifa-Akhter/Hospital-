 @if(isset($emp_info))
 <div class="form-row">
  <div class="col-md-4">
    <div class="form-row pt-2" style="border: 1px solid; background-color: white; padding: 10px ">
      <div class=" col-md-2">
       <img class="card-img-top" src="{{url('/images/kbmh.jpg')}}" alt="Card image" style="width:100%">
     </div>  
     <div class=" col-md-10" style=" font-size: 15px; text-align: center;">
       <strong style="font-size: 14px; line-height: 1; text-transform: capitalize; "> Khwaja Badrudduja Modern Hospital</strong> <br>
       <strong style="font-size: 12px; margin-top: -5px; "> IDENTITY CARD </strong>
     </div>  
     <div class=" col-md-12" style="background-color: blue; padding: 2px; color: white; text-align: center; margin-bottom: 10px;">
      <h3 style=" font-size: 12px; margin: 0;"> {{$emp_info->su_name}} </h3>
    </div>  
    <div class=" col-md-8" >
      <table>
        <tr>
          <!-- <td style="font-size: 14px; margin: 0px;"> Name </td> -->
          <td style="font-size: 12px; margin: 0px;"> 
          <div> <strong>{{$emp_info->full_name}}</strong>  </div> 
          <div> <strong> {{$emp_info->designation}}</strong></div> 
          <div> <strong>{{$emp_info->blood_group}}</strong>  </div> 
          <div> <strong> Join Date</strong> : {{date('d-m-Y',strtotime($emp_info->join_date))}}</div> 
          
          
          
          
         </td>
       </tr>
     </table>
   </div>  
   <div class=" col-md-4"> 
    <div style="width: 70px; height: 70px; overflow: hidden; border-radius: 5px; margin-left: auto;">
      <img style=""  class="card-img-top W-100" src="{{ asset('images/uploads/doctor_images/')}}/{{$emp_info->photo_name}}" alt="">
    </div>
    <div style="margin-top: 5px; text-align: right;">
      <img src="data:image/png;base64, {{ $barcode_no }} " width="95%" />

    </div>
  </div>  
</div>
</div>
</div>

<div class="form-row mt-5" >
  <div class="col-md-4 bg-white" style="border: 1px solid; background-color: white; padding: 10px;  ">
    <div class="form-row pt-2" >
      <div class=" col-md-12" style="text-align: center;">
       <strong>If found please return to :</strong>
     </div>  
     <div class=" col-md-12" style="text-align: center;"> <strong> KHWAJA BADRUDDUJA MODERN HOSPITAL </strong> </div>  

   </div>
   <div class="form-row ">
     <div class=" col-md-8" style=" "> <strong> Block -D, Holding - 10/1, Aziz Mansion, Shafipur, Kaliakair, Gazipur <br> <i class="fas fa-phone"></i>  01776-606262 <br> <i class="fas fa-phone"></i> 01687-625565 </strong>
     </div>  
     <div class=" col-md-4 text-right" style="margin-top: 65px">
      <span style="border-top: 1px solid; font-size: 10px">Authorised Signature</span style="border-top: 1px solid; ">
      </div>  
    </div>
  </div>
</div>
@endif