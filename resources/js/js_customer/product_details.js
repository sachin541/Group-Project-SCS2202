let currentImageIndex = 0;
const images = document.querySelectorAll('.carousel-image');
let cycleCount = 0; // Variable to keep track of cycles
const totalCycles = images.length; // Total number of images
let interval; // Variable to store the interval

function changeImage(direction) {
    // Hide the current image
    images[currentImageIndex].style.display = 'none';
    
    // Change image index
    currentImageIndex += direction;
    
    // If we're at the last image, increase the cycle count
    if (currentImageIndex >= images.length) {
        currentImageIndex = 0;
        cycleCount++;
    } else if (currentImageIndex < 0) {
        currentImageIndex = images.length - 1;
    }
    
    // Show the new image
    images[currentImageIndex].style.display = 'block';

    // Stop cycling after one complete round
    if (cycleCount >= totalCycles) {
        clearInterval(interval);
    }
}

// Start automatic cycling
interval = setInterval(function() {
    changeImage(1);
}, 8000); // Change image every 8000 milliseconds (8 seconds)