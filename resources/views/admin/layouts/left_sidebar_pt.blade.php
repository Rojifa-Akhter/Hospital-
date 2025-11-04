<aside class="main-sidebar" style="height: 98%; overflow: hidden;">
	<form action="#" method="get" class="sidebar-form">
		<div class="input-group">
			<input type="text" name="q" class="form-control" placeholder="Search...">
		</div>
	</form>
	<section class="sidebar mt-2 mb-5" style="overflow: auto; overflow-x: hidden; height: 90%; margin-right:-14px;">
		@php echo $menu_list ?? '' @endphp
	</section>
</aside>
