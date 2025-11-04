
{{--@if(!empty($popup_data))--}}
{{--    @foreach($popup_data as $popup)--}}

        <div class="form-row">
            <div class="col-md-6">
                <div class="total-sales text-center bg-flat-color-7 py-3">
                    <p class="mb-2">Total Sale</p>
                    @if($type == '1')
                         @php
                            $investigation_data = isset($popup_sales_data['ROW01COL01T']) ? explode('_', $popup_sales_data['ROW01COL01T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($investigation_data[0]) ? $investigation_data[0] : '0.00' }}</h4>
                    @elseif($type == '2')
                         @php
                            $ipd_data = isset($popup_sales_data['ROW01COL02T']) ? explode('_', $popup_sales_data['ROW01COL02T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($ipd_data[0]) ? $ipd_data[0] : '0.00' }}</h4>
                    @elseif($type == '3')
                         @php
                            $pharmacy_data = isset($popup_sales_data['ROW01COL03T']) ? explode('_', $popup_sales_data['ROW01COL03T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($pharmacy_data[0]) ? $pharmacy_data[0] : '0.00' }}</h4>
                    @elseif($type == '4')
                         @php
                            $ambulance_data = isset($popup_sales_data['ROW01COL04T']) ? explode('_', $popup_sales_data['ROW01COL04T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($ambulance_data[0]) ? $ambulance_data[0] : '0.00' }}</h4>
                    @elseif($type == '5')
                         @php
                            $others_data = isset($popup_sales_data['ROW01COL05T']) ? explode('_', $popup_sales_data['ROW01COL05T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($others_data[0]) ? $others_data[0] : '0.00' }}</h4>
                    @endif

                </div>
            </div>
            <div class="col-md-6">
                <div class="total-collection text-center bg-flat-color-4 py-3">
                    <p class="mb-2">Total Collection</p>
                    @if($type == '1')
                        @php
                            $investigation_data = isset($popup_sales_data['ROW01COL01T']) ? explode('_', $popup_sales_data['ROW01COL01T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($investigation_data[0]) ? number_format($investigation_data[0],2) : 0 }}</h4>
                    @elseif($type == '2')
                        @php
                            $ipd_data = isset($popup_sales_data['ROW01COL02T']) ? explode('_', $popup_sales_data['ROW01COL02T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($ipd_data[0]) ? number_format($ipd_data[0],2) : 0 }}</h4>
                    @elseif($type == '3')
                        @php
                            $pharmacy_data = isset($popup_sales_data['ROW01COL03T']) ? explode('_', $popup_sales_data['ROW01COL03T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($pharmacy_data[0]) ? number_format($pharmacy_data[0],2) : 0 }}</h4>
                    @elseif($type == '4')
                        @php
                            $ambulance_data = isset($popup_sales_data['ROW01COL04T']) ? explode('_', $popup_sales_data['ROW01COL04T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($ambulance_data[0]) ? number_format($ambulance_data[0],2) : 0 }}</h4>
                    @elseif($type == '5')
                        @php
                            $others_data = isset($popup_sales_data['ROW01COL05T']) ? explode('_', $popup_sales_data['ROW01COL05T']) : [];
                        @endphp
                        <h4 class="mb-0">{{ isset($others_data[0]) ? number_format($others_data[0],2) : 0 }}</h4>
                    @endif
                </div>
            </div>
        </div>
{{--    @endforeach--}}
{{--@endif--}}
