const btn = document.getElementById("edit");
const modal = document.getElementById("myModal");
const closeBtn = document.getElementById("close");

btn.addEventListener("click", () => {
  modal.style.display = "block";
});

closeBtn.addEventListener("click", () => {
  modal.style.display = "none";
});

const emp_btn = document.getElementById("add-emp");
const emp_modal = document.getElementById("new-emp");
const emp_closeBtn = document.getElementById("e-close");

emp_btn.addEventListener("click", () => {
  emp_modal.style.display = "block";
});

emp_closeBtn.addEventListener("click", () => {
  emp_modal.style.display = "none";
});