 <style type="text/css">
 	body{
 		font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
 	}
  .card-img-top{
    width: 70px;
  }

</style>

<div style="border: 1px solid; background-color: white; padding: 10px ; width:8.6cm;height: 4.4cm;">
  <div  style="display: inline-block;  padding-top: 10px ;">

   <img src="images/kbmh.jpg" width="60" />

 </div>  
 <div style="text-align: center; font-size: 12px; display: inline-block; margin-top: -23px"> 
   <strong> KHWAJA BADRUDDUJA MODERN HOSPITAL </strong>  <br> <strong> IDENTITY CARD </strong>
 </div>  
 <div  style="background-color: blue; color: white; text-align: center; padding: 2px; margin-top: -5">
   <span style="font-size: 12px; font-weight: 700px;">{{$emp_info->su_name}}</span>
 </div> 


 <div style="margin-top: 1px">
  <table width="100%">
    <tr>
      <!-- <td style="font-size: 14px; margin: 0px;"> Name </td> -->
      <td style="font-size: 11px; vertical-align: top;" >  
        <div> <strong> {{(!empty($emp_info->full_name) ? $emp_info->full_name : '' )}} </strong></div>
        <div>  <strong> {{(!empty($emp_info->designation) ? $emp_info->designation : '')}} </strong></div>
        <div>  <strong> {{(!empty($emp_info->blood_group) ? $emp_info->blood_group : '')}} </strong></div>
        <div>  <strong> Join Date </strong> : {{date('d-m-Y',strtotime($emp_info->join_date))}}</div>

      </td>
      <td style="float:right;">    
       <div  align="right">
        <!-- File::exists($imagePath)?true:false; -->
        @if(!empty($emp_info->photo_name))
        @if(!file_exists(asset("images/uploads/doctor_images/{{$emp_info->photo_name}}")))
        <img class="card-img-top" src="images/uploads/doctor_images/{{$emp_info->photo_name}}" alt="" style="width: 45px">
        @else 
        <img class="card-img-top" src="images/doctor.png" alt="" style="width: 45px">
        @endif
        @endif
      </div>  
      <div  align="right" style="margin-top: 10px"> <img src="data:image/png;base64, {{ $barcode_no }} " /> 
      </div>     
      
    </td>

  </tr>

</table>


</div>  
 <!-- 	<div style="display: inline-block; float:right; margin-top: -15; ">
 		<div style=" width: 60px; border-radius: 5px; margin-left: 55px  ">
 			<img class="card-img-top" src="{{ asset('images/uploads/doctor_images/')}}/{{$emp_info->photo_name}}" alt="" style="width: 100%;">
 		</div>
 		

 		<div style="margin-top: 5px; width: 100px;  margin-left: 15px "> 
 			<img src="data:image/png;base64, {{ $barcode_no }} " width="100%" style="margin-bottom: 5px;" /> 
 			<div style="margin-top: -5px; text-align: right;">
 				<span style=" font-size: 12px;">{{$emp_info->card_no}} </span>
 			</div>           
 			
 		</div> 
 	</div>  -->


 </div>
 <br>
 <br>
 <br>


 <div  style="border: 1px solid; background-color: white; padding: 10px; width:8.6cm; height:4. 4cm";  >

 	<div style="text-align: center;">
 		<strong style="font-size: 16px;">If found please return to :</strong> <br>
 		<strong style="font-size: 12px;"> KHWAJA BADRUDDUJA MODERN HOSPITAL</strong>
 	</div>  

 	<div  style="margin-top: 10px; text-align: center;">
 		<span style="font-size: 12px; margin-bottom: 10px;">Block -D, Holding - 10/1, Aziz Mansion, Shafipur, Kaliakair, Gazipur. </span> <br>
 		<span style="font-size: 12px; margin-top: 5px;"> 01776-606262 , 01687-625565 </span> 
 	</div>  
 	<div style="text-align: right; margin-top: 40px">
 		<span style="border-top: 1px solid; font-size: 12px;">Authorised Signature</span>
 	</div>  

 </div>
