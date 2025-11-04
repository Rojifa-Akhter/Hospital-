<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    /* Hide the default checkbox */
    input[type="checkbox"] {
        display: none !important;
    }

    /* Style the toggle button */
    .toggle-button {
        width: 138px;
        height: 40px;
        background-color: #eaeaea;
        border-radius: 20px;
        position: relative;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    /* Style the toggle button labels */
    .toggle-button-label {
        display: block;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50%;
        text-align: center;
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: bold;
        transition: all 0.3s;
    }

    /* Style the left label */
    .toggle-button-label.left {
        left: 5px;
        color: #fff;
        background-color: #2196f3;
        border-radius: 20px 0 0 20px;
    }

    /* Style the right label */
    .toggle-button-label.right {
        right: 5px;
        color: #555;
        background-color: #eaeaea;
        border-radius: 0 20px 20px 0;
    }

    /* Style the checked state */
    input[type="checkbox"]:checked + .toggle-button {
        background-color: #2196f3;
    }

    input[type="checkbox"]:checked + .toggle-button .toggle-button-label.left {
        color: #fff;
        background-color: #2196f3;
    }

    input[type="checkbox"]:checked + .toggle-button .toggle-button-label.right {
        color: #555;
        background-color: #fff;
    }


    .custom_area{    
    width: 97%;
    margin-left: auto;
    }

</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Edit Cost Center</h5>
                            <small>Accounts / Edit Cost Center</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">

                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="cost-center-name" class="col-sm-4 col-form-label">Cost Center Name<span class=text-danger>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cost-center-name" name="cost-center-name" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>
                               

                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="cost-center-code" class="col-sm-4 col-form-label">Cost Center Code<span class=text-danger>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cost-center-code" name="cost-center-code" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="department" class="col-sm-4 col-form-label">Department</label>
                                        <div class="col-sm-8">  
                                            <select class="form-control form-control-sm" id="department" name="department">
                        	          		    <option value="">select Department</option>
                        	          		    <option value=""></option>
                        	          		</select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group form-row mt-3">
                                        <label for="notes" class="col-sm-1 col-form-label">Status</label>
                                        <div class="col-sm-11">
                                            <label style="margin-left: 45px;">
                                                <input type="checkbox" />
                                                <div class="toggle-button">
                                                    <span class="toggle-button-label left">Active</span>
                                                    <span class="toggle-button-label right">Inactive</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="form-group">
                                <ul class="list-inline btn__box">
                                    <li class="list-inline-item">
                                        <button type="button" class="btn btn-secondary uhl_save_btn" id="">Save</button>
                                    </li>

                                    <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

 
           
        </div>
    </section>
</main>

<script>
    $("body").addClass("sidebar-collapse");
</script>
<script>
    const checkbox = document.querySelector('input[type="checkbox"]');
    const activeLabel = document.querySelector(".toggle-button-label.left");
    const inactiveLabel = document.querySelector(".toggle-button-label.right");
    activeLabel.textContent = "";
    inactiveLabel.textContent = "Inactive";

    checkbox.addEventListener("change", function () {
        if (this.checked) {
            activeLabel.textContent = "Active";
            inactiveLabel.textContent = "";
        } else {
            activeLabel.textContent = "";
            inactiveLabel.textContent = "Inactive";
        }
    });
</script>
