const carousel = document.querySelector('.carousel-container');
const items = document.querySelectorAll('.carousel-page');
const itemCount = items.length;
let currentIndex = 0;

function showItem(index) {
    if (index < 0) {
        index = itemCount - 1;
    } else if (index >= itemCount) {
        index = 0;
    }

    for (let i = 0; i < itemCount; i++) {
        if (i == index) {
            items[i].style.display = "block";
        } else {
            items[i].style.display = "none";
        }
    }
    currentIndex = index;
}

// Change slide every 3 seconds (adjust as needed)
setInterval(() => {
    currentIndex = (currentIndex + 1) % itemCount;
    showItem(currentIndex);
}, 3000);

// Handle navigation (next and previous)
document.querySelector('.next-button').addEventListener('click', () => {
    showItem(currentIndex + 1);
});

document.querySelector('.prev-button').addEventListener('click', () => {
    showItem(currentIndex - 1);
});

// Initial display
showItem(currentIndex);
