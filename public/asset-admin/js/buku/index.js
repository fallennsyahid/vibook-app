document.addEventListener('DOMContentLoaded', () => {


    const openModal = document.querySelector('#open-modal');
    const openModalEdit = document.querySelectorAll('.edit-buku');
    const modalCreate = document.querySelector('#create-new-buku');
    const closeModal = document.querySelectorAll('.close-modal');

    // Open create modal
    if (openModal) {
        openModal.addEventListener('click', (e) => {
            e.preventDefault();
            if (modalCreate) {
                modalCreate.classList.toggle('hidden');
                modalCreate.classList.toggle('flex');
            }
        });
    }

    // Open edit modal
    openModalEdit.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const modal = document.querySelector('#edit-buku-' + btn.dataset.id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    });

    // Close modals (buttons and overlays have class "close-modal")
    closeModal.forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (btn.type !== 'submit') e.preventDefault();

            const modalOpen = btn.closest('.fixed');
            if (modalOpen) {
                modalOpen.classList.remove('flex');
                modalOpen.classList.add('hidden');
                const form = modalOpen.querySelector('form');
                if (form) form.reset();
                modalOpen.querySelectorAll('.upload-group').forEach(group => {
                    const preview = group.querySelector('.preview');
                    const dropArea = group.querySelector('.drop-area');
                    if (preview) {
                        preview.classList.remove('flex');
                        preview.classList.add('hidden');
                    }
                    if (dropArea) dropArea.classList.remove('hidden');
                });
            } else if (modalCreate) {
                modalCreate.classList.remove('flex');
                modalCreate.classList.add('hidden');
                const form = modalCreate.querySelector('form');
                if (form) form.reset();
                modalCreate.querySelectorAll('.upload-group').forEach(group => {
                    const preview = group.querySelector('.preview');
                    const dropArea = group.querySelector('.drop-area');
                    if (preview) {
                        preview.classList.remove('flex');
                        preview.classList.add('hidden');
                    }
                    if (dropArea) dropArea.classList.remove('hidden');
                });
            }
        });
    });

    // File upload preview for each upload-group
    document.querySelectorAll('.upload-group').forEach(group => {
        const fileInput = group.querySelector('.file-input');
        const dropArea = group.querySelector('.drop-area');
        const preview = group.querySelector('.preview');
        const previewImage = preview ? preview.querySelector('.preview-image') : null;
        const fileName = preview ? preview.querySelector('.file-name') : null;
        const fileSize = preview ? preview.querySelector('.file-size') : null;
        const removeBtn = group.querySelector('.remove-file');

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        if (dropArea && fileInput) {
            // Click on drop area opens file selector
            dropArea.addEventListener('click', () => fileInput.click());

            // Drag & drop
            ;['dragenter', 'dragover'].forEach(evt => {
                dropArea.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropArea.classList.add('drag-over');
                });
            });
            ;['dragleave', 'drop'].forEach(evt => {
                dropArea.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropArea.classList.remove('drag-over');
                });
            });

            dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                const file = e.dataTransfer.files && e.dataTransfer.files[0];
                if (file) handleFile(file);
            });

            fileInput.addEventListener('change', (e) => {
                const file = e.target.files && e.target.files[0];
                if (file) handleFile(file);
            });
        }

        function handleFile(file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                if (previewImage) previewImage.src = e.target.result;
                if (fileName) fileName.textContent = file.name;
                if (fileSize) fileSize.textContent = formatFileSize(file.size);
                if (dropArea) dropArea.classList.add('hidden');
                if (preview) {
                    preview.classList.remove('hidden');
                    preview.classList.add('flex');
                }
            };
            reader.readAsDataURL(file);
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', () => {
                if (fileInput) fileInput.value = '';
                if (dropArea) dropArea.classList.remove('hidden');
                if (preview) {
                    preview.classList.remove('flex');
                    preview.classList.add('hidden');
                }
            });
        }
    });
});

