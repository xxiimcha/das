document.addEventListener('DOMContentLoaded', function () {
    const amenitiesContainer = document.getElementById('amenities-container'); // The container for amenity rows
    const amenityTemplate = document.getElementById('amenity-template').content; // The template for new amenity rows
    let currentIconInput = null;

    // Add new amenity row
    amenitiesContainer.addEventListener('click', function (event) {
        if (event.target.closest('.add-amenity')) {
            // Clone the template and append it to the container
            const newAmenity = amenityTemplate.cloneNode(true);
            amenitiesContainer.appendChild(newAmenity);
        }
    });

    // Remove existing amenity row
    amenitiesContainer.addEventListener('click', function (event) {
        if (event.target.closest('.remove-amenity')) {
            const amenityRow = event.target.closest('.amenity-row');
            if (amenityRow) {
                amenityRow.remove();
            }
        }
    });

    // Handle "Select Icon" functionality
    amenitiesContainer.addEventListener('click', function (event) {
        if (event.target.closest('.select-icon')) {
            // Store the input field for the selected icon
            currentIconInput = event.target.closest('.select-icon').nextElementSibling;

            // Open the icon picker modal
            const modal = new bootstrap.Modal(document.getElementById('iconPickerModal'));
            modal.show();
        }
    });

    // Assign the selected icon from the modal
    const iconGrid = document.querySelector('#iconGrid');
    iconGrid.addEventListener('click', function (event) {
        if (event.target.classList.contains('icon-item')) {
            const icon = event.target.getAttribute('data-icon');
            if (currentIconInput) {
                currentIconInput.value = icon;
                const iconButton = currentIconInput.previousElementSibling;
                iconButton.innerHTML = `<i class="fa ${icon} text-primary"></i>`;
            }

            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('iconPickerModal'));
            modal.hide();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const icons = [
        'fa-wifi', 'fa-tv', 'fa-parking', 'fa-swimming-pool', 'fa-bed', 'fa-coffee', 'fa-shower',
        'fa-car', 'fa-utensils', 'fa-lightbulb', 'fa-couch'
    ];

    const iconGrid = document.querySelector('#iconGrid');
    const iconSearch = document.querySelector('#iconSearch');
    let currentInput = null;

    function loadIcons(filter = '') {
        iconGrid.innerHTML = '';
        icons.filter(icon => icon.includes(filter)).forEach(icon => {
            const iconElement = document.createElement('div');
            iconElement.className = 'col-2 text-center';
            iconElement.innerHTML = `<i class="fa ${icon} fa-2x icon-item" data-icon="${icon}" style="cursor: pointer;"></i>`;
            iconGrid.appendChild(iconElement);
        });
    }

    document.querySelectorAll('.select-icon').forEach(button => {
        button.addEventListener('click', function () {
            currentInput = this.nextElementSibling;
            const modal = new bootstrap.Modal(document.getElementById('iconPickerModal'));
            modal.show();
            loadIcons();
        });
    });

    iconGrid.addEventListener('click', function (e) {
        if (e.target.classList.contains('icon-item')) {
            const icon = e.target.getAttribute('data-icon');
            currentInput.value = icon;
            currentInput.previousElementSibling.innerHTML = `<i class="fa ${icon} fa-lg"></i>`;
            const modal = bootstrap.Modal.getInstance(document.getElementById('iconPickerModal'));
            modal.hide();
        }
    });

    iconSearch.addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        loadIcons(filter);
    });

    loadIcons();
});

document.addEventListener('DOMContentLoaded', function () {
    const dropzone = document.querySelector('#image-dropzone');
    const fileInput = document.querySelector('#dormImages');
    const previewContainer = document.querySelector('#preview-container');

    // Trigger file input on click
    dropzone.addEventListener('click', function () {
        fileInput.click();
    });

    // Highlight dropzone on dragover
    dropzone.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropzone.classList.add('bg-light');
    });

    // Remove highlight on dragleave
    dropzone.addEventListener('dragleave', function () {
        dropzone.classList.remove('bg-light');
    });

    // Handle file drop
    dropzone.addEventListener('drop', function (e) {
        e.preventDefault();
        dropzone.classList.remove('bg-light');
        const files = e.dataTransfer.files;
        handleFileUpload(files);
    });

    // Handle file selection through file input
    fileInput.addEventListener('change', function () {
        handleFileUpload(fileInput.files);
    });

    // Handle file upload and preview
    function handleFileUpload(files) {
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) {
                alert('Only image files are allowed!');
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = `
                    <div class="col-md-3 mb-3 position-relative">
                        <img src="${e.target.result}" class="img-thumbnail" alt="Preview">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image">&times;</button>
                    </div>`;
                previewContainer.insertAdjacentHTML('beforeend', preview);
            };
            reader.readAsDataURL(file);
        });
    }

    // Remove image from preview
    previewContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-image')) {
            e.target.closest('.col-md-3').remove();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#registrationForm');
    const loader = document.querySelector('#fullPageLoader');
    const thankYouMessage = document.querySelector('#thankYouMessage');
    const submitBtn = document.querySelector('#submitBtn');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form default submission

        // Show loader (form remains visible)
        loader.classList.remove('d-none');

        // Simulate form submission (replace this with an actual AJAX call if needed)
        setTimeout(() => {
            loader.classList.add('d-none'); // Hide loader
            form.classList.add('d-none'); // Hide form after loader finishes
            thankYouMessage.classList.remove('d-none'); // Show thank-you message
        }, 3000); // Simulate 3 seconds loading time
    });
});
