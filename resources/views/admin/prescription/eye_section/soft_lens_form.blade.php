<div class="card soft_lens_prescription display-none">
    <div class="card-header"><h5>Soft Contact lens</h5></div>
    <div class="card-body mt-2">
        <div class="row ">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h5>Details</h5></div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <label for="lens_supplier" class="col-sm-5 col-form-label col-form-label-sm">Supplier</label>
                                    <div class="col-sm-7">
                                        <select class="form-control font_size_12 m-auto" id="lens_supplier" name="lens_supplier" >
                                            <option value="">Select Supplier</option>
                                            <option value="1">Supplier-1</option>
                                            <option value="2">Supplier-2</option>
                                        </select>
                                    </div>

                                    <label for="lens_brand" class="col-sm-5 col-form-label col-form-label-sm">Brand</label>
                                    <div class="col-sm-7">
                                        <select class="form-control font_size_12 m-auto" id="lens_brand" name="lens_brand" >
                                            <option value="">Select Brand</option>
                                            @if($best_brands)
                                                @foreach ($best_brands as $key => $record)
                                                    <option value="{{ $key }}">{{ $record }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="soft_tint_lens_color" class="col-sm-5 col-form-label col-form-label-sm">Tint Color</label>
                                    <div class="col-sm-7">
                                        <select class="form-control font_size_12 m-auto" id="soft_tint_lens_color" name="soft_tint_lens_color" >
                                            <option value="">Select Tint Color</option>
                                            @if($tinks)
                                                @foreach ($tinks as $key => $record)
                                                    <option value="{{ $key }}">{{ $record }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <label for="soft_lens_status" class="col-sm-5 col-form-label col-form-label-sm">Status</label>
                                    <div class="col-sm-7">
                                        <select class="form-control font_size_12 m-auto" id="soft_lens_status" name="soft_lens_status" >
                                            <option value="">Select Status</option>
                                            @if($status)
                                                @foreach ($status as $key => $record)
                                                    <option value="{{ $key }}">{{ $record }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <label for="soft_lens_cl_solution" class="col-sm-5 col-form-label col-form-label-sm">CL Solution</label>
                                    <div class="col-sm-7">
                                        <select class="form-control font_size_12 m-auto" id="soft_lens_cl_solution" name="soft_lens_cl_solution" >
                                            <option value="">Select Solution</option>
                                            @if($clsol)
                                                @foreach ($clsol as $key => $record)
                                                    <option value="{{ $key }}">{{ $record }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>


                                </div>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-md btn-block btn-secondary">Circle</button>
                                <button class="btn btn-md btn-block btn-secondary">Rectangle</button>
                                <button class="btn btn-md btn-block btn-secondary">Pencil</button>
                                <button class="btn btn-md btn-block btn-secondary">Clear</button>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="hard_lens_color_preview" class="col-sm-12 col-form-label col-form-label-sm">Color</label>
                                    <div class="col-sm-12">
                                        <select class="form-control font_size_12 m-auto" id="hard_lens_color_preview" name="hard_lens_color_preview" >
                                            <option value="">Color</option>
                                            @if($colors)
                                                @foreach ($colors as $key => $record)
                                                    <option value="{{ $key }}">{{ $record }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>


                                    <label for="hard_lens_width" class="col-sm-12 col-form-label col-form-label-sm">Width</label>
                                    <div class="col-sm-12">
                                        <select class="form-control font_size_12 m-auto" id="hard_lens_width" name="hard_lens_width" >
                                            <option value="">Width</option>
                                            @if($width)
                                                @foreach ($width as $key => $record)
                                                    <option value="{{ $key }}">{{ $record }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="lens_preview">
                                    <div class="all_lens">
                                        <div class="lens_left"></div>
                                        <div class="lens_right"></div>
                                    </div>
                                </div>

                                <div class="od_os_lens">
                                    <div class="od_lens">OD</div>
                                    <div class="os_lens">OS</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center">Sphere</td>
                                            <td class="text-center">Cylinder</td>
                                            <td class="text-center">Axis</td>
                                            <td class="text-center">Add</td>
                                            <td class="text-center">BC</td>
                                            <td class="text-center">Diameter</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">OD</td>
                                            <td class="text-center">
                                                <select class="form-control font_size_12 m-auto" id="soft_sphere_od" name="soft_sphere_od" >
                                                    <option value="">+1.00</option>
                                                    @if($spheres)
                                                        @foreach ($spheres as $key => $record)
                                                            <option value="{{ $key }}">{{ $record }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control font_size_12 m-auto" id="soft_cylinder_od" name="soft_cylinder_od" >
                                                    <option value="">+0.75</option>
                                                    @if($cylinders)
                                                        @foreach ($cylinders as $key => $record)
                                                            <option value="{{ $key }}">{{ $record }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control font_size_12 m-auto" id="soft_axis_od" name="soft_axis_od" >
                                                    <option value="">002</option>
                                                    @if($axis)
                                                        @foreach ($axis as $key => $record)
                                                            <option value="{{ $key }}">{{ $record }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control font_size_12 m-auto" id="soft_add_od" name="soft_add_od" >
                                                    <option value="">+0.50</option>
                                                    @if($adds)
                                                        @foreach ($adds as $key => $record)
                                                            <option value="{{ $key }}">{{ $record }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_bc_od" name="soft_bc_od" value=""  placeholder="0.00"
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_diameter_od" name="soft_diameter_od" value=""  placeholder="0.00">
                                            </td>

                                        </tr>


                                        <tr>
                                            <td class="text-center">OS</td>
                                            <td class="text-center">
                                                <select class="form-control font_size_12 m-auto" id="soft_sphere_os" name="soft_sphere_os" >
                                                    <option value="">+1.00</option>
                                                    @if($spheres)
                                                        @foreach ($spheres as $key => $record)
                                                            <option value="{{ $key }}">{{ $record }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control font_size_12 m-auto" id="soft_cylinder_os" name="soft_cylinder_os" >
                                                    <option value="">+0.75</option>
                                                    @if($cylinders)
                                                        @foreach ($cylinders as $key => $record)
                                                            <option value="{{ $key }}">{{ $record }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control font_size_12 m-auto" id="soft_axis_os" name="soft_axis_os" >
                                                    <option value="">002</option>
                                                    @if($axis)
                                                        @foreach ($axis as $key => $record)
                                                            <option value="{{ $key }}">{{ $record }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="form-control font_size_12 m-auto" id="soft_add_os" name="soft_add_os" >
                                                    <option value="">+0.50</option>
                                                    @if($adds)
                                                        @foreach ($adds as $key => $record)
                                                            <option value="{{ $key }}">{{ $record }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_bc_os" name="soft_bc_os" value=""  placeholder="0.00">
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_diameter_os" name="soft_diameter_os" value=""  placeholder="0.00">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="text-center"></td>
                                            <td class="text-center">K1</td>
                                            <td class="text-center">k2</td>
                                            <td class="text-center">K Axis</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">OD</td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_k1_od" name="soft_k1_od" value=""  placeholder="0.00" >
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_k2_od" name="soft_k2_od" value=""  placeholder="0.00" >
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_kaxis_od" name="soft_kaxis_od" value=""  placeholder="0.00" >
                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="text-center">OS</td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_k1_os" name="soft_k1_os" value=""  placeholder="0.00" >
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_k2_os" name="soft_k2_os" value=""  placeholder="0.00" >
                                            </td>
                                            <td class="text-center">
                                                <input type="text" class="form-control form-control-sm" id="soft_kaxis_os" name="soft_kaxis_os" value=""  placeholder="0.00" >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Notes
                        <div class="form-check form-check-inline ml-5">
                            <input class="form-check-input prescription_type" type="checkbox" name="soft_notes_print" value="2" id="soft_notes_print">
                            <label class="form-check-label" for="soft_notes_print">Print</label>
                        </div></h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="dispensing_notes" class="col-sm-5 col-form-label col-form-label-sm">Dispensing Notes</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" id="dispensing_notes" name="dispensing_notes" value="" placeholder="Dispensing Notes">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fitting_notes" class="col-sm-5 col-form-label col-form-label-sm">Fitting Notes</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" id="fitting_notes" name="fitting_notes" value="" placeholder="Fitting Notes">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="od_lens_notes" class="col-sm-5 col-form-label col-form-label-sm">OD Lense Notes</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" id="od_lens_notes" name="od_lens_notes" value="" placeholder="OD Lense Notes">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="os_lens_notes" class="col-sm-5 col-form-label col-form-label-sm">OS Lense Notes</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" id="os_lens_notes" name="os_lens_notes" value="" placeholder="OS Lense Notes">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cl_rx_notes" class="col-sm-5 col-form-label col-form-label-sm">CL Rx Notes</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" id="cl_rx_notes" name="cl_rx_notes" value="" placeholder="CL Rx Notes">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="biomicroscopy_notes" class="col-sm-5 col-form-label col-form-label-sm">Biomicroscopy</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" id="biomicroscopy_notes" name="biomicroscopy_notes" value="" placeholder="Biomicroscopy">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lid_notes" class="col-sm-5 col-form-label col-form-label-sm">Lid</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" id="lid_notes" name="lid_notes" value="" placeholder="Lid">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cornea" class="col-sm-5 col-form-label col-form-label-sm">Cornea</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" id="cornea" name="cornea" value="" placeholder="Cornea">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tears" class="col-sm-5 col-form-label col-form-label-sm">Tears</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" id="tears" name="tears" value="" placeholder="Cornea">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>