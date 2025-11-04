@include('admin.components.pdf_header')
<div style="width: 100%;">
	<div style=" text-align:center; margin-bottom:5px; margin-top:15px  " >
		<span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Referral Policy Configaration</span>
	</div>
    <br>
    <div style=" text-align:center;  width:100%; margin-bottom:5px" class="mb-2">


      <span class="report-date"><strong> Date: {{ date("d/m/Y", strtotime($data->au_entry_at)) }}</strong> </br> <strong> Day: {{date('D', strtotime($data->au_entry_at))}} </strong>


      </span>
  </div>
</div>
</header>
<main>
  <div class="admission_body">
    <table width="100%; border-collapse: collapse;">
        <tr>
            <td colspan="4" style="margin-top: 10px;">
                <strong>Referral Policy</strong> <br>
                <strong>--------------------</strong>
            </td>
        </tr>

        <tr>
            <td>Policy Code </td>
            <td>: {{!empty($data-> referralpolicy_code)?$data-> referralpolicy_code : ''}}</td>
            <td></td>
            <td></td>
            <td>Policy Name</td>
            <td>: {{!empty($data-> policy_name)?$data-> policy_name : ''}}</td>
            
        </tr>
        <tr>
            <td>Applied to</td>
            <td>: {{!empty($data-> applied_to_ref_doctor_ind)?'Referral' : ''}}({{!empty($data-> r_def_ref)?$data-> r_def_ref : ''}}%) , {{!empty($data-> applied_to_agent_ind)?'Agent' : ''}} ({{!empty($data-> r_def_ref)?$data-> r_def_ref : ''}}%) , {{!empty($data-> applied_to_seconnd_ref_ind)?'2nd Referral' : ''}} ({{!empty($data-> r_agent_ref)?$data-> r_agent_ref : ''}}%) </td>
            

        </tr>
        <br>
        <br>

        <tr>
            <td colspan="4" style="margin-top: 10px;">
                <strong>Item Type</strong> <br>
                <strong>----------------</strong>
            </td>
            <td colspan="4" style="margin-top: 10px;">
                <strong>Service Unit</strong> <br>
                <strong>-------------------</strong>
            </td>
        </tr>
        <tr>
          

            <td> {{!empty($data-> item_type)?$data-> item_type : ''}}  ({{!empty($data-> item_percent)?$data-> item_percent : ''}} %)</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{!empty($data-> serviceunit_name)?$data-> serviceunit_name : ''}}  ({{!empty($data-> su_comission)?$data-> su_comission : ''}} %)</td>
            
        </tr>
        
        <br>
        <br>
        
        <tr >
            <td colspan="6" class="text-center" style="margin-top: 10px; text-align: center;">
                <strong>Item Policy</strong> <br>
                <strong>--------------------</strong>
            </td>
        </tr>
        <tr>
            <td>Item Code</td>
            <td>Name</td>
            <td>Rate</td>
            <td>Comission(%)</td>
            <td>Amount</td>
            <td>Exclude</td>
        </tr>
        <tr>
            
            <td> {{!empty($data-> item_no_fk)?$data-> item_no_fk : ''}} </td>
            <td> {{!empty($data-> item_name)?$data-> item_name : ''}} </td>
            <td> {{!empty($data-> sales_price)?$data-> sales_price : ''}} Tk</td>
            <td> {{!empty($data-> commission_percent)?$data-> commission_percent : ''}} </td>
            <td> {{!empty($data-> commission_taka)?$data-> commission_taka : ''}} Tk</td>
            <td> {{!empty($data-> exclude_ind)?'Yes' : ''}} </td>
        </tr>
        

    </table>
</div>
</main>


@include('admin.components.pdf_footer')