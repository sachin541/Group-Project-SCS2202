<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Confirmation Modal Example</title>
<style>
    /* Style.css */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

button {
    padding: 10px;
    margin: 10px;
}

</style>
<!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>

<!-- Form -->
<form id="myForm" action="/submit-form" method="post">
    <input type="text" name="data" placeholder="Enter some data">
    <button type="submit">Submit</button>
</form>

<!-- Modal -->
<div id="confirmModal" class="modal">
    <div class="modal-content">
        <h2>Confirm Submission</h2>
        <p>Are you sure you want to submit this form?</p>
        <button id="confirmSubmit">Confirm</button>
        <button id="cancelSubmit">Cancel</button>
    </div>
</div>

<!-- <script src="script.js"></script> -->
</body>
</html>


<script>
    // script.js
document.getElementById('myForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting immediately
    document.getElementById('confirmModal').style.display = 'block'; // Show the modal
});

document.getElementById('confirmSubmit').addEventListener('click', function() {
    document.getElementById('confirmModal').style.display = 'none'; // Hide the modal
    document.getElementById('myForm').submit(); // Submit the form programmatically
});

document.getElementById('cancelSubmit').addEventListener('click', function() {
    document.getElementById('confirmModal').style.display = 'none'; // Hide the modal
});

</script>