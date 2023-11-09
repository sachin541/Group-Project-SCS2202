// For item images slider
let slideIndex = 0;

function showSlide(n) {
  const slides = document.getElementsByClassName("item");
  if (n < 0) {
    slideIndex = 0;
  } else if (n >= slides.length) {
    slideIndex = slides.length - 1;
  }

  for (let i = 0; i < slides.length; i++) {
    slides[i].style.transform = `translateX(${-slideIndex * 100}%)`;
  }
}

function prevSlide() {
  slideIndex--;
  showSlide(slideIndex);
}

function nextSlide() {
  slideIndex++;
  showSlide(slideIndex);
}

showSlide(slideIndex);

// For similar products carousel
let carouselIndex = 0;
const slidesToShow = 4;

function showNextProd(p) {
  const similarProds = document.querySelector(".similar-slider");
  const maxIndex = similarProds.children.length - slidesToShow;

  // Ensure the slide index stays within the valid range
  carouselIndex = Math.max(0, Math.min(p, maxIndex));

  similarProds.style.transition = "transform 0.3s ease-in-out"; // Add transition here
  similarProds.style.transform = `translateX(-${
    carouselIndex * (100 / slidesToShow)
  }%)`;
}

function prevProd() {
  showNextProd(carouselIndex - 1); // Move to the previous slide
}

function nextProd() {
  showNextProd(carouselIndex + 1); // Move to the next slide
}

showNextProd(carouselIndex);

// For star rating system
const ratingContainer = document.querySelector(".rating");
const selectedRating = document.getElementById("selectedRating");

ratingContainer.addEventListener("change", (e) => {
  selectedRating.textContent = e.target.value;
});

// For review box
const reviewForm = document.getElementById("reviewForm");
const reviewList = document.getElementById("reviewList");

reviewForm.addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("name").value;
  const reviewText = document.getElementById("reviewText").value;

  // Simulate sending data to a PHP script to store the review in a database
  // In this example, we'll just add it to the page

  const reviewItem = document.createElement("li");
  reviewItem.innerHTML = `<strong>${name}</strong>: ${reviewText}`;
  reviewList.appendChild(reviewItem);

  // Clear the form
  document.getElementById("name").value = "";
  document.getElementById("reviewText").value = "";
});
