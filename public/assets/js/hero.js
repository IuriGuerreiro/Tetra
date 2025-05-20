document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const phrases = document.querySelectorAll('.phrase');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;
    let interval;
    
    // Function to update active phrase
    function setActivePhrase(index) {
        // Update phrases
        phrases.forEach((phrase, i) => {
            if (i === index) {
                phrase.classList.add('active');
            } else {
                phrase.classList.remove('active');
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
        currentIndex = (currentIndex + 1) % phrases.length;
        setActivePhrase(currentIndex);
    }
    
    // Start automatic rotation
    function startRotation() {
        interval = setInterval(nextPhrase, 2500);
    }
    
    // Handle dot clicks
    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            // Clear existing interval
            clearInterval(interval);
            
            // Set active phrase based on clicked dot
            currentIndex = parseInt(this.getAttribute('data-index'));
            setActivePhrase(currentIndex);
            
            // Restart rotation
            startRotation();
        });
    });
    
    // Start the automatic rotation
    startRotation();
});
