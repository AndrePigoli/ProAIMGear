document.addEventListener('DOMContentLoaded', function() {
    // Admin sidebar toggle (for mobile)
    const sidebarToggle = document.querySelector('.admin-menu-toggle');
    const adminSidebar = document.querySelector('.admin-sidebar');
    
    if (sidebarToggle && adminSidebar) {
        sidebarToggle.addEventListener('click', function() {
            adminSidebar.classList.toggle('active');
        });
    }
    
    // Success and error messages auto-hide
    const messages = document.querySelectorAll('.message');
    
    if (messages.length > 0) {
        setTimeout(() => {
            messages.forEach(message => {
                message.style.opacity = '0';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 500);
            });
        }, 5000);
    }
    
    // Product form validation
    const productForm = document.getElementById('productForm');
    
    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredInputs = productForm.querySelectorAll('[required]');
            
            requiredInputs.forEach(input => {
                if (input.value.trim() === '') {
                    isValid = false;
                    input.style.borderColor = 'var(--color-neon-red)';
                } else {
                    input.style.borderColor = '';
                }
            });
            
            // Additional validations
            const priceInput = document.getElementById('price');
            const stockInput = document.getElementById('stock');
            
            if (priceInput && parseFloat(priceInput.value) <= 0) {
                isValid = false;
                priceInput.style.borderColor = 'var(--color-neon-red)';
            }
            
            if (stockInput && parseInt(stockInput.value) < 0) {
                isValid = false;
                stockInput.style.borderColor = 'var(--color-neon-red)';
            }
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll to top where messages appear
                window.scrollTo({top: 0, behavior: 'smooth'});
                
                // Add error message
                const formContainer = document.querySelector('.form-container');
                if (formContainer) {
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'message error';
                    errorMessage.innerHTML = `
                        <i class="fas fa-exclamation-circle"></i>
                        Por favor, preencha todos os campos obrigatórios.
                    `;
                    
                    formContainer.insertBefore(errorMessage, productForm);
                    
                    // Auto remove message
                    setTimeout(() => {
                        errorMessage.style.opacity = '0';
                        setTimeout(() => {
                            errorMessage.remove();
                        }, 500);
                    }, 5000);
                }
            }
        });
        
        // Clear validation styling on input
        const formInputs = productForm.querySelectorAll('input, textarea, select');
        
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.style.borderColor = '';
            });
        });
    }
    
    // Image preview for product forms
    window.showImagePreview = function(inputId, previewId) {
        const url = document.getElementById(inputId).value;
        const preview = document.getElementById(previewId);
        
        if (url) {
            preview.innerHTML = `<img src="${url}" alt="Preview">`;
        } else {
            preview.innerHTML = '';
        }
    };
});