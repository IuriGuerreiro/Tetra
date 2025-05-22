// CPD-specific animations with early triggering
function initCPDAnimations() {
    // Animation selectors for general elements (with normal trigger)
    const generalAnimationSelectors = [
        '.service-card',
        '.requirement-group',
        '.stat-card',
        '.tefl-content',
        '.animate-fade-in',
        '.animate-slide-right',
        '.animate-zoom-in',
        '.benefit-card',
        '.step-card'
    ];
    
    // CPD-specific selectors (with early trigger)
    const cpdAnimationSelectors = [
        '.session-card',
        '.cpd-content',
        '.animate-slide-up'
    ];
    
    // Create observer for general elements (normal trigger)
    const generalObserver = new IntersectionObserver((entries) => {
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
                generalObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1, // Trigger when 10% of the element is visible
        rootMargin: '0px 0px -50px 0px' // Start animation slightly before element is in view
    });

    // Create observer for CPD elements (early trigger)
    const cpdObserver = new IntersectionObserver((entries) => {
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
                cpdObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.05, // Trigger when only 5% of the element is visible (earlier)
        rootMargin: '100px 0px 50px 0px' // Start animation much earlier - 100px before entering viewport
    });

    // Observe general elements with normal timing
    generalAnimationSelectors.forEach(selector => {
        document.querySelectorAll(selector).forEach(element => {
            // Skip if element is also a CPD element (will be handled by CPD observer)
            const isCPDElement = cpdAnimationSelectors.some(cpdSelector => 
                element.matches(cpdSelector)
            );
            
            if (!isCPDElement) {
                generalObserver.observe(element);
            }
        });
    });

    // Observe CPD elements with early timing
    cpdAnimationSelectors.forEach(selector => {
        document.querySelectorAll(selector).forEach(element => {
            cpdObserver.observe(element);
        });
    });

    // Special handling for elements that should animate immediately when in view
    const immediateElements = document.querySelectorAll('.hero-content, .section-title');
    immediateElements.forEach(element => {
        const immediateObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    immediateObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px'
        });
        
        immediateObserver.observe(element);
    });
}

// Initialize animations when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initCPDAnimations();
});