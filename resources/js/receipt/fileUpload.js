const fileUploadContainer = document.querySelector('.file-upload-container');

if (fileUploadContainer) {
    const fileUpload = fileUploadContainer.querySelector('.file-upload');
    const fileInput = fileUploadContainer.querySelector('input[type=file]');

    fileInput.addEventListener('change', setFileUploadName);
    fileUpload.children[1].addEventListener('click', uploadFile);

    function uploadFile() {
        fileInput.click();
    }

    function setFileUploadName() {
        let fileName = 'NO FILE SELECTED';
        if (filePath = fileInput.value) {
            fileName = filePath.replace('C:\\fakepath\\', '');
        }
        fileUpload.children[0].innerText = fileName;
    }
}
