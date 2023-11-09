function startProgress() {
  const progressBar = document.getElementById("myProgressBar");
  let width = 0;
  const interval = setInterval(frame, 10);

  function frame() {
    if (width >= 100) {
      clearInterval(interval);
    } else {
      width++;
      progressBar.style.width = width + "%";
    }
  }
}

let slideIndex = 0;
const slidesToShow = 4;

function showSlide(n) {
  const slides = document.querySelector(".slider");
  const maxIndex = slides.children.length - slidesToShow;

  // Ensure the slide index stays within the valid range
  slideIndex = Math.max(0, Math.min(n, maxIndex));

  slides.style.transition = "transform 0.3s ease-in-out"; // Add transition here
  slides.style.transform = `translateX(-${slideIndex * (100 / slidesToShow)}%)`;
}

function prevSlide() {
  showSlide(slideIndex - 1); // Move to the previous slide
}

function nextSlide() {
  showSlide(slideIndex + 1); // Move to the next slide
}

showSlide(slideIndex);
