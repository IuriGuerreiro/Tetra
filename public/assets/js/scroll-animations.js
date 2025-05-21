document.addEventListener('DOMContentLoaded', function() {
    // Select all elements with animation classes
    const animationSelectors = [
        '.service-card',
        '.requirement-group',
        '.stat-card',
        '.cpd-content',
        '.tefl-content',
        '.animate-fade-in',
        '.animate-slide-up',
        '.animate-slide-right',
        '.animate-zoom-in'
    ];
    
    // Create a single Intersection Observer instance
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Get the delay from data-delay attribute or default to 0
                const delay = entry.target.dataset.delay ? 
                    parseFloat(entry.target.dataset.delay) * 1000 : 0;
                
                // Apply the animation with the specified delay
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, delay);
                
                // Unobserve after animation completes to improve performance
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1, // Trigger when 10% of the element is visible
        rootMargin: '0px 0px -50px 0px' // Start animation slightly before element is in view
    });

    // Observe all matching elements
    animationSelectors.forEach(selector => {
        document.querySelectorAll(selector).forEach(element => {
            observer.observe(element);
        });
    });
});
