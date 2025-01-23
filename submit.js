// Drag-and-Drop Logic
const uploadArea = document.getElementById("uploadArea");

uploadArea.addEventListener("dragover", (event) => {
  event.preventDefault();
  uploadArea.classList.add("dragover");
});

uploadArea.addEventListener("dragleave", () => {
  uploadArea.classList.remove("dragover");
});

uploadArea.addEventListener("drop", (event) => {
  event.preventDefault();
  uploadArea.classList.remove("dragover");

  const files = event.dataTransfer.files;
  handleFiles(files);
});

function handleFiles(files) {
  Array.from(files).forEach((file) => {
    if (file.type.startsWith("image/")) {
      const reader = new FileReader();

      reader.onload = (event) => {
        saveImage(event.target.result);
        alert("Image uploaded and added to the gallery!");
      };

      reader.readAsDataURL(file);
    } else {
      alert("Only image files are allowed.");
    }
  });
}

function saveImage(base64Image) {
  // Get existing images from localStorage
  const existingImages =
    JSON.parse(localStorage.getItem("galleryImages")) || [];

  // Add new image to the list
  existingImages.push(base64Image);

  // Save back to localStorage
  localStorage.setItem("galleryImages", JSON.stringify(existingImages));
}
