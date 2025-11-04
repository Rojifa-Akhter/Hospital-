<style>
    /* Table header */
    #packageTable thead {
        background-color: #0d6efd;  /* Bootstrap primary blue */
        color: white;
        font-weight: 600;
        font-size: 1rem;
        border-bottom: 3px solid #0a58ca;
    }

    /* Main package row */
    #packageTable tbody tr.main-row {
        background-color: #e9f0ff;  /* হালকা নীল */
        font-weight: 700;
        font-size: 1.05rem;
        border-top: 2px solid #0a58ca;
        border-bottom: 2px solid #0a58ca;
    }

    /* Sub-item rows */
    #packageTable tbody tr.sub-row {
        background-color: #ffffff;
        transition: background-color 0.3s ease;
        font-size: 0.9rem;
    }

    /* Sub-item hover effect */
    #packageTable tbody tr.sub-row:hover {
        background-color: #f0f8ff;  /* হালকা ব্লু-শেড */
    }

    /* Table cells vertical alignment */
    #packageTable td,
    #packageTable th {
        vertical-align: middle;
        padding: 0.75rem 1rem;
    }

    /* Numbering cell for sub-row */
    #packageTable tbody tr.sub-row td:first-child {
        border: none;
        padding: 0;
        background: transparent;
    }

    /* Style badge button in action */
    .badge.favourit_list_item {
        font-size: 0.85rem;
        padding: 0.45em 0.85em;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .badge.favourit_list_item:hover {
        background-color: #198754; /* Bootstrap success darker */
        color: #fff;
    }

    /* Card styling */
    .card {
        border: 1px solid #dee2e6;
        box-shadow: 0 4px 8px rgb(13 110 253 / 0.1);
    }

    .card-body {
        background-color: #f8f9fa;
        padding: 1.5rem 2rem;
    }

    /* Responsive adjustment for smaller screens */
    @media (max-width: 575.98px) {
        #packageTable thead th, 
        #packageTable tbody td {
            padding: 0.4rem 0.5rem;
            font-size: 0.85rem;
        }

        .badge.favourit_list_item {
            font-size: 0.75rem;
            padding: 0.35em 0.6em;
        }
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm rounded-lg">
            <div class="card-body bg-light p-4">
                <table id="packageTable" class="table align-middle mb-0 table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th class="ps-3" colspan="2">Package Name</th>
                            <th style="width: 120px;">Price</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packageitems as $key => $pkg)
                            @php
                                $pakages_head = explode('~', $key);
                            @endphp
                            <tr class="main-row">
                                <td>{{ $loop->iteration }}</td>
                                <td class="ps-3" colspan="2">{{ $pakages_head[0] }}</td>
                                <td>{{ number_format($pakages_head[1], 2) }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-success text-white favourit_list_item"
                                        id="item_name" name="item_name" data-item-name="{{ $pakages_head[0] }}"
                                        data-alt-id="{{ $pakages_head[3] }}" data-alt-name="{{ $pakages_head[0] }}"
                                        data-id-value="{{ $pakages_head[3] }}" data-lookup-code="INVFIND"
                                        data-lookup-id="121" data-lookup-data-code="PKG"
                                        onclick="handlePackageAdd(this)">
                                        Add Package
                                    </span>
                                </td>
                            </tr>

                            @foreach (collect($pkg)->chunk(2) as $chunk)
                                <tr class="sub-row">
                                    <td></td>
                                    @foreach ($chunk as $data)
                                        <td style="text-align: right; width: 5%;">
                                            {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                                        </td>
                                        <td>{{ $data->item_name }}</td>
                                    @endforeach

                                    @if ($chunk->count() == 1)
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function handlePackageAdd(element) {
        // আপনার আগের ফাংশন
        prescriptionFunc.addItemsDataMostUseUhl(element);
        $(".exampleModal").modal("hide");

        // Bootstrap modal বন্ধ (jQuery বা vanilla JS দরকার নেই যদি data-bs-dismiss ব্যবহার করেন)
        // নিচের লাইন না দিলেও চলবে যদি <span> এ data-bs-dismiss="modal" ব্যবহার করেন

        // যদি আপনি ম্যানুয়ালি বন্ধ করতে চান, নিচের কোড লাগবে:
        /*
        let modal = bootstrap.Modal.getInstance(document.getElementById('yourModalId'));
        if (modal) {
            modal.hide();
        }
        */
    }
</script>
