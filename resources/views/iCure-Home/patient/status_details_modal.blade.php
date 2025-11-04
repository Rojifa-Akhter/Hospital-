 <!-- Row -->
 <div class="row">
     <div class="col-xl-12 col-lg-12 col-md-12">
         <div class="border-0">
             <div class="tab-content">
                 <div class="tab-pane active" id="tab-7">
                     <div class="card">

                         <div class="card-header">
                             Order Status
                         </div>

                         <div class="card-body border-top">
                             <div class="row">
                                 <div class="">
                                     <div class="table-responsive">
                                         <table class="table card-table table-vcenter text-nowrap border">
                                             <thead class="bg-dark text-light">
                                                 <tr>
                                                     <td class="text-center">Order No.</td>
                                                     <td class="text-center">Customer Name</td>
                                                     <td class="text-center">Mobile No.</td>
                                                     <td class="text-center">Assign Name</td>
                                                     <td class="text-center">Order Date </td>
                                                     <td class="text-center">Delivery Date</td>
                                                     <td class="text-center">Total Amount</td>
                                                     <td class="text-center">Status</td>
                                                 </tr>
                                             </thead>
                                             <tbody id="">
                                                 @if (!empty($ecomerce_status))
                                                     @foreach ($ecomerce_status as $row)
                                                         <tr>
                                                             <td class="a">
                                                                 {{ !empty($row->order_no) ? $row->order_no : '' }}
                                                             </td>
                                                             <td>{{ !empty($row->customer_name) ? $row->customer_name : '' }}
                                                             </td>
                                                             <td>{{ !empty($row->phone_mobile) ? $row->phone_mobile : '' }}
                                                             </td>
                                                             <td>{{ !empty($row->assign_name) ? $row->assign_name : '' }}
                                                             </td>
                                                             <td>{{ !empty($row->order_date) ? $row->order_date : '' }}
                                                             </td>
                                                             <td>{{ !empty($row->delivery_date) ? $row->delivery_date : '' }}
                                                             </td>
                                                             <td>{{ !empty($row->tot_amount) ? $row->tot_amount : '' }}
                                                             </td>
                                                             <td>
                                                                 {{-- {{ !empty($row->delivery_status) ? $row->delivery_status : '' }} --}}

                                                                 @if ($row->delivery_status == 0)
                                                                     <span class="badge badge-warning">Assigned</span>
                                                                 @elseif ($row->delivery_status == 1)
                                                                     <span class="badge badge-primary">Picked</span>
                                                                 @elseif ($row->delivery_status == 2)
                                                                     <span class="badge badge-success">Delivered</span>
                                                                 @elseif ($row->delivery_status == 3)
                                                                     <span class="badge badge-danger">Cancel</span>

                                                                 @endif
                                                             </td>
                                                         </tr>
                                                     @endforeach
                                                 @endif


                                             </tbody>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                         </div>


                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <div class="modal-footer">
     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
     <!-- <button type="button" class="btn btn-success">Sign In</button> -->
 </div>
