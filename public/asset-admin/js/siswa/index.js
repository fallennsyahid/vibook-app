// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', () => {
    const openModal = document.querySelector('#open-modal');
    const openModalEdit = document.querySelectorAll('.edit-siswa');
    const modalCreate = document.querySelector('#create-new-peminjam');
    const closeModal = document.querySelectorAll('.close-modal');

    console.log('DOM Ready - Init Modal');
    console.log('openModal:', openModal);
    console.log('modalCreate:', modalCreate);
    console.log('openModalEdit count:', openModalEdit.length);

    // Open create modal
    if (openModal) {
        openModal.addEventListener('click', (e) => {
            e.preventDefault();
            console.log('Create modal clicked');
            if (modalCreate) {
                modalCreate.classList.toggle('hidden');
                modalCreate.classList.toggle('flex');
                console.log('Modal classes after toggle:', modalCreate.className);
            }
        });
    }

    // Open edit modal
    openModalEdit.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const modalId = 'edit-peminjam-' + btn.dataset.id;
            const modal = document.querySelector('#' + modalId);
            console.log('Edit modal clicked, modal ID:', modalId, 'modal:', modal);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                console.log('Edit modal shown');
            }
        });
    });

    // Close modals
    closeModal.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            console.log('Close button clicked');

            // Close create modal
            if (modalCreate) {
                modalCreate.classList.remove('flex');
                modalCreate.classList.add('hidden');
            }

            // Close edit modal
            const modalOpen = btn.closest('.fixed');
            if (modalOpen) {
                modalOpen.classList.remove('flex');
                modalOpen.classList.add('hidden');
            }
        });
    });

    // File upload handling
    document.querySelectorAll('.upload-group').forEach(group => {
        const fileInput = group.querySelector('.file-input');
        const dropArea = group.querySelector('.drop-area');
        const preview = group.querySelector('.preview');
        const previewImage = group.querySelector('.preview-image');
        const fileName = group.querySelector('.file-name');
        const fileSize = group.querySelector('.file-size');
        const removeBtn = group.querySelector('.remove-file');

        if (!fileInput || !dropArea) return;

        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('border-primary');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('border-primary');
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('border-primary');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFile(files[0]);
            }
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFile(e.target.files[0]);
            }
        });

        function handleFile(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                if (previewImage) previewImage.src = e.target.result;
                if (fileName) fileName.textContent = file.name;
                if (fileSize) fileSize.textContent = formatFileSize(file.size);
                dropArea.classList.add('hidden');
                if (preview) {
                    preview.classList.remove('hidden');
                    preview.classList.add('flex');
                }
            };
            reader.readAsDataURL(file);
        }

        if (removeBtn) {
            removeBtn.addEventListener('click', () => {
                fileInput.value = '';
                dropArea.classList.remove('hidden');
                if (preview) {
                    preview.classList.remove('flex');
                    preview.classList.add('hidden');
                }
            });
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }
    });
});

