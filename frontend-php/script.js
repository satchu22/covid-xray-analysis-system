const imageInput = document.getElementById("xray_image");
const preview = document.getElementById("preview");
const fileMeta = document.getElementById("fileMeta");

if (imageInput) {
    imageInput.addEventListener("change", (event) => {
        const file = event.target.files[0];

        if (!file) {
            preview.src = "assets/placeholder.svg";
            fileMeta.textContent = "No image selected yet.";
            return;
        }

        const allowedTypes = ["image/jpeg", "image/png", "image/webp", "image/jpg"];
        if (!allowedTypes.includes(file.type)) {
            alert("Please upload a valid image file: JPG, JPEG, PNG, or WEBP.");
            imageInput.value = "";
            preview.src = "assets/placeholder.svg";
            fileMeta.textContent = "No image selected yet.";
            return;
        }

        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
        fileMeta.textContent = `${file.name} • ${sizeMb} MB`;

        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}
