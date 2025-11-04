<div class="card-header">
    <h5><i class="fa fa-shopping-cart"></i> Order List (
        <span id="date_id">
            @if (empty($date_from))
                {{ date('d/m/Y') }}
            @else
                {{ $date_from }}-{{ $date_to }}
            @endif
        </span>
        )
    </h5>
</div>

<div class="card-body">
    <div class="form-row">
        <div class="col-md-12">
            <div>
                @if (!empty($ecom_order))
                    <?php $i = 0; ?>
                    @foreach ($ecom_order as $list)

                        <?php $string1 = $list[0];
                        $str_arr1 = explode('_', $string1);
                        ?>

                        <div id="accordion_{{ $i }}">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <a class="btn btn-link btn-block text-left bg-primary accordion_title"
                                        data-toggle="collapse" data-target="#order_{{ $i }}"
                                        aria-expanded="true" aria-controls="collapseOne">

                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="order-data">

                                                <small>Order
                                                    Date:</small><strong><?php print_r($str_arr1[4]); ?></strong>
                                                <small>Customer
                                                    Name:</small><strong><?php print_r(ucfirst($str_arr1[7])); ?></strong>
                                                <small>Order
                                                    No:</small><strong><?php print_r($str_arr1[0]); ?> </strong>
                                                <small>Total Quantity Of Product
                                                    Ordered:</small><strong>
                                                    @foreach ($orders_row as $order_key => $order_data)
                                                        @if ($order_key == $str_arr1[0])
                                                            <small><?php print_r($order_data); ?></small>
                                                        @endif
                                                    @endforeach items
                                                </strong>

                                                <i class="fa fa-angle-down"></i>

                                            </div>

                                            <div class="order-status">
                                                <small>Status:</small><strong><span
                                                        class="badge badge-success">Delivered</span></strong>
                                                <small>Invoice:</small><strong><span
                                                        class="badge badge-primary">Print</span></strong>

                                            </div>
                                        </div>
                                    </a>
                                </div>


                                <div id="order_{{ $i }}" class="collapse" aria-labelledby="headingOne"
                                    data-parent="#accordion_{{ $i }}">
                                    <div class="row align-items-center">
                                        <div class="card-body pt-2">
                                            <div class="row pl-3">
                                                @foreach ($list as $data)
                                                    <?php $string = $data;
                                                    $str_arr = explode('_', $string);
                                                    ?>
                                                    <div class="col-xl-12">
                                                        <div class="chat-widget-header d-flex align-items-center">
                                                            <div
                                                                class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                                <div class="mt-1">
                                                                    <h6 class="font-weight-semibold mb-0">
                                                                        {{ $loop->iteration }}</h6>
                                                                </div>
                                                            </div>

                                                            <img src="{{ asset('images/product-01.jpg') }}" alt="img"
                                                                class="img-fluid w-8"
                                                                style="max-width: 8% !important;">

                                                            <div
                                                                class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                                <div class="mt-1">
                                                                    <h6 class="font-weight-semibold mb-0">
                                                                        Product Name</h6>
                                                                    <small><?php print_r($str_arr[1]); ?></small>
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                                <div class="mt-1">
                                                                    <h6 class="font-weight-semibold mb-0">
                                                                        Quantity</h6>
                                                                    <small><?php print_r($str_arr[5]); ?>
                                                                        items</small>
                                                                </div>
                                                            </div>


                                                            <div
                                                                class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                                <div class="mt-1">
                                                                    <h6 class="font-weight-semibold mb-0">
                                                                        Order Date</h6>
                                                                    <small><?php print_r($str_arr1[4]); ?>
                                                                        / {{ date('H:i:s') }}</small>
                                                                </div>
                                                            </div>


                                                            <div
                                                                class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                                <div class="mt-1">
                                                                    <h6 class="font-weight-semibold mb-0">
                                                                        Unit Price</h6>
                                                                    <small><?php print_r($str_arr[2]); ?> </small>
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                                <div class="mt-1">
                                                                    <h6 class="font-weight-semibold mb-0">
                                                                        Total Price</h6>
                                                                    <?php
                                                                    $total_price = $str_arr[2] * $str_arr[5];

                                                                    ?>
                                                                    <small><?php print_r($total_price); ?> </small>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php $i++; ?>
                    @endforeach

                @endif
            </div>
        </div>
    </div>
</div>
