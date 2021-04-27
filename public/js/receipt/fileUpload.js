/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/receipt/fileUpload.js ***!
  \********************************************/
var fileUploadContainer = document.querySelector('.file-upload-container');
var fileUpload = fileUploadContainer.querySelector('.file-upload');
fileUploadContainer.children[0].addEventListener('change', setFileUploadName);
fileUpload.children[1].addEventListener('click', uploadFile);

function uploadFile() {
  fileUploadContainer.children[0].click();
}

function setFileUploadName() {
  var fileName = 'NO FILE SELECTED';

  if (filePath = fileUploadContainer.children[0].value) {
    fileName = filePath.replace('C:\\fakepath\\', '');
  }

  fileUpload.children[0].innerText = fileName;
}
/******/ })()
;