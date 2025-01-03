let cart = [];

document.addEventListener('DOMContentLoaded', function () {
    // Add to Cart Button Click Event
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.getAttribute('data-item-id');
            const itemName = this.getAttribute('data-item-name');
            const itemPrice = parseFloat(this.getAttribute('data-item-price'));

            // Add item to cart
            cart.push({ id: itemId, name: itemName, price: itemPrice });

            // Show Cart Modal and update content
            updateCartModal();
            const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
            cartModal.show();
        });
    });

    // Update Cart Modal with Cart Items
    function updateCartModal() {
        let cartContent = '';
        let total = 0;
        cart.forEach(item => {
            cartContent += `${item.name} - $${item.price.toFixed(2)}<br>`;
            total += item.price;
        });

        document.getElementById('cartContent').innerHTML = cartContent;
        document.getElementById('cartTotal').innerText = total.toFixed(2);
    }

    // Close the Cart Modal and remove backdrop when clicking 'Continue Browsing'
    const continueBrowsingButton = document.querySelector('.btn-secondary[data-bs-dismiss="modal"]');
    if (continueBrowsingButton) {
        continueBrowsingButton.addEventListener('click', function () {
            // Hide the modal
            const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
            cartModal.hide();

            // Manually remove the backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove(); // Remove the backdrop element
            }

            // Ensure body is scrollable again
            document.body.style.overflow = 'auto';  // Reset overflow to 'auto'
        });
    }
});
