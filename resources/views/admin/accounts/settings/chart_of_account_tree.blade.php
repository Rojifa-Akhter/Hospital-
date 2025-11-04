<script src="{{ asset('js/jstree.min.js') }}"></script>
<div class="jstree">
    {!!$tree!!}                                         
</div>

<script>
    // html demo
    //const tree_url = "{{route('tree-view')}}"
    $('.jstree').jstree();
    // $('.jstree').load(tree_url, function(){
        
    // });
</script>