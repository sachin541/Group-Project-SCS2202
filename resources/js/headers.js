const list = document.querySelectorAll('.list');

function activeLink() {
    list.forEach((item) =>
    item.classList.remove('active'));
    this.classList.add('active');
}

list.forEach((item) =>
item.addEventListener('click', activeLink)
)

const logo = document.querySelectorAll('.logo');

function activeLinkHome() {
    list.forEach((item) =>
    item.classList.remove('active'));
    list.item(0).classList.add('active');
}

logo.forEach((item) =>
    item.addEventListener('click', activeLinkHome)
)

