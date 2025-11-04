@if(!empty($policy_arr))
<h6 class="mt-4"><strong>POLICY :: </strong>{{ $policy_name }}</h6>
<div class="">
	<ul class="list-group list-group-flush">		
		@foreach($policy_arr as $policy_item => $policy_row)

		<li class="list-group-item mb-1">
			<h6><strong>ITEM :: {{ $policy_item }}</strong></h6>

			<div class="table-responsive">
				<table class="table border-bottom">
					<thead>
						<tr>
							<th scope="col" class="w-25">Doctor</th>
							<th scope="col" class="text-center">Commission (%)</th>
							<th scope="col" class="text-center">SMS</th>
							<th scope="col" class="text-center"> 1st Ref. Commission (%) </th>
							<th scope="col" class="text-center"> SMS </th>
							<th scope="col" class="text-center"> 2nd Ref. Commission (%) </th>
							<th scope="col" class="text-center"> SMS </th>
							<th scope="col" class="text-center"> Agent Commission (%) </th>
							<th scope="col" class="text-center">SMS </th>
						</tr>
					</thead>
					<tbody>
						@foreach($policy_row as $policy)
						@php
						$policy_data = explode("_", $policy);
						@endphp
						<tr>
							<td scope="col">{{ $policy_data[0] }}</td>
							<td scope="col" class="text-center bg-light">{{ $policy_data[1] }}</td>
							<td scope="col" class="text-center border-right">{{ ($policy_data[2]>0)?'Yes':'No' }}</td>
							<td scope="col" class="text-center bg-light"> {{ $policy_data[3] }} </td>
							<td scope="col" class="text-center border-right"> {{ ($policy_data[4]>0)?'Yes':'No' }} </td>
							<td scope="col" class="text-center bg-light"> {{ $policy_data[5] }} </td>
							<td scope="col" class="text-center border-right"> {{ ($policy_data[6]>0)?'Yes':'No' }} </td>
							<td scope="col" class="text-center bg-light"> {{ $policy_data[7] }} </td>
							<td scope="col" class="text-center"> {{ ($policy_data[8]>0)?'Yes':'No' }} </td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

		</li>

		@endforeach
	</ul>
</div>
@endif