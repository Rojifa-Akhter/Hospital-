
@if($receive_type == 'chalan')
    @include('admin.store.chalan_receive_search_list')
@endif

@if($receive_type == 'item')
    @include('admin.store.item_receive_search_list')
@endif

