



@if (!empty($cate_wise_product))
    @foreach ($cate_wise_product as $cat => $items)

        @if (!empty($items))
            @foreach ($items as $product)
                @php
                    $imagePath = isset($product->item_photo) ? 'images/uploads/item_images/' . $product->item_photo : 'mcare/images/napa.jpg';
                @endphp

                <div class="col-md-4" style="cursor: pointer">

                    <a target="_blank" class="proBtn"
                        href="{{ env('ECOMMERCE') . '/product-details/' . $product->item_no_pk . '/' . $product->item_name }}">
                        <div class="card text-center">
                          <div class="product_img_box">
                            @if (File::exists($imagePath))
                                <img class="w-100" src="{{ asset($imagePath) }}" alt="..." />
                            @else
                                <img class="w-100" src="{{ asset('mcare/images/ads2.jpg') }}" alt="..." />
                            @endif
                        </div>

                            <div class="product-body product_title">
                                <h6 class="product-name">{{ $product->item_name }}</h6>
                                {{-- <p class="company-name"> $product->item_name </p> --}}
                                {{-- <p class="discount"><span
                    class="discount-off">&#2547;&nbsp;1600</span>&nbsp;&nbsp;<span
                    class="price-off">6% OFF</span></p> --}}
                                <span class="price">&#2547;&nbsp;
                                    {{ $product->sales_price }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    @endforeach
@endif
