document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    const closeMenuBtn = document.querySelector('.close-menu-btn');
    
    if (mobileMenuBtn && mobileMenu && closeMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        
        closeMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    // Mobile Dropdown Toggle
    const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
    
    mobileDropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownMenu = this.nextElementSibling;
            dropdownMenu.classList.toggle('active');
            
            // Toggle icon
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-chevron-down')) {
                icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        });
    });
    
    // Featured Products Slider
    const sliderWrapper = document.querySelector('.slider-wrapper');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    
    if (sliderWrapper && prevBtn && nextBtn) {
        const productCards = sliderWrapper.querySelectorAll('.product-card');
        let currentIndex = 0;
        let cardWidth = 0;
        let maxIndex = 0;
        let cardsToShow = 0;
        
        // Function to update slider parameters based on window width
        function updateSliderParameters() {
            // Set the number of cards to show based on window width
            if (window.innerWidth >= 1200) {
                cardsToShow = 4;
            } else if (window.innerWidth >= 768) {
                cardsToShow = 3;
            } else if (window.innerWidth >= 576) {
                cardsToShow = 2;
            } else {
                cardsToShow = 1;
            }
            
            // Calculate card width and max index
            cardWidth = sliderWrapper.clientWidth / cardsToShow;
            maxIndex = Math.max(0, productCards.length - cardsToShow);
            
            // Update card width
            productCards.forEach(card => {
                card.style.width = `${cardWidth}px`;
                card.style.minWidth = `${cardWidth}px`;
            });
            
            // Reset position to avoid out-of-bounds index
            currentIndex = Math.min(currentIndex, maxIndex);
            sliderWrapper.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        }
        
        // Initial setup
        updateSliderParameters();
        
        // Update on window resize
        window.addEventListener('resize', updateSliderParameters);
        
        // Slider navigation buttons
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                sliderWrapper.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            }
        });
        
        nextBtn.addEventListener('click', function() {
            if (currentIndex < maxIndex) {
                currentIndex++;
                sliderWrapper.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            }
        });
        
        // Auto slide
        let autoSlideInterval;
        
        function startAutoSlide() {
            autoSlideInterval = setInterval(function() {
                if (currentIndex < maxIndex) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                sliderWrapper.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
            }, 5000);
        }
        
        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }
        
        // Start auto slide
        startAutoSlide();
        
        // Pause auto slide on hover
        sliderWrapper.addEventListener('mouseenter', stopAutoSlide);
        sliderWrapper.addEventListener('mouseleave', startAutoSlide);
        
        // Pause auto slide when buttons are hovered
        prevBtn.addEventListener('mouseenter', stopAutoSlide);
        prevBtn.addEventListener('mouseleave', startAutoSlide);
        nextBtn.addEventListener('mouseenter', stopAutoSlide);
        nextBtn.addEventListener('mouseleave', startAutoSlide);
    }
    
    // Cart Notification
    const cartNotification = document.getElementById('cart-notification');
    
    if (cartNotification) {
        // Auto hide notification after 3 seconds
        setTimeout(function() {
            cartNotification.style.opacity = '0';
            setTimeout(function() {
                cartNotification.style.display = 'none';
            }, 500);
        }, 3000);
    }
    
    // Search functionality
    const searchInput = document.getElementById('search-input');
    const mobileSearchInput = document.getElementById('mobile-search-input');
    
    function handleSearch(e) {
        if (e.key === 'Enter') {
            const searchTerm = encodeURIComponent(e.target.value.trim());
            if (searchTerm) {
                window.location.href = `products.php?search=${searchTerm}`;
            }
        }
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', handleSearch);
    }
    
    if (mobileSearchInput) {
        mobileSearchInput.addEventListener('keypress', handleSearch);
    }
    
    // Search button click
    const searchButtons = document.querySelectorAll('.search-btn');
    
    searchButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const searchTerm = encodeURIComponent(input.value.trim());
            if (searchTerm) {
                window.location.href = `products.php?search=${searchTerm}`;
            }
        });
    });
});