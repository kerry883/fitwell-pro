document.addEventListener('DOMContentLoaded', function() {
    const profilePhotoInput = document.getElementById('profile_photo');
    const profilePhotoPreview = document.getElementById('profile-photo-preview');

    if (profilePhotoInput) {
        profilePhotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    e.target.value = '';
                    return;
                }

                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file');
                    e.target.value = '';
                    return;
                }

                // Preview the image
                const reader = new FileReader();
                reader.onload = function(event) {
                    if (profilePhotoPreview) {
                        profilePhotoPreview.src = event.target.result;
                    }
                };
                reader.readAsDataURL(file);

                // Upload the image via AJAX
                uploadProfilePhoto(file);
            }
        });
    }

    function uploadProfilePhoto(file) {
        const formData = new FormData();
        formData.append('profile_photo', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        fetch('/trainer/profile/photo', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                document.querySelector('.container-fluid').prepend(alertDiv);

                // Auto dismiss after 3 seconds
                setTimeout(() => {
                    alertDiv.classList.remove('show');
                    setTimeout(() => alertDiv.remove(), 150);
                }, 3000);
            } else {
                alert('Error uploading photo. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error uploading photo. Please try again.');
        });
    }
});
