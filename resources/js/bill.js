// New Invoice modal
const btn_invo = document.getElementById("new-invo");
const modal_invo = document.getElementById("new-i");
const closeBtn_invo = document.getElementById("close-i");

btn_invo.addEventListener("click", () => {
  modal_invo.style.display = "block";
});

closeBtn_invo.addEventListener("click", () => {
  modal_invo.style.display = "none";
});
