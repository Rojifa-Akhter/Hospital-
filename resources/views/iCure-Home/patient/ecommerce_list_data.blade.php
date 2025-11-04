@if (!empty($ecom_order))
    <?php $i = 0; ?>
    @foreach ($ecom_order as $list)

        <?php $string1 = $list[0];
        $str_arr1 = explode('_', $string1);
        ?>


        <?php $string2 = $str_arr1[6];
        $str_arr2 = explode('_', $string2);
        ?>

        <?php $string3 = $str_arr1[7];
        $str_arr3 = explode('_', $string3);
        ?>

        <div id="accordion_{{ $i }}">


            <div class="card">
                <div class="card-header p-0" id="headingOne">
                    <button class="btn btn-block p-0" data-toggle="collapse"
                        data-target="#collapseOne_{{ $i }}" aria-expanded="true"
                        aria-controls="collapseOne_{{ $i }}">
                        <div class="chat-widget-header d-flex p-5 align-items-center">
                            <div class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                <div class="mt-1">
                                    <h6 class="font-weight-semibold mb-0">{{ $loop->iteration }}</h6>
                                </div>
                            </div>

                            <div class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                <div class="mt-1">
                                    <h6 class="font-weight-semibold mb-0">Order No</h6>
                                    <small>{{ !empty($str_arr1[0]) ? $str_arr1[0] : '' }}</small>
                                </div>
                            </div>

                            <div class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                <div class="mt-1">
                                    <h6 class="font-weight-semibold mb-0">Order Date</h6>
                                    <small>{{ !empty($str_arr1[4]) ? date('d-m-Y', strtotime($str_arr1[2])) : '' }}</small>
                                </div>
                            </div>

                            <div class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                <div class="mt-1">
                                    <h6 class="font-weight-semibold mb-0">Product Ordered</h6>
                                    @foreach ($orders_row as $order_key => $order_data)
                                        @if ($order_key == $str_arr1[0])
                                            <small><?php print_r($order_data); ?></small>
                                        @endif
                                    @endforeach

                                </div>
                            </div>

                            <div class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                <div class="mt-1">
                                    <h6 class="font-weight-semibold mb-0">Total Price</h6>
                                    <small>{{ !empty($str_arr1[1]) ? $str_arr1[1] : '' }}</small>
                                </div>
                            </div>

                            <div class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                <div class="mt-1">
                                    <h6 class="font-weight-semibold mb-0">Expected Deli. Date</h6>

                                    <small>{{ !empty($str_arr1[4]) ? date('d-m-Y', strtotime($str_arr1[4])) : '' }}
                                    </small>
                                </div>
                            </div>

                            <div class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                <div class="mt-1">
                                    <h6 class="font-weight-semibold mb-0">Deli. Man Name</h6>
                                    <small><?php print_r($str_arr1[3]); ?></small>
                                </div>
                            </div>


                            <div class="ml-auto">

                                {{-- <div class="d-flex">
                                    <a class="option-dots new-list2" target="_blank"
                                        data-original-title="Electronic medical report"><i
                                            class="fa fa-file-medical-alt"></i></a>
                                </div> --}}


                                <span class="accordion_arrow">
                                    <button class="btn btn-outline-primary mr-4" data-toggle="modal"
                                        data-target="#ecommerce_status" value=""
                                        onclick="ecomStatusDetails(<?php print_r($str_arr1[0]); ?>)"
                                        data_id="<?php print_r($str_arr1[0]); ?>"><i class="fa fa-eye"></i>
                                        Status</button>
                                </span>
                            </div>
                        </div>
                    </button>
                </div>

                <div id="collapseOne_{{ $i }}" class="collapse" aria-labelledby="headingOne"
                    data-parent="#accordion_{{ $i }}">
                    <div class="card-body">
                        <div class="row">
                            @foreach ($list as $data)
                                <?php $string = $data;
                                $str_arr = explode('_', $string);
                                ?>


                                {{-- {{dd($str_arr[8])}} --}}

                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="chat-widget-header d-flex p-5 align-items-center">
                                                <div
                                                    class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                    <div class="mt-1">
                                                        <h6 class="font-weight-semibold mb-0">
                                                            {{ $loop->iteration }}</h6>
                                                    </div>
                                                </div>

                                                <img src="{{ asset('images/product-01.jpg') }}" alt="img"
                                                    class="img-fluid w-8">

                                                <div
                                                    class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                    <div class="mt-1">
                                                        <h6 class="font-weight-semibold mb-0">Product
                                                            Name</h6>
                                                        {{-- @foreach ($str_arr2 as $product)
                                                            <small></small>
                                                        @endforeach --}}
                                                        <small>{{ !empty($str_arr[8]) ? $str_arr[8] : '' }}</small>

                                                    </div>
                                                </div>

                                                <div
                                                    class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                    <div class="mt-1">
                                                        <h6 class="font-weight-semibold mb-0">Quantity
                                                        </h6>
                                                        {{-- @foreach ($str_arr3 as $quantity)
                                                            <small></small>
                                                        @endforeach --}}
                                                        <small></small>

                                                    </div>
                                                </div>


                                                <div
                                                    class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                    <div class="mt-1">
                                                        <h6 class="font-weight-semibold mb-0">Order Date
                                                        </h6>
                                                        <small><?php print_r(date('d-m-Y', strtotime($str_arr1[2]))); ?></small>
                                                    </div>
                                                </div>


                                                <div
                                                    class="font-weight-bold pr-4 mr-4 border-right d-none d-sm-none d-md-none d-lg-block">
                                                    <div class="mt-1">
                                                        <h6 class="font-weight-semibold mb-0">Product
                                                            Price</h6>
                                                        <small><?php print_r(number_format($str_arr1[5], 2)); ?></small>
                                                    </div>
                                                </div>

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
        <?php $i++; ?>


    @endforeach

    {{-- {{ $ecommerce_data->links() }} --}}
@else
    <h3 class="text-center">No Data Found</h3>
@endif
