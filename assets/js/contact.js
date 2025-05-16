document.addEventListener('DOMContentLoaded', function() {
    // Contact form validation
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let isValid = true;
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const subjectInput = document.getElementById('subject');
            const messageInput = document.getElementById('message');
            
            // Simple validation
            if (nameInput.value.trim() === '') {
                isValid = false;
                nameInput.style.borderColor = 'var(--color-neon-red)';
            } else {
                nameInput.style.borderColor = '';
            }
            
            if (emailInput.value.trim() === '' || !isValidEmail(emailInput.value)) {
                isValid = false;
                emailInput.style.borderColor = 'var(--color-neon-red)';
            } else {
                emailInput.style.borderColor = '';
            }
            
            if (subjectInput.value.trim() === '') {
                isValid = false;
                subjectInput.style.borderColor = 'var(--color-neon-red)';
            } else {
                subjectInput.style.borderColor = '';
            }
            
            if (messageInput.value.trim() === '') {
                isValid = false;
                messageInput.style.borderColor = 'var(--color-neon-red)';
            } else {
                messageInput.style.borderColor = '';
            }
            
            if (!isValid) {
                e.preventDefault();
                
                // Show validation error
                const notificationContainer = document.getElementById('notificationContainer');
                
                if (notificationContainer) {
                    const notification = document.createElement('div');
                    notification.className = 'notification';
                    notification.innerHTML = `
                        <p><i class="fas fa-exclamation-circle"></i> Por favor, preencha todos os campos corretamente.</p>
                    `;
                    
                    notificationContainer.appendChild(notification);
                    
                    // Auto remove notification
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        setTimeout(() => {
                            notification.remove();
                        }, 500);
                    }, 3000);
                }
            }
        });
        
        // Add input event listeners to clear error styling
        const formInputs = contactForm.querySelectorAll('input, textarea');
        
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.style.borderColor = '';
            });
        });
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
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
});