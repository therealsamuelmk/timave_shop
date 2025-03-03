document.getElementById('fileInput').addEventListener('change', function () {
    const videoInput = this;
    const videoPreview = document.getElementById('videoPreview');
  
    if (videoInput.files && videoInput.files[0]) {
      const reader = new FileReader();
  
      reader.onload = function (e) {
        videoPreview.src = e.target.result;
        videoPreview.style.display = 'block';
      };
  
      reader.readAsDataURL(videoInput.files[0]);
    }
  });
  