document.addEventListener('DOMContentLoaded', function() {
    // Image gallery
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('main-product-image');
    
    if (thumbnails.length > 0 && mainImage) {
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                // Remove active class from all thumbnails
                thumbnails.forEach(item => item.classList.remove('active'));
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
            });
        });
    }
    
    // Quantity controls
    const quantityInput = document.getElementById('quantity');
    const stockLimit = parseInt(quantityInput.getAttribute('max'), 10);
    
    window.changeQuantity = function(amount) {
        let currentValue = parseInt(quantityInput.value, 10);
        let newValue = currentValue + amount;
        
        // Validate new value
        if (newValue < 1) {
            newValue = 1;
        } else if (newValue > stockLimit) {
            newValue = stockLimit;
        }
        
        quantityInput.value = newValue;
    };
    
    // Image zoom effect
    if (mainImage) {
        const imageContainer = mainImage.parentElement;
        
        imageContainer.addEventListener('mouseenter', function() {
            mainImage.style.transform = 'scale(1.1)';
        });
        
        imageContainer.addEventListener('mouseleave', function() {
            mainImage.style.transform = 'scale(1)';
        });
        
        imageContainer.addEventListener('mousemove', function(e) {
            const rect = imageContainer.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width;
            const y = (e.clientY - rect.top) / rect.height;
            
            mainImage.style.transformOrigin = `${x * 100}% ${y * 100}%`;
        });
    }
    
    // Product image gallery function
    window.changeImage = function(imageSrc) {
        mainImage.src = imageSrc;
        
        // Animate image change
        mainImage.style.opacity = '0';
        setTimeout(() => {
            mainImage.style.opacity = '1';
        }, 100);
    };
    
    // Initialize the first thumbnail as active
    if (thumbnails.length > 0) {
        thumbnails[0].classList.add('active');
    }
    
    // Cart notification auto-hide
    const cartNotification = document.getElementById('cart-notification');
    
    if (cartNotification) {
        setTimeout(function() {
            cartNotification.style.opacity = '0';
            setTimeout(() => {
                cartNotification.style.display = 'none';
            }, 500);
        }, 3000);
    }
});