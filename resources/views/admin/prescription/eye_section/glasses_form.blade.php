<div class="card glass_prescription">
    <div class="card-header"><h5>Glasses</h5></div>
    <div class="card-body mt-2">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="form-group row">
                    <label for="lens_type" class="col-sm-2 col-form-label col-form-label-sm">Lens type</label>
                    <div class="col-sm-4">
                        <select class="form-control font_size_12 m-auto" id="lens_type" name="lens_type">
                            <option value="">Select Lens type</option>
                            @if($lens_types)
                                @foreach ($lens_types as $key => $record)
                                    <option value="{{ $key }}">{{ $record }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <label for="lens_supplier" class="col-sm-2 col-form-label col-form-label-sm">Supplier</label>
                    <div class="col-sm-4">
                        <select class="form-control font_size_12 m-auto" id="lens_supplier" name="lens_supplier">
                            <option value="">Select Supplier</option>
                            <option value="1">Supplier 1</option>
                            <option value="2">Supplier 2</option>
                            <option value="3">Supplier 3</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="lens_material" class="col-sm-2 col-form-label col-form-label-sm">Lens Material</label>
                    <div class="col-sm-4">
                        <select class="form-control font_size_12 m-auto" id="lens_material" name="lens_material">
                            <option value="">Select Lens Material</option>
                            @if($lens_materials)
                                @foreach ($lens_materials as $key => $record)
                                    <option value="{{ $key }}">{{ $record }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <label for="lens_brand" class="col-sm-2 col-form-label col-form-label-sm">Brand</label>
                    <div class="col-sm-4">
                        <select class="form-control font_size_12 m-auto" id="lens_brand" name="lens_brand">
                            <option value="">Select Brand</option>
                            @if($best_brands)
                                @foreach ($best_brands as $key => $record)
                                    <option value="{{ $key }}">{{ $record }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group row">
                    <div class="col-md-6 text-center">
                        <label for="" class="col-form-label col-form-label-sm">DPD</label>
                    </div>
                    <div class="col-md-6 text-center">
                        <label for="" class="col-form-label col-form-label-sm">NPD</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gls_dpd_od" class="col-sm-2 col-form-label col-form-label-sm">OD :</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="gls_dpd_od" name="gls_dpd_od" value="" placeholder="OD">
                    </div>


                    <label for="gls_npd_od" class="col-sm-2 col-form-label col-form-label-sm">OD :</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="gls_npd_od" name="gls_npd_od" value="" placeholder="OD">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="gls_dpd_os" class="col-sm-2 col-form-label col-form-label-sm">OS :</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="gls_dpd_os" name="gls_dpd_os" value="" placeholder="OS">
                    </div>


                    <label for="gls_npd_os" class="col-sm-2 col-form-label col-form-label-sm">OS :</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="gls_npd_os" name="gls_npd_os" value="" placeholder="OS">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="gls_dpd_ou" class="col-sm-2 col-form-label col-form-label-sm">OU :</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="gls_dpd_ou" name="gls_dpd_ou" value="" placeholder="OU">
                    </div>


                    <label for="gls_npd_ou" class="col-sm-2 col-form-label col-form-label-sm">OU :</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm" id="gls_npd_ou" name="gls_npd_ou" value="" placeholder="OU">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="text-center"></td>
                            <td class="text-center">Sphere</td>
                            <td class="text-center">Cylinder</td>
                            <td class="text-center">Axis</td>
                            <td class="text-center">Add</td>
                            <td class="text-center">Prism 1</td>
                            <td class="text-center">Base 1</td>
                            <td class="text-center">Prism 2</td>
                            <td class="text-center">Base 2</td>
                        </tr>
                        <tr>
                            <td class="text-center">OD</td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_sphere_od" name="gls_sphere_od">
                                    <option value="">Select Sphere</option>
                                    @if($spheres)
                                        @foreach ($spheres as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_cylinder_od" name="gls_cylinder_od">
                                    <option value="">Select Cylinder</option>
                                    @if($cylinders)
                                        @foreach ($cylinders as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_axis_od" name="gls_axis_od">
                                    <option value="">Select Axis</option>
                                    @if($axis)
                                        @foreach ($axis as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_add_od" name="gls_add_od">
                                    <option value="">Select ADD</option>
                                    @if($adds)
                                        @foreach ($adds as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_prism1_od" name="gls_prism1_od">
                                    <option value="">Select Prism1</option>
                                    @if($prism1)
                                        @foreach ($prism1 as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="glassess_base1_od" name="glassess_base1_od">
                                    <option value="">Select Base1</option>
                                    @if($base1)
                                        @foreach ($base1 as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_prism2_od" name="gls_prism2_od">
                                    <option value="">Select Prism2</option>
                                    @if($prism2)
                                        @foreach ($prism2 as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="glassess_base2_od" name="glassess_base2_od" >
                                    <option value="">Select Base2</option>
                                    @if($base2)
                                        @foreach ($base2 as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center">OS</td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_sphere_os" name="gls_sphere_os">
                                    <option value="">Select Sphere</option>
                                    @if($spheres)
                                        @foreach ($spheres as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_cylinder_os" name="gls_cylinder_os">
                                    <option value="">Select Cylinder</option>
                                    @if($cylinders)
                                        @foreach ($cylinders as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_axis_os" name="gls_axis_os">
                                    <option value="">Select Axis</option>
                                    @if($axis)
                                        @foreach ($axis as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_add_os" name="gls_add_os">
                                    <option value="">Select ADD</option>
                                    @if($adds)
                                        @foreach ($adds as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_prism1_os" name="gls_prism1_os">
                                    <option value="">Select Prism1</option>
                                    @if($prism1)
                                        @foreach ($prism1 as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_base1_od" name="gls_base1_os">
                                    <option value="">Select Base1</option>
                                    @if($base1)
                                        @foreach ($base1 as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_prism2_os" name="gls_prism2_os">
                                    <option value="">Select Prism2</option>
                                    @if($prism2)
                                        @foreach ($prism2 as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control font_size_12 m-auto" id="gls_base2_od" name="gls_base2_os">
                                    <option value="">Select Base2</option>
                                    @if($base2)
                                        @foreach ($base2 as $key => $record)
                                            <option value="{{ $key }}">{{ $record }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="rx_note_internal" class="col-form-label col-form-label-sm">Rx Note Internal</label>
                    <textarea class="form-control height-100" id="rx_note_internal" name="rx_note_internal" value="" placeholder="" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>