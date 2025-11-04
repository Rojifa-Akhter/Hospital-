<style>
    :root {
        --accent: #2563eb;
        --muted: #6b7280;
        --bg: #f8fafc
    }

    body {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        background: var(--bg);
        color: #111827;
        padding: 20px
    }

    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
        padding: 18px
    }

    h1 {
        font-size: 20px;
        margin: 0 0 12px
    }

    .toolbar {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-bottom: 12px
    }

    .search {
        flex: 1
    }

    input[type=text] {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #e5e7eb;
        border-radius: 6px
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px
    }

    thead th {
        background: #f3f4f6;
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid #e6eef8;
        color: var(--muted)
    }

    tbody td {
        padding: 10px;
        border-bottom: 1px solid #f3f4f6
    }

    .provider-name {
        font-weight: 600
    }

    .meal-toggle {
        display: inline-flex;
        gap: 6px;
        align-items: center
    }

    .toggle {
        position: relative;
        width: 44px;
        height: 26px;
        border-radius: 999px;
        background: #e6eef8;
        cursor: pointer
    }

    .toggle input {
        display: none
    }

    .knob {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.12);
        transition: all .18s
    }

    .toggle.on {
        background: var(--accent)
    }

    .toggle.on .knob {
        left: 21px
    }

    .small {
        font-size: 12px;
        color: var(--muted)
    }

    .actions {
        display: flex;
        gap: 8px
    }

    .btn {
        padding: 8px 12px;
        border-radius: 6px;
        border: 0;
        cursor: pointer
    }

    .btn.primary {
        background: var(--accent);
        color: #fff
    }

    .btn.ghost {
        background: transparent;
        border: 1px solid #e6eef8
    }

    .text-center {
        text-align: center
    }

    .select-all {
        font-size: 12px;
        color: var(--muted);
        cursor: pointer
    }

    @media (max-width:820px) {

        table thead th:nth-child(3),
        table tbody td:nth-child(3) {
            display: none
        }
    }
</style>
<main id="page-content">
    <div class="card">
        <h1>Hospital Cafeteria – IPD Patient Meal Assignment</h1>
        <p class="small">
            প্রতিটি ভর্তি রোগীর জন্য নির্দিষ্ট খাবার (Breakfast, Lunch, Snacks, Dinner) সিলেক্ট করুন।
            হেডার থেকে সব রোগীর জন্য একসাথে অফ/অন করাও সম্ভব।
        </p>
{{-- {{ route('ipd.patient_meals.save') }} --}}
        <form method="POST" action="">
            @csrf

            <div class="toolbar">
                <div class="search">
                    <input type="text" id="q" placeholder="Search patient name or admission no..." oninput="filterProviders()">
                </div>
                <div class="actions">
                    <button type="button" class="btn ghost" onclick="selectAllVisible(false)">Clear</button>
                    <button type="submit" class="btn primary">Save Assignments</button>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width:35%">Patient</th>
                        <th class="text-center">Breakfast <span class="select-all" onclick="toggleColumn('breakfast')">(All)</span></th>
                        <th class="text-center">Lunch <span class="select-all" onclick="toggleColumn('lunch')">(All)</span></th>
                        <th class="text-center">Snacks <span class="select-all" onclick="toggleColumn('snacks')">(All)</span></th>
                        <th class="text-center">Dinner <span class="select-all" onclick="toggleColumn('dinner')">(All)</span></th>
                        <th class="text-center">Notes</th>
                    </tr>
                </thead>
                <tbody id="providers-list">
                    {{-- @forelse ($patients as $patient)
                        <tr data-name="{{ strtolower($patient->name) }}" data-code="{{ strtolower($patient->admission_no ?? '') }}">
                            <td>
                                <div class="provider-name">{{ $patient->name }}</div>
                                <div class="small">
                                    Admission: {{ $patient->admission_no }} | Bed: {{ $patient->bed_no ?? '-' }} | Ward: {{ $patient->ward ?? '-' }}
                                </div>
                                <input type="hidden" name="patients[]" value="{{ $patient->id }}">
                            </td>

                            @foreach (['breakfast','lunch','snacks','dinner'] as $meal)
                                <td class="text-center">
                                    <label class="meal-toggle">
                                        <div class="toggle {{ in_array($meal, $patient->meals ?? []) ? 'on' : '' }}" onclick="toggle(this)">
                                            <input type="checkbox"
                                                   name="meals[{{ $patient->id }}][{{ $meal }}]"
                                                   {{ in_array($meal, $patient->meals ?? []) ? 'checked' : '' }}>
                                            <div class="knob"></div>
                                        </div>
                                    </label>
                                </td>
                            @endforeach

                            <td class="text-center">
                                <input type="text" name="notes[{{ $patient->id }}]" placeholder="Special diet note" class="note-input">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center small">No admitted patients found.</td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </form>
    </div>
</main>

<script>
    // Toggle single switch UI and corresponding checkbox
    function toggle(el) {
        const input = el.querySelector('input[type=checkbox]');
        if (!input) return;
        input.checked = !input.checked;
        el.classList.toggle('on', input.checked);
    }


    // Filter providers by name/code
    function filterProviders() {
        const q = document.getElementById('q').value.toLowerCase();
        const rows = document.querySelectorAll('#providers-list tr');
        rows.forEach(r => {
            const name = r.getAttribute('data-name') || '';
            const code = r.getAttribute('data-code') || '';
            if (name.includes(q) || code.includes(q) || q === '') {
                r.style.display = 'table-row';
            } else r.style.display = 'none';
        })
    }


    // Toggle a whole column (visible rows only)
    function toggleColumn(meal) {
        const rows = document.querySelectorAll('#providers-list tr');
        // determine if any visible row has this meal unchecked -> then we will check all; otherwise uncheck all
        let shouldCheck = false;
        for (const r of rows) {
            if (r.style.display === 'none') continue;
            const cb = r.querySelector(`input[name^="meals"][name$="[${meal}]"]`);
            if (cb && !cb.checked) {
                shouldCheck = true;
                break;
            }
        }
        rows.forEach(r => {
            if (r.style.display === 'none') return;
            const cb = r.querySelector(`input[name^="meals"][name$="[${meal}]"]`);
            const toggleEl = r.querySelector(`.toggle`);
            if (cb) {
                cb.checked = shouldCheck;
                if (toggleEl) toggleEl.classList.toggle('on', shouldCheck);
            }
        })
    }


    // Select or clear all visible (helper used by Clear button)
    function selectAllVisible(value) {
        const rows = document.querySelectorAll('#providers-list tr');
        rows.forEach(r => {
            if (r.style.display === 'none') return;
            r.querySelectorAll('input[type=checkbox]').forEach(cb => {
                cb.checked = value;
                const t = cb.closest('.toggle');
                if (t) t.classList.toggle('on', value);
            });
        })
    }


    // Initialize toggles from checkboxes on page load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toggle').forEach(t => {
            const cb = t.querySelector('input[type=checkbox]');
            if (cb && cb.checked) t.classList.add('on');
        });
    });
</script>
