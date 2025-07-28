document.addEventListener('DOMContentLoaded', function() {
    const leftAd = document.querySelector('.left-ad');
    const rightAd = document.querySelector('.right-ad');
    const leftAdWrapper = document.querySelector('.left-ad-wrapper');
    const rightAdWrapper = document.querySelector('.right-ad-wrapper');
    const mainContainer = document.getElementById('main');
    
    if (!leftAd || !rightAd || !mainContainer || !leftAdWrapper || !rightAdWrapper) return;
    
    function updateAdsPosition() {
        const leftAdVisible = window.getComputedStyle(leftAdWrapper).display !== 'none';
        const rightAdVisible = window.getComputedStyle(rightAdWrapper).display !== 'none';
        
        if (!leftAdVisible || !rightAdVisible) {
            return;
        }
        
        const mainRect = mainContainer.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const adHeight = 400;
        
        let translateY = 0;
        
        if (mainRect.top < 0) {
            const viewportCenter = windowHeight / 2;
            const adCenter = adHeight / 2;
            const desiredPosition = viewportCenter - adCenter; 
            const offsetFromMainTop = Math.abs(mainRect.top);
            
            translateY = Math.min(
                offsetFromMainTop + desiredPosition,
                mainRect.height - adHeight - 20 
            );
        } else {
            const viewportCenter = windowHeight / 2;
            const adCenter = adHeight / 2;
            translateY = Math.max(0, viewportCenter - adCenter - mainRect.top);
        }
        
        leftAd.style.transform = `translateY(${translateY}px)`;
        rightAd.style.transform = `translateY(${translateY}px)`;
    }

    window.addEventListener('scroll', updateAdsPosition);
    window.addEventListener('resize', updateAdsPosition);
    
    updateAdsPosition();
});

