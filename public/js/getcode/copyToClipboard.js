/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************!*\
  !*** ./resources/js/getcode/copyToClipboard.js ***!
  \*************************************************/
var dataContainer = Array.from(document.querySelectorAll('.dataContainer'));
dataContainer.forEach(function (item) {
  console.log(item.children[1].children[0]);
  item.children[1].children[0].addEventListener('click', copyToClipboard);
});

function copyToClipboard(e) {
  e.target.parentElement.children[1].classList.add('tool-tip-animate');
  setTimeout(function () {
    e.target.parentElement.children[1].classList.remove('tool-tip-animate');
  }, 1000);
  window.navigator.clipboard.writeText(e.target.parentElement.parentElement.children[0].innerText);
}
/******/ })()
;