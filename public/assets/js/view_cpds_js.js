// View CPDs Page JavaScript Functions

// Filter CPDs by search term
function filterCPDs() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const cpdCards = document.querySelectorAll('.cpd-full-card');
    let visibleCount = 0;

    cpdCards.forEach(card => {
        const title = card.querySelector('h2').textContent.toLowerCase();
        const content = card.textContent.toLowerCase();
        
        if (title.includes(searchTerm) || content.includes(searchTerm)) {
            card.style.display = 'block';
            card.style.animation = 'fadeInUp 0.5s ease forwards';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Update stats
    updateVisibleStats(visibleCount);
}

// Filter CPDs by duration
function filterByDuration(duration) {
    const cpdCards = document.querySelectorAll('.cpd-full-card');
    const filterButtons = document.querySelectorAll('.filter-btn');
    let visibleCount = 0;

    // Update active button
    filterButtons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    cpdCards.forEach(card => {
        const cardDuration = card.dataset.duration;
        
        if (duration === 'all' || cardDuration === duration) {
            card.style.display = 'block';
            card.style.animation = 'fadeInUp 0.5s ease forwards';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Clear search input if filtering by duration
    if (duration !== 'all') {
        document.getElementById('searchInput').value = '';
    }

    // Update stats
    updateVisibleStats(visibleCount);
}

// Update visible statistics
function updateVisibleStats(visibleCount) {
    const totalSessionsElement = document.querySelector('.stat-number');
    if (totalSessionsElement) {
        totalSessionsElement.textContent = visibleCount;
    }
    
    // Calculate total hours for visible sessions
    const visibleCards = document.querySelectorAll('.cpd-full-card[style*="display: block"], .cpd-full-card:not([style*="display: none"])');
    let totalHours = 0;
    
    visibleCards.forEach(card => {
        if (card.style.display !== 'none') {
            totalHours += parseInt(card.dataset.duration) || 0;
        }
    });
    
    const totalHoursElement = document.querySelectorAll('.stat-number')[1];
    if (totalHoursElement) {
        totalHoursElement.textContent = totalHours;
    }
}

// Scroll to specific CPD
function scrollToCPD(index) {
    const cpdCards = document.querySelectorAll('.cpd-full-card');
    if (cpdCards[index]) {
        // Add highlight effect
        cpdCards[index].style.transform = 'translateY(-8px)';
        cpdCards[index].style.borderColor = '#00ff88';
        cpdCards[index].style.boxShadow = '0 20px 60px rgba(0,255,136,0.3)';
        
        // Scroll to card
        cpdCards[index].scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
        
        // Remove highlight after delay
        setTimeout(() => {
            if (cpdCards[index]) {
                cpdCards[index].style.transform = '';
                cpdCards[index].style.borderColor = '';
                cpdCards[index].style.boxShadow = '';
            }
        }, 2000);
    }
}

// Scroll to top function
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Enhanced search with debouncing
let searchTimeout;
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(filterCPDs, 300);
}

// Initialize page functions
document.addEventListener('DOMContentLoaded', function() {
    // Add debounced search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounceSearch);
        
        // Add clear button functionality
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                filterCPDs();
            }
        });
    }

    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Focus search with Ctrl+F or /
        if ((e.ctrlKey && e.key === 'f') || e.key === '/') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Quick filters with number keys
        if (e.altKey) {
            switch(e.key) {
                case '1':
                    filterByDuration('all');
                    break;
                case '2':
                    filterByDuration('2');
                    break;
                case '3':
                    filterByDuration('4');
                    break;
                case '4':
                    filterByDuration('12');
                    break;
            }
        }
    });

    // Add smooth scroll indicator
    let scrollIndicator = document.createElement('div');
    scrollIndicator.className = 'scroll-indicator';
    scrollIndicator.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, #00ff88, #00cc6a);
        z-index: 1000;
        transition: width 0.3s ease;
    `;
    document.body.appendChild(scrollIndicator);

    // Update scroll indicator
    window.addEventListener('scroll', function() {
        const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
        scrollIndicator.style.width = scrolled + '%';
    });

    // Add floating back to top button
    const backToTopBtn = document.createElement('button');
    backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTopBtn.className = 'floating-back-to-top';
    backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(0,255,136,0.9);
        border: none;
        color: #111;
        font-size: 1.2rem;
        cursor: pointer;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 4px 20px rgba(0,255,136,0.3);
    `;
    
    backToTopBtn.addEventListener('click', scrollToTop);
    document.body.appendChild(backToTopBtn);

    // Show/hide floating button based on scroll
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            backToTopBtn.style.opacity = '1';
            backToTopBtn.style.transform = 'translateY(0)';
        } else {
            backToTopBtn.style.opacity = '0';
            backToTopBtn.style.transform = 'translateY(20px)';
        }
    });

    // Add hover effects to navigation items
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach((item, index) => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });

    // Initialize lazy loading for images
    const images = document.querySelectorAll('.cpd-image img');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.3s ease';
                
                const loadImg = new Image();
                loadImg.onload = () => {
                    img.style.opacity = '1';
                };
                loadImg.src = img.src;
                
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => {
        imageObserver.observe(img);
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .floating-back-to-top:hover {
        background: rgba(0,255,136,1) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 25px rgba(0,255,136,0.4) !important;
    }
`;
document.head.appendChild(style);