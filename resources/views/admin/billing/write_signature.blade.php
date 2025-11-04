<!-- resources/views/patient-signature.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Patient Handwriting Capture</title>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.6/dist/signature_pad.umd.min.js"></script>
    <style>
        canvas {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <h2>Write Here</h2>
    <canvas id="signature-pad" width="500" height="300"></canvas><br>
    <button id="clear">Clear</button>
    <button id="save">Save</button>

    <form id="save-form" method="POST" action="#">
        @csrf
        <input type="hidden" name="image_data" id="image_data">
    </form>

    <script>
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas);
        const clearButton = document.getElementById('clear');
        const saveButton = document.getElementById('save');
        const form = document.getElementById('save-form');
        const imageDataInput = document.getElementById('image_data');

        clearButton.addEventListener('click', () => {
            signaturePad.clear();
        });

        saveButton.addEventListener('click', () => {
            if (signaturePad.isEmpty()) {
                alert("Please write something.");
                return;
            }

            const dataURL = signaturePad.toDataURL("image/jpeg");
            imageDataInput.value = dataURL;
            form.submit();
        });
    </script>
</body>
</html>
