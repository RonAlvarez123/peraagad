/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/receipt/fileUpload.js ***!
  \********************************************/
var fileUploadContainer = document.querySelector('.file-upload-container');

if (fileUploadContainer) {
  var uploadFile = function uploadFile() {
    fileInput.click();
  };

  var setFileUploadName = function setFileUploadName() {
    var fileName = 'NO FILE SELECTED';

    if (filePath = fileInput.value) {
      fileName = filePath.replace('C:\\fakepath\\', '');
    }

    fileUpload.children[0].innerText = fileName;
  };

  var fileUpload = fileUploadContainer.querySelector('.file-upload');
  var fileInput = fileUploadContainer.querySelector('input[type=file]');
  fileInput.addEventListener('change', setFileUploadName);
  fileUpload.children[1].addEventListener('click', uploadFile);
}
/******/ })()
;