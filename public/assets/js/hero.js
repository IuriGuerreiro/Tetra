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
                // Remove active class from all phrases first
                phrases.forEach(p => p.classList.remove('active'));
                
                // Add active class to current phrase
                setTimeout(() => {
                    phrase.classList.add('active');
                    isAnimating = false;
                }, 50);
            }
        });
        
        // Update dots
        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
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
        interval = setInterval(nextPhrase, 4000); // Increased to 4 seconds for better readability
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
