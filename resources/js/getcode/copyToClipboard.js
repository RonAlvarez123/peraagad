const dataContainer = Array.from(document.querySelectorAll('.dataContainer'));

dataContainer.forEach(item => {
    console.log(item.children[1].children[0]);
    item.children[1].children[0].addEventListener('click', copyToClipboard);
});

function copyToClipboard(e) {
    e.target.parentElement.children[1].classList.add('tool-tip-animate');
    setTimeout(() => {
        e.target.parentElement.children[1].classList.remove('tool-tip-animate');
    }, 1000);
    window.navigator.clipboard.writeText(e.target.parentElement.parentElement.children[0].innerText);
}