function increaseQuantity(productId) {
    var form = document.getElementById('update-form-' + productId);
    var quantityInput = form.querySelector('input[name="quantity"]');
    quantityInput.value = parseInt(quantityInput.value) + 1;
    form.submit();
}

function decreaseQuantity(productId) {
    var form = document.getElementById('update-form-' + productId);
    var quantityInput = form.querySelector('input[name="quantity"]');
    if (parseInt(quantityInput.value) > 1) { // Prevents quantity from going below 1
        quantityInput.value = parseInt(quantityInput.value) - 1;
        form.submit();
    }
}