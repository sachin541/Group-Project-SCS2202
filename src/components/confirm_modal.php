<!-- Modal HTML -->

<style>
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
  padding-top: 100px;
}

.modal-content {
  background-color: #f4f4f4;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 30%;
  max-width: 300px; /* Adjust the width as necessary */
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  text-align: center; /* Center the text/message */
  border-radius: 10px;
}

.modal-message p {
  color: #333;
  font-size: 16px;
  
}

.modal-buttons {
  display: flex;
  flex-direction: row;
}

.modal-buttons button {
  flex: 1; /* Each button takes up an equal amount of space */
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  border: none;
  transition: background-color 0.3s ease;
  margin: 0 5px; /* Add a small margin between buttons */
}

#confirmDelete {
  background-color: #16a085;
  color: white;
}

#cancelDelete {
  background-color: black;
  color: white;
}

#confirmDelete:hover {
  background-color: red;
  
}

#cancelDelete:hover {
  background-color: red;
 
}




</style>

<div id="confirmModal" class="modal">
  <div class="modal-content">
    <div class="modal-message">
      <p>Are you sure you want to delete this product?</p>
    </div>
    <div class="modal-buttons">
      <button id="confirmDelete">Yes</button>
      <button id="cancelDelete">No</button>
    </div>
  </div>
</div>




<!-- Inline JavaScript for Modal -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  var deleteButtons = document.querySelectorAll('.delete-btn');
  var modal = document.getElementById("confirmModal");
  var confirmDelete = document.getElementById("confirmDelete");
  var cancelDelete = document.getElementById("cancelDelete");
  var formToSubmit = null;

  deleteButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault();
      modal.style.display = "block";
      formToSubmit = this.parentElement;
    });
  });

  confirmDelete.addEventListener('click', function() {
    if (formToSubmit) formToSubmit.submit();
  });

  cancelDelete.addEventListener('click', function() {
    modal.style.display = "none";
  });

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
});
</script>
