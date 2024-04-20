function adjustStock(productId, adjustment) {
    var form = document.getElementById('stock-form-' + productId);
    var quantityInput = form.querySelector('input[name="quantity"]');
    var newQuantity = parseInt(quantityInput.value) + adjustment;
    quantityInput.value = Math.max(0, newQuantity); // Ensures stock is not negative
  }

  function confirmDelete() {
    return confirm('Are you sure you want to delete this product?');
  }