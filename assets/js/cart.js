document.addEventListener('DOMContentLoaded', function() {
    // Cart item quantity controls
    window.updateCartQuantity = function(button, amount) {
        const inputElement = button.parentElement.querySelector('input');
        let currentValue = parseInt(inputElement.value, 10);
        let newValue = currentValue + amount;
        
        // Get max stock from input
        const stockLimit = parseInt(inputElement.getAttribute('max'), 10);
        
        // Validate new value
        if (newValue < 1) {
            newValue = 1;
        } else if (newValue > stockLimit) {
            newValue = stockLimit;
        }
        
        inputElement.value = newValue;
        
        // Update subtotal display
        const form = button.closest('.update-quantity-form');
        const cartItem = form.closest('.cart-item');
        const priceElement = cartItem.querySelector('.item-price');
        const subtotalElement = cartItem.querySelector('.subtotal-value');
        
        if (priceElement && subtotalElement) {
            const price = parseFloat(priceElement.textContent.replace('R$ ', '').replace(',', '.'));
            const subtotal = price * newValue;
            subtotalElement.textContent = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
        }
    };
    
    // Highlight cart item when updated
    const updateForms = document.querySelectorAll('.update-quantity-form');
    
    updateForms.forEach(form => {
        form.addEventListener('submit', function() {
            const cartItem = this.closest('.cart-item');
            cartItem.style.backgroundColor = 'rgba(0, 200, 255, 0.1)';
            setTimeout(() => {
                cartItem.style.backgroundColor = '';
            }, 1000);
        });
    });
    
    // Confirm delete item
    const removeForms = document.querySelectorAll('.remove-item-form');
    
    removeForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Tem certeza que deseja remover este item do carrinho?')) {
                e.preventDefault();
            }
        });
    });
    
    // Checkout button
    const checkoutBtn = document.querySelector('.checkout-btn');
    
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            alert('Funcionalidade de checkout em desenvolvimento.');
        });
    }
});