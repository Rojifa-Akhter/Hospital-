<div class="card-body p-2">
	<div class="form-row">

		<select id="select_pos_items" class="form-control ">
			@if(!empty($category_arr))
			@foreach($category_arr["ITEMCAT"] as $cat)
			@php
			$cat_info = explode("_", $cat);
			@endphp
			<option>{{ $cat_info[1] }}</option>
			@endforeach
			@endif
		</select>


		@if(!empty($item_info))
		@foreach($item_info as $item)
		<div class="col-md-4" onclick="get_sub_category(this)" data-id="">
			<div class="product" title="{{ $item->item_code }}" data-id="">
				<div class="product-img">
					<img class="w-100" src="{{ asset('images/product-01.jpg') }}" alt="">
				</div>
				<div class="product-details text-center">
					<span>{{ $item->item_name }}</span> <br>
					<small>{{ $item->item_code }}</small>
				</div>
			</div>
		</div>
		@endforeach
		@else
		
		<div class="col-md-12" onclick="get_sub_category(this)" data-id="">
			<div class="product" title="" data-id="">
				<span>No Data Found</span>
			</div>
		</div>
		@endif


		
	</div>
</div>	