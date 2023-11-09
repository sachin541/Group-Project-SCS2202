const notificationIcon = document.getElementById("notification-icn");
const profileIcon = document.getElementById("profile-img");
const popupMenu1 = document.getElementById("popup-menu-1");
const popupMenu2 = document.getElementById("popup-menu-2");

notificationIcon.addEventListener("click", () => {
  popupMenu1.style.display =
    popupMenu1.style.display === "block" ? "none" : "block";
});

// Close the pop-up menu if the user clicks outside of it
document.addEventListener("click", (event) => {
  if (
    !notificationIcon.contains(event.target) &&
    !popupMenu1.contains(event.target)
  ) {
    popupMenu1.style.display = "none";
  }
});

profileIcon.addEventListener("click", () => {
  popupMenu2.style.display =
    popupMenu2.style.display === "block" ? "none" : "block";
});

// Close the pop-up menu if the user clicks outside of it
document.addEventListener("click", (event) => {
  if (
    !profileIcon.contains(event.target) &&
    !popupMenu2.contains(event.target)
  ) {
    popupMenu2.style.display = "none";
  }
});
