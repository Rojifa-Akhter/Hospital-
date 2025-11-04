<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
        <section class="indent_worklist">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-7">
                                <h5 class="mt-2 mb-0">Pop-Up</h5>
                                <small>UHL/ Pop-Up</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn_box text-center mt-5">
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Click Here</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!--modal -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
             <div class="modal-body px-0">
               <div class="hospital__window__popup">
                   <div class="container-fluid">
                     <div class="row">
                         <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="inner__box">
                                <h2>Hospital</h2>
                                    <div class="inputGroup">
                                    <input id="radio1" name="radio" type="radio" />
                                    <label for="radio1">UHL-DHK</label>
                                    </div>
                                    <div class="inputGroup">
                                    <input id="radio2" name="radio" type="radio" />
                                    <label for="radio2">UHL-CTG</label>
                                </div>
                            </div>
                         </div>
                         <div class="col-lg-6 col-md-12 col-sm-12">
                             <div class="inner__box">
                                 <h2>Store/Service Point</h2>
                                     <div class="inputGroup">
                                     <input id="radio3" name="radioOne" type="radio" />
                                     <label for="radio3">UHL Store</label>
                                     </div>
                                     <div class="inputGroup">
                                     <input id="radio4" name="radioOne" type="radio" />
                                     <label for="radio4">UHL Medicine</label>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                       <div class="col-md-12">
                           <div class="p-2 text-right">
                             <button type="button" class="btn btn-primary uhl_save_btn">Save</button>
                           </div>
                       </div>
                   </div>
                   </div>

               </div>
             </div>

            </div>
          </div>
        </div>
  </main>


