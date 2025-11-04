<div class="container">
    <div class="row">
        <div class="col-10">
            @if(!empty($items))
                <h5 class="text-center mb-4">Item Name: {{ $items[0]->item_name }}</h5>
            @endif
        </div>
        <div class="col-2">
            <span class="pull-right float-right text-right">
                <form action="{{ route('reports.itemWiseStockDetailsDownload') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="id" value="{{ $items[0]->item_no_pk }}" />
                    <button type="submit" class="btn btn-md btn-md-globa btn-outline-primary bg-none" data-print="PDF"><i class="fa fa-file"></i>&nbsp;PDF</button>
                </form>
            </span>
        </div>
    </div>    
</div>

<table class="table table-striped table-bordered table-hover data_table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" style="width: 5%;">SL.</th>
            <th class="text-center" style="width: 20%;">Department Name</th>
            <th class="text-center" style="width: 10%;">Quantity</th>
        </tr>
    </thead>
    <tbody style="cursor: pointer;" id="tableBody">
        @if(!empty($items))
            @foreach($items as $item)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td style="text-align:left">{{ $item->department }}</td>
                    <td style="text-align:center">{{ $item->qty }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
