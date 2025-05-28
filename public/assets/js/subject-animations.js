function initSubjectAnimations() {
    // Fade in animations for elements with animate-fade-in class
    const fadeElements = document.querySelectorAll('.animate-fade-in');
    fadeElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transition = 'opacity 0.5s ease';
        setTimeout(() => {
            element.style.opacity = '1';
        }, 100 * (index + 1));
    });

    // Slide up animations for elements with animate-slide-up class
    const slideElements = document.querySelectorAll('.animate-slide-up');
    slideElements.forEach((element, index) => {
        const delay = element.dataset.delay ? parseFloat(element.dataset.delay) * 1000 : 0;
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 200 * (index + 1) + delay);
    });
}

// Function to check if element is in viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Function to handle animations
function handleAnimations() {
    // Add visible class to all animated elements in viewport
    document.querySelectorAll('[class*="animate-"]:not(.visible)').forEach(element => {
        if (isInViewport(element)) {
            element.classList.add('visible');
        }
    });

    // Handle subject cards
    document.querySelectorAll('.subject-card:not(.visible)').forEach(element => {
        if (isInViewport(element)) {
            element.classList.add('visible');
        }
    });
}

// Initialize animations
function initAnimations() {
    // Add loaded class to body
    document.body.classList.add('loaded');

    // Initial animation check
    handleAnimations();

    // Add scroll event listener
    window.addEventListener('scroll', handleAnimations);
    
    // Add resize event listener
    window.addEventListener('resize', handleAnimations);
}

// Run when DOM is loaded
document.addEventListener('DOMContentLoaded', initAnimations); 