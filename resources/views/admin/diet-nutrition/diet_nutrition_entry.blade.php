<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<!-- Bootstrap 5 CSS -->
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    /* Container Layout */
    .container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 20px;
        gap: 20px;
    }

    /* Top Panel (Patient and Plan Information) */
    .top-panel {
        width: 25%;
        background-color: #fff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .top-panel .patient-info,
    .top-panel .diet-plan-info {
        margin-bottom: 20px;
    }

    h2,
    h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .tag {
        background-color: #f2a9b1;
        padding: 5px 10px;
        border-radius: 15px;
        margin-right: 5px;
    }

    /* Center Panel (Meal Customization) */
    .center-panel {
        width: 45%;
        background-color: #fff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .meal-tabs {
        display: flex;
        gap: 10px;
    }

    .meal-tab {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    .meal-tab:hover {
        background-color: #45a049;
    }

    #meal-title {
        font-size: 20px;
        margin-bottom: 10px;
    }

    #food-search {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
    }

    #food-list {
        max-height: 200px;
        overflow-y: auto;
    }

    #meal-items-list {
        list-style-type: none;
        padding: 0;
    }

    textarea {
        width: 100%;
        height: 80px;
        padding: 8px;
    }

    /* Side Panel (Nutrient Summary) */
    .side-panel {
        width: 25%;
        background-color: #fff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .nutrient {
        margin-bottom: 20px;
    }

    .nutrient label {
        font-weight: bold;
    }

    .bar {
        background-color: #e0e0e0;
        width: 100%;
        height: 20px;
        border-radius: 10px;
    }

    .filled {
        height: 100%;
        background-color: #4CAF50;
        border-radius: 10px;
    }

    .filled.yellow {
        background-color: #FFEB3B;
    }

    /* Bootstrap Button Style */
    button {
        width: 100%;
        padding: 10px;
        background-color: #FF9800;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #FB8C00;
    }

    /* Meal item styles */
    #meal-items-morning,
    #meal-items-noon,
    #meal-items-afternoon,
    #meal-items-evening,
    #meal-items-night {
        list-style-type: none;
        padding: 0;
    }

    #meal-items-morning li,
    #meal-items-noon li {
        background-color: #f0f8ff;
    }

    #meal-items-afternoon li,
    #meal-items-evening li {
        background-color: #f0fff0;
    }

    #meal-items-night li {
        background-color: #f5f5f5;
    }

    .food-item button {
        margin-left: 10px;
    }

    .meal-section {
        margin-bottom: 20px;
    }

    .meal-section h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .meal-item {
        background-color: #f0f8ff;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .no-food-item {
        background-color: #ffeb3b;
        padding: 10px;
        border-radius: 5px;
        color: #555;
    }

    .food-item button {
        margin-left: 10px;
    }

    .food-item span {
        font-weight: bold;
    }

    /* Styling for the food list container */
    #food-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        /* Add some spacing between the food items */
    }

    /* Each food item should be aligned horizontally with a little margin */
    .food-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    /* Hover effect on the food item */
    .food-item:hover {
        background-color: #f1f1f1;
    }

    /* Styling the food name */
    .food-item span {
        font-size: 16px;
        font-weight: 600;
    }

    /* Styling for the "Add" button with fixed width */
    .food-item button {
        width: 100px;
        /* Fixed width for the button */
        padding: 5px 10px;
        /* Adjust padding for consistency */
        font-size: 14px;
        /* Slightly smaller font */
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    /* Hover effect for the button */
    .food-item button:hover {
        background-color: #218838;
    }

    /* Button focus outline */
    .food-item button:focus {
        outline: none;
    }

    /* Table Styling */
    table.meal-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
    }

    table.meal-table th,
    table.meal-table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    table.meal-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    table.meal-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table.meal-table tr:hover {
        background-color: #f1f1f1;
    }

    /* Meal Items List Styling */
    .meal-items-list {
        color: #555;
        font-size: 16px;
    }

    .meal-items-list li {
        list-style-type: none;
        padding: 5px 0;
    }

    /* Style for no food listed */
    .meal-items-list.no-food {
        font-style: italic;
        color: #888;
    }

    /* Optional: Add a little padding to each meal time cell */
    table.meal-table td {
        vertical-align: middle;
    }

    /* Styling the food items list and meal slot table */
    .meal-slot-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
    }

    .meal-slot-table th,
    .meal-slot-table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .meal-slot-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .meal-slot-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .meal-slot-table tr:hover {
        background-color: #f1f1f1;
    }

    /* Styling for food item divs in food list */
    .food-item {
        margin: 5px 0;
        display: flex;
        justify-content: space-between;
    }

    .food-item button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .food-item button:hover {
        background-color: #218838;
    }
</style>


<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Diet Plan Creation</h5>
                    <small>Diet Plan Creation</small>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Diet Plan Creation</h5>
            </div>
            <div class="card-body mt-2">
                <div class="row" style="margin-left: 0px !important;">

                    <!-- Patient and Plan Information Section -->
                    <div class="top-panel">
                        <div class="patient-info">
                            <h2>Patient Information</h2>
                            <p><strong>Name:</strong>
                                {{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</p>
                            <p><strong>Age/Gender:</strong> {{ isset($patient_info->age) ? $patient_info->age : '' }},
                                {{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</p>
                            <p><strong>Medical Conditions:</strong>
                                <select class="form-select">
                                    <option>Diabetes</option>
                                    <option>Hypertension</option>
                                    <option>None</option>
                                </select>
                            </p>
                            <p><strong>Dietary Restrictions:</strong>
                                <span class="tag">Gluten-Free</span>
                                <span class="tag">Nut Allergy</span>
                            </p>
                        </div>
                        <div class="diet-plan-info">
                            <h3>Select or Create Diet Plan</h3>
                            <select id="diet-plan-select" class="form-select" onchange="dietChartWiseFood(this)">
                                <option value="" disabled selected>Select Diet Chart</option> <!-- Default disabled option -->
                                {{-- {{ isset($diet_check) && $diet_check == $data->diet_chart_no_pk ? 'selected' : '' }} --}}
                                @foreach ($chartData as $data)
                                    <option value="{{ $data->diet_chart_no_pk }}" 
                                       >
                                        {{ !empty($data->diet_chart_name) ? ucfirst($data->diet_chart_name) : '' }}
                                    </option>
                                @endforeach
                                
                                <option value="Create New Plan">Create New Plan</option> <!-- Option for creating a new plan -->
                            </select>
                            
                            
                            

                            <p class="mt-3" id="chartName" style="display: none;">
                                <strong>Diet Chart Name:</strong>
                                <input type="text" id="chart_name" class="form-control"
                                    placeholder="Enter Chart Name">
                            </p>
                            <h3 class="mt-3">Select Diet Type</h3>
                            <select id="diet-type-select" class="form-select mt-3">
                                @if (!empty($diet_type))
                                    <option>Select Diet Type</option>
                                    @foreach ($diet_type as $pk => $row)
                                        <option value="{{ $row }}">
                                            {{ $row }}</option>
                                    @endforeach
                                @endif

                                {{-- <option>Select Diet Type</option>
                                <option value="solid">Solid</option>
                                <option value="liquid">Liquid</option>
                                <option value="ng">NG</option> --}}
                            </select>
                            <br>
                            <p><strong>Start Date:</strong> <input type="date" id="start-date" class="form-control">
                            </p>
                            <p><strong>End Date:</strong> <input type="date" id="end-date" class="form-control"></p>
                            <p><strong>Price:</strong>
                                <input type="text" id="Price" class="form-control" placeholder="Enter price">
                            </p>

                            <!-- Hidden fields for patient_no_fk and admission_no_fk -->
                            <input type="hidden" id="patient-no" value="{{ $patient_id }}">
                            <input type="hidden" id="admission-no" value="{{ $admission_id }}">
                            {{-- <button onclick="saveDietPlan()">Save Plan</button>
                            <!-- Add this button inside your meal-table-container -->
                            <button id="save-meal-btn" class="btn btn-primary">Save Meal Composition</button> --}}
                            <!-- Save Button for both diet and meal plan -->
                            <button id="save-diet-and-meal-btn" class="btn btn-primary">Save Diet and Meal Plan</button>

                        </div>
                    </div>
                    <!-- Meal Customization Section -->
                    <div class="center-panel">
                        <div class="meal-tabs" id="meal-tabs" style="display: none;">
                            @foreach ($dietType1 as $type)
                                <button class="meal-tab btn btn-success"
                                    onclick="showMeal({{ json_encode($type->diet_name) }}, {{ json_encode($type->diet_no_pk) }})">
                                    {{ ucfirst($type->diet_name) }}
                                </button>
                            @endforeach
                        </div>

                        <div class="meal-customization">
                            <h3 id="meal-title"></h3>

                            <div id="food-list">
                                <!-- Food items will be displayed here dynamically -->
                            </div>

                            <!-- Current Meal Composition Lists -->

                            @if (!empty($formatted_meal_type))
                                <h4>Current Meal Composition</h4>
                                <table class="meal-table" id="mealTable" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Meal Time</th>
                                            <th class="text-center">Meal Items</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($formatted_meal_type as $meal)
                                            <tr id="meal-items-{{ $meal->diet_name }}">
                                                <td><strong>{{ ucwords(str_replace('_', ' ', $meal->diet_name)) }}</strong>
                                                </td>
                                                <td class="meal-items-list">
                                                    <!-- Meal items will be dynamically injected here -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif


                            <!-- Table to display meal slots -->
                            <!-- Meal Table to display food items by meal slots -->
                            <div id="meal-table-container" style="display: none;">
                                <h3 id="meal-title"></h3>
                                <table class="table meal-slot-table">
                                    <thead>
                                        <tr>
                                            <th>Meal Time</th>
                                            <th>Food Items</th>
                                        </tr>
                                    </thead>
                                    <tbody id="meal-slots-body">
                                        <!-- Meal slot rows will be dynamically populated here -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Food List for Add Buttons -->
                            <div id="food-list">
                                <!-- Food items will be dynamically injected here -->
                            </div>


                            <textarea class="form-control" placeholder="Meal Notes (e.g., Avoid adding salt)" name="remarks" id="remarks"></textarea>
                        </div>
                    </div>

                    <!-- Nutrient Summary Section -->
                    <div class="side-panel">
                        <div class="nutrient">
                            <label for="calories">Calories</label>
                            <div class="bar">
                                <div id="calories" class="filled" style="width: 70%"></div>
                            </div>
                        </div>

                        <div class="nutrient">
                            <label for="protein">Protein</label>
                            <div class="bar">
                                <div id="protein" class="filled" style="width: 60%"></div>
                            </div>
                        </div>

                        <div class="nutrient">
                            <label for="carbs">Carbs</label>
                            <div class="bar">
                                <div id="carbs" class="filled yellow" style="width: 40%"></div>
                            </div>
                        </div>

                        <div class="nutrient">
                            <label for="fat">Fat</label>
                            <div class="bar">
                                <div id="fat" class="filled" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include JS for select2 and Bootstrap -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
   var dietCheckValue = @json($diet_check ?? null);

   console.log(dietCheckValue)
    $(document).ready(function() {
        

        // Initialize Select2
        $('select').select2();

        // Add "sidebar-collapse" class to the body
        $("body").addClass("sidebar-collapse");

        // Save Diet Plan
        function saveDietPlan() {
            const patientNo = $("#patient-no").val();
            const admissionNo = $("#admission-no").val();
            const startDate = $("#start-date").val();
            const endDate = $("#end-date").val();
            const price = $("#Price").val();
            const type = $("#diet-type-select").val();
            const chart_name = $("#chart_name").val();

            $.ajax({
                url: "{{ route('dietNutrition.diet-plan-save') }}",
                method: 'POST',
                data: {
                    patient_no: patientNo,
                    admission_no: admissionNo,
                    start_date: startDate,
                    end_date: endDate,
                    type: type,
                    chart_name: chart_name,
                    price: price
                },
                success: function(response) {
                    alert('Diet Plan Saved Successfully!');
                },
                error: function(error) {
                    alert('Error saving plan');
                }
            });
        }

        // Diet Chart Wise Food
        function dietChartWiseFood(selectElement) {
            
            const dietChartId = $(selectElement).val();
            console.log(dietChartId)
            if (dietChartId === "Create New Plan") {
                $('#meal-tabs, #chartName').removeAttr('style');
                $('#mealTable').hide();
                return;
            }

            $('#meal-tabs, #chartName').hide();
            $('#meal-table-container').hide();

            $.ajax({
                url: "{{ route('dietNutrition.item-food-data') }}",
                method: 'POST',
                data: {
                    diet_chart_id: dietChartId
                },
                success: function(data) {
                    $("#mealTable").show();
                    console.log(data);

                    $('#Price').val(data.price);

                    const meals = {
                        morning: data.morning,
                        noon: data.noon,
                        afternoon: data.afternoon,
                        night: data.night,
                        bed_time: data.bed_time,
                        morning_snacks: data.morning_snacks
                    };

                    console.log(meals);

                    $.each(meals, function(mealTime, meal) {
                        const mealTimeFormatted = mealTime.replace('_', ' ').toUpperCase();
                        const mealRow = $(`#meal-items-${mealTime}`);

                        if (mealRow.length) {
                            const mealCell = mealRow.find('.meal-items-list');

                            mealCell.empty();

                            if (meal) {
                                const foodItems = meal.split(',').map(item => item.trim());
                                mealCell.text(foodItems.join(', '));
                            } else {
                                mealCell.text('');
                            }
                        }
                    });
                },
                error: function(error) {
                    console.error("Error fetching food items:", error);
                    alert('Failed to load food items');
                }
            });
        }

        // Show selected meal type and fetch food items
        function showMeal(mealType, mealId) {
            $("#meal-title").text(mealType.charAt(0).toUpperCase() + mealType.slice(1));
            loadFoodItems(mealType, mealId);
            $("#meal-table-container").show();
        }

        // Load available food items for the selected meal
        function loadFoodItems(mealType, mealId) {
            const foodList = $("#food-list");
            foodList.empty();

            console.log("Diet Name:", mealType);
            console.log("Diet ID:", mealId);

            $.ajax({
                url: "{{ route('dietNutrition.item-data') }}",
                type: 'POST',
                data: {
                    mealId: mealId
                },
                beforeSend: function() {
                    blockUI(); // Optional: Show loading spinner or overlay
                },
                success: function(data) {
                    console.log(data);

                    if (Array.isArray(data)) {
                        const fragment = $(document.createDocumentFragment());

                        $.each(data, function(index, food) {
                            const foodName = food.food_name;

                            if (foodName) {
                                const foodDiv = $("<div>").addClass("food-item");

                                const foodNameSpan = $("<span>").text(foodName);
                                const addButton = $("<button>").text("Add").click(
                                    function() {
                                        addFoodToMeal(mealType, foodName);
                                    });

                                foodDiv.append(foodNameSpan).append(addButton);
                                fragment.append(foodDiv);
                            }
                        });

                        foodList.append(fragment);
                    } else {
                        console.error("Expected an array, but received:", data);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error loading food items:", textStatus, errorThrown);
                },
                complete: function() {
                    $.unblockUI(); // Optional: Hide loading spinner or overlay
                }
            });
        }

        // Add food item to the corresponding meal slot
        function addFoodToMeal(mealType, foodName) {
            const tableBody = $("#meal-slots-body");

            let existingSlotRow = tableBody.children().filter(function() {
                return $(this).find('td.slot').text() === mealType;
            }).first();

            if (existingSlotRow.length === 0) {
                existingSlotRow = $("<tr>");

                const slotCell = $("<td>").addClass("slot").text(mealType.charAt(0).toUpperCase() + mealType
                    .slice(1));
                const foodCell = $("<td>");

                existingSlotRow.append(slotCell).append(foodCell);
                tableBody.append(existingSlotRow);
            }

            const foodCell = existingSlotRow.find('td:nth-child(2)');
            const currentFoodItems = foodCell.text().trim();

            if (currentFoodItems) {
                foodCell.text(currentFoodItems + ", " + foodName);
            } else {
                foodCell.text(foodName);
            }
        }

        // Save the selected meal data
        function saveDietAndMealPlan() {
            // Collect Diet Plan Data
            const patientNo = $("#patient-no").val();
            const admissionNo = $("#admission-no").val();
            const startDate = $("#start-date").val();
            const endDate = $("#end-date").val();
            const price = $("#Price").val();
            const type = $("#diet-type-select").val();
            const chart_name = $("#chart_name").val();
            const remarks = $("#remarks").val();
            const diet_plan_id = $("#diet-plan-select").val();

            // Collect Meal Composition Data
            const mealData = [];

            // Collect all the meal items in meal slots
            $("#meal-slots-body tr").each(function() {
                const mealType = $(this).find("td.slot").text();
                const foodItems = $(this).find("td:nth-child(2)").text().split(",").map(item => item
                    .trim());

                if (mealType && foodItems.length > 0) {
                    mealData.push({
                        meal_type: mealType,
                        food_items: foodItems
                    });
                }
            });

            // Prepare data to send
            const data = {
                patient_no: patientNo,
                admission_no: admissionNo,
                start_date: startDate,
                end_date: endDate,
                type: type,
                chart_name: chart_name,
                price: price,
                remarks: remarks,
                diet_plan_id: diet_plan_id,
                meal_data: mealData // Attach meal data
            };

            // Send data via AJAX
            $.ajax({
                url: "{{ route('dietNutrition.diet-plan-save') }}", // Adjust the route as needed
                method: 'POST',
                data: data,
                success: function(response) {
                    alert('Diet Plan and Meal Composition Saved Successfully!');
                    window.location.href = "{{ route('dietNutrition.index') }}";
                },
                error: function(error) {
                    console.error("Error saving diet plan and meal composition:", error);
                    alert('Error saving diet plan and meal composition');
                }
            });
        }

        // Attach the save function to the button
        $("#save-diet-and-meal-btn").click(
            saveDietAndMealPlan); // Assuming you have a button with id="save-diet-and-meal-btn"


        // Remove food item from the corresponding meal slot
        function removeFoodFromMeal(mealType, foodName) {
            const tableBody = $("#meal-slots-body");

            const slotRow = tableBody.children().filter(function() {
                return $(this).find('td.slot').text() === mealType;
            }).first();

            if (slotRow.length) {
                const foodCell = slotRow.find('td:nth-child(2)');
                const foodItems = foodCell.text().split(", ");
                const updatedFoodItems = foodItems.filter(item => item.trim() !== foodName);

                foodCell.text(updatedFoodItems.join(", "));

                if (foodCell.text().trim() === '') {
                    slotRow.remove();
                }
            }
        }

        // Assign functions to global object for use
        window.saveDietPlan = saveDietPlan;
        window.dietChartWiseFood = dietChartWiseFood;
        window.showMeal = showMeal;
    });

    $(document).ready(function() {
        // Check if dietCheckValue is not null
        console.log("Diet Check Value: ", dietCheckValue);  // Check if the PHP variable is passed correctly

        // Check if a diet chart exists
        if (dietCheckValue) {
            // Set the value of the select dropdown and trigger the change event
            $('#diet-plan-select').val(dietCheckValue);


            // Trigger the change event explicitly after setting the value
            $('#diet-plan-select').change();  // Trigger the change event manually

            // Optionally, call the dietChartWiseFood function (you can define this function as needed)
            dietChartWiseFood($('#diet-plan-select')[0]);
        }
    });

    
</script>
