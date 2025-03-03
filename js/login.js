
function displayFileName(input) {
  var fileName = document.getElementById("fileName");
  fileName.textContent = input.files[0].name;

  var input = document.getElementById('fileInput');
  var image = document.getElementById('selectedImage');

  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          image.src = e.target.result;
      };

      reader.readAsDataURL(input.files[0]);
  }
}
