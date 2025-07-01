<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Your Documents</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .preview-img {
      max-height: 150px;
      margin-top: 10px;
      border: 1px solid #ccc;
      padding: 5px;
      border-radius: 5px;
    }
    .remove-btn {
      margin-top: 10px;
      display: inline-block;
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-3">Upload Required Documents</h3>

  <p class="text-muted">
    To complete your enrollment, please upload the following documents. Make sure the images are clear and all information is visible. Accepted formats: JPG, PNG, PDF.
  </p>

  <form id="uploadForm">
    <!-- Proof of Identity -->
    <div class="mb-3">
      <label for="identityProof" class="form-label">Proof of Identity</label>
      <input class="form-control" type="file" id="identityProof" accept=".jpg,.jpeg,.png,.pdf" required>
      <div class="form-text">Example: ID card, driver's license, passport.</div>
      <div id="identityPreview" class="mt-2"></div>
    </div>

    <!-- Proof of Benefit -->
    <div class="mb-3">
      <label for="benefitProof" class="form-label">Proof of Benefit</label>
      <input class="form-control" type="file" id="benefitProof" accept=".jpg,.jpeg,.png,.pdf" required>
      <div class="form-text">Example: eligibility letter or benefit notice.</div>
      <div id="benefitPreview" class="mt-2"></div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <div id="response" class="mt-3 text-success"></div>
  </form>
</div>

<script>
let identityBase64 = '';
let benefitBase64 = '';

function previewAndConvert(inputId, previewId, setBase64Callback, clearBase64Callback) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);

  input.addEventListener('change', function () {
    const file = input.files[0];
    if (!file) return;

    // Clear previous preview
    preview.innerHTML = '';

    const reader = new FileReader();
    reader.onload = function (e) {
      const base64String = e.target.result;
      setBase64Callback(base64String);

      let element;
      if (file.type.startsWith('image/')) {
        element = document.createElement('img');
        element.classList.add('preview-img');
        element.src = base64String;
      } else if (file.type === 'application/pdf') {
        element = document.createElement('p');
        element.textContent = `PDF selected: ${file.name}`;
      } else {
        element = document.createElement('p');
        element.textContent = 'Unsupported file type.';
      }

      const removeBtn = document.createElement('button');
      removeBtn.textContent = 'Remove';
      removeBtn.className = 'btn btn-sm btn-danger remove-btn';
      removeBtn.type = 'button';
      removeBtn.onclick = () => {
        input.value = '';
        preview.innerHTML = '';
        clearBase64Callback();
      };

      preview.appendChild(element);
      preview.appendChild(removeBtn);
    };

    reader.readAsDataURL(file);
  });
}

// Setup listeners for both file inputs
previewAndConvert(
  'identityProof',
  'identityPreview',
  b64 => identityBase64 = b64,
  () => identityBase64 = ''
);
previewAndConvert(
  'benefitProof',
  'benefitPreview',
  b64 => benefitBase64 = b64,
  () => benefitBase64 = ''
);

// Handle form submission
document.getElementById('uploadForm').addEventListener('submit', function (e) {
  e.preventDefault();

  if (!identityBase64 || !benefitBase64) {
    alert("Please upload both required documents.");
    return;
  }

  const data = {
    identity_proof: identityBase64,
    benefit_proof: benefitBase64,
  };

  fetch('upload.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(response => {
    document.getElementById('response').textContent = response.message || 'Upload successful!';
  })
  .catch(err => {
    console.error(err);
    document.getElementById('response').textContent = 'Upload failed. Please try again.';
  });
});
</script>

</body>
</html>
