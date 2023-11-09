// New Category modal
const btn_cat = document.getElementById("new-category");
const modal_cat = document.getElementById("new-c");
const closeBtn_cat = document.getElementById("close-c");

btn_cat.addEventListener("click", () => {
  modal_cat.style.display = "block";
});

closeBtn_cat.addEventListener("click", () => {
  modal_cat.style.display = "none";
});

// New Brand modal
const btn_brand = document.getElementById("new-brand");
const modal_brand = document.getElementById("new-b");
const closeBtn_brand = document.getElementById("close-b");

btn_brand.addEventListener("click", () => {
  modal_brand.style.display = "block";
});

closeBtn_brand.addEventListener("click", () => {
  modal_brand.style.display = "none";
});

// New Product modal
const btn_prod = document.getElementById("new-prod");
const modal_prod = document.getElementById("new-p");
const closeBtn_prod = document.getElementById("close-p");

btn_prod.addEventListener("click", () => {
  modal_prod.style.display = "block";
});

closeBtn_prod.addEventListener("click", () => {
  modal_prod.style.display = "none";
});
