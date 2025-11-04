<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <section class="appoinment-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-12 mb-1">
                            <h5 class="mt-2 mb-0">Appointment Details</h5>
                            <small>Patient / Appointment Details</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('uhl.store-chat-appointment') }}" method="post" id="hos-chat-appointment">
                @csrf
                <div id="chatBox"></div>
                <input id="msg" placeholder="Write here your problem" />
                <button type="button" id="send">Send</button>

            </form>
        </div>
    </section>
</main>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>



<script>
    const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    let step = 'symptom';

    // document.getElementById('send').onclick = async () => {
    //     const msg = document.getElementById('msg').value;
    //     document.getElementById('chatBox').innerHTML += `<p>👩‍⚕️ Patient: ${msg}</p>`;
    //     const res = await fetch('uhl/store-chat-appointment', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify({
    //             message: msg,
    //             step
    //         })
    //     });
    //     const data = await res.json();
    //     step = data.step;
    //     document.getElementById('chatBox').innerHTML += `<p>🤖 Bot: ${data.message}</p>`;
    //     if (data.doctors)
    //         data.doctors.forEach(d => document.getElementById('chatBox').innerHTML += `<li>${d.name}</li>`);
    //     if (data.slots)
    //         data.slots.forEach(s => document.getElementById('chatBox').innerHTML +=
    //             `<li>${s.start_time} - ${s.end_time}</li>`);
    // };

      document.getElementById('send').onclick = async () => {
    const msgInput = document.getElementById('msg');
    const msg = msgInput.value;
    if (!msg.trim()) return;
    
    const chatBox = document.getElementById('chatBox');
    chatBox.innerHTML += `<p>👩‍⚕️ Patient: ${msg}</p>`;
    msgInput.value = '';

    const res = await fetch('{{ route("uhl.store-chat-appointment") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: msg, step })
    });

    const data = await res.json();
    step = data.step;

    chatBox.innerHTML += `<p>🤖 Bot: ${data.message}</p>`;

    if (data.doctors)
        data.doctors.forEach(d => chatBox.innerHTML += `<li>${d.full_name}</li>`);

    if (data.slots)
        data.slots.forEach(s => chatBox.innerHTML += `<li>${s.start_time} - ${s.end_time}</li>`);

    chatBox.scrollTop = chatBox.scrollHeight;
};
</script>
