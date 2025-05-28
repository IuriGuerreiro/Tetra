document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const phrases = document.querySelectorAll('.phrase');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;
    let interval;
    let isAnimating = false;
    
    // Function to update active phrase
    function setActivePhrase(index) {
        if (isAnimating) return;
        isAnimating = true;

        // Update phrases
        phrases.forEach((phrase, i) => {
            if (i === index) {
                // Remove active class and add transition classes
                phrases.forEach(p => {
                    p.classList.remove('active');
                    p.classList.add('opacity-0', 'invisible', '-translate-y-5');
                });
                
                // Add active class to current phrase with slight delay for smooth transition
                setTimeout(() => {
                    phrase.classList.add('active');
                    phrase.classList.remove('opacity-0', 'invisible', '-translate-y-5');
                    isAnimating = false;
                }, 50);
            }
        });
        
        // Update dots
        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('active', 'bg-white', 'scale-110');
                dot.classList.remove('bg-white/30');
            } else {
                dot.classList.remove('active', 'bg-white', 'scale-110');
                dot.classList.add('bg-white/30');
            }
        });
    }
    
    // Function to show next phrase
    function nextPhrase() {
        if (isAnimating) return;
        currentIndex = (currentIndex + 1) % phrases.length;
        setActivePhrase(currentIndex);
    }
    
    // Start automatic rotation
    function startRotation() {
        interval = setInterval(nextPhrase, 4000); // 4 seconds per phrase
    }
    
    // Handle dot clicks
    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            if (isAnimating) return;
            
            // Clear existing interval
            clearInterval(interval);
            
            // Set active phrase based on clicked dot
            currentIndex = parseInt(this.getAttribute('data-index'));
            setActivePhrase(currentIndex);
            
            // Restart rotation
            startRotation();
        });

        // Add hover effect
        dot.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.classList.add('scale-110');
            }
        });

        dot.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.classList.remove('scale-110');
            }
        });
    });

    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        if (isAnimating) return;
        
        // Clear the timeout if it exists
        if (resizeTimeout) {
            clearTimeout(resizeTimeout);
        }
        
        // Set a new timeout
        resizeTimeout = setTimeout(function() {
            // Force a reflow of the active phrase
            const activePhrase = document.querySelector('.phrase.active');
            if (activePhrase) {
                activePhrase.style.display = 'none';
                activePhrase.offsetHeight; // Force reflow
                activePhrase.style.display = '';
            }
        }, 250);
    });

    // Initialize the first phrase
    setActivePhrase(0);
    
    // Start the automatic rotation
    startRotation();
});
