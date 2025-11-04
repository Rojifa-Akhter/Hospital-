<!--
for single page
<script>
  $(function () {
    AJAX.formSubmit({
      trigger: "#cashier_report_search",
      form: "#searchForm",
      target: "#cashier_report_data",
      url: "{{ url('report/cashier-wise-report-search') }}",
      method: "POST",
    });
  });
</script> 


<button type="button"
  class="ajax-submit-btn"
  data-form="#searchForm1"
  data-target="#resultBox"
  data-url="{{ url('some-endpoint') }}"
  data-method="POST">
  Submit
</button>


-->




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Search Example</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('js/helper.js') }}"></script>
</head>
<body>

  <h3>Search Form 1 (Manual)</h3>
  <form id="searchForm">
    @csrf
    <input type="text" name="cashier" required>
    <button type="button" id="cashier_report_search">Search</button>
  </form>
  <div id="cashier_report_data">Results...</div>

  <hr>

  <h3>Search Form 2 (AutoBind)</h3>
  <form id="searchForm2">
    @csrf
    <input type="text" name="product" required>
    <button type="button"
      class="ajax-submit-btn"
      data-form="#searchForm2"
      data-target="#product_report_data"
      data-url="{{ url('report/product-wise-report-search') }}"
      data-method="POST">
      Search Product
    </button>
  </form>
  <div id="product_report_data">Product Results...</div>

  <script>
    $(function () {
      // Manual usage (for unique forms)
      AJAX.formSubmit({
        trigger: "#cashier_report_search",
        form: "#searchForm",
        target: "#cashier_report_data",
        url: "{{ url('report/cashier-wise-report-search') }}",
        method: "POST"
      });

      // Auto usage (for multiple search buttons)
      AJAX.autoBind();
    });
  </script>

</body>
</html>
