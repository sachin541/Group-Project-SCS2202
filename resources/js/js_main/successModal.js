function showSuccessModal() {
    var modal = document.getElementById('successModal');
    var mainContent = document.querySelector('.main-content');
    modal.style.display = "block";
    mainContent.classList.add('blur');
}

function closeSuccessModal() {
    var modal = document.getElementById('successModal');
    var mainContent = document.querySelector('.main-content');
    modal.style.display = "none";
    mainContent.classList.remove('blur');
}