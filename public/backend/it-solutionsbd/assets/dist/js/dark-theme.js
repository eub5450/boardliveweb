// ============================================================
// DARK THEME ENHANCEMENTS
// ============================================================

$(document).ready(function() {
    
    // ============================================================
    // ANIMATED COUNTERS FOR STATISTICS
    // ============================================================
    function animateCounter(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value.toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }
    
    // Animate all statistic numbers when they come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                const finalValue = parseInt(element.textContent.replace(/,/g, ''));
                if (!isNaN(finalValue)) {
                    animateCounter(element, 0, finalValue, 1500);
                }
                observer.unobserve(element);
            }
        });
    }, observerOptions);
    
    // Observe all card titles that contain numbers
    document.querySelectorAll('.card-title').forEach(el => {
        if (el.textContent.match(/\d+/)) {
            observer.observe(el);
        }
    });
    
    // ============================================================
    // RIPPLE EFFECT FOR BUTTONS
    // ============================================================
    function createRipple(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.className = 'ripple-effect';
        
        button.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', createRipple);
    });
    
    // ============================================================
    // ADD RIPPLE EFFECT STYLES
    // ============================================================
    const style = document.createElement('style');
    style.textContent = `
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
            z-index: 10;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .btn {
            position: relative;
            overflow: hidden;
        }
    `;
    document.head.appendChild(style);
    
    // ============================================================
    // CARD HOVER ENHANCEMENTS
    // ============================================================
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.card-icon i');
            if (icon) {
                icon.style.transform = 'scale(1.2) rotate(10deg)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.card-icon i');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0)';
            }
        });
    });
    
    // ============================================================
    // PROGRESS BAR ANIMATION
    // ============================================================
    function animateProgressBars() {
        document.querySelectorAll('.progress-bar').forEach(bar => {
            const width = bar.style.width || bar.getAttribute('aria-valuenow') + '%';
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 1s ease';
                bar.style.width = width;
            }, 100);
        });
    }
    
    // Animate progress bars when they come into view
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setTimeout(animateProgressBars, 200);
                progressObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.progress').forEach(progress => {
        progressObserver.observe(progress);
    });
    
    // ============================================================
    // SMOOTH NUMBER FORMATTING
    // ============================================================
    function formatNumbers() {
        document.querySelectorAll('.card-title, .balance-value, .statistic-number').forEach(el => {
            const text = el.textContent;
            const number = parseFloat(text.replace(/[^0-9.-]/g, ''));
            if (!isNaN(number) && text.match(/^\d+$/)) {
                el.textContent = number.toLocaleString();
            }
        });
    }
    formatNumbers();
    
    // ============================================================
    // CHAT NOTIFICATION ANIMATIONS
    // ============================================================
    function checkNewMessages() {
        const chatList = document.getElementById('chat_list');
        const commentList = document.getElementById('comment_list');
        
        if (chatList) {
            const oldCount = chatList.children.length;
            
            // Your existing commentfetchData function will handle the update
            // This just adds a visual notification
            if (oldCount > 0) {
                chatList.style.animation = 'pulse 0.5s ease';
                setTimeout(() => {
                    chatList.style.animation = '';
                }, 500);
            }
        }
    }
    
    // Check for new messages every 30 seconds
   // setInterval(checkNewMessages, 30000);
    
    // ============================================================
    // TOOLTIP INITIALIZATION (if Bootstrap tooltips are used)
    // ============================================================
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // ============================================================
    // ADD LOADING SPINNER TO BUTTONS ON CLICK
    // ============================================================
    document.querySelectorAll('button[type="submit"]').forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.closest('form')) {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Loading...';
                this.disabled = true;
                
                // Re-enable after 2 seconds (prevents double submission)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 2000);
            }
        });
    });
    
    // ============================================================
    // THEME TOGGLE ANIMATION (Optional - if you want a theme switcher)
    // ============================================================
    // Uncomment if you want to add a theme toggle button
    /*
    const themeToggle = document.createElement('button');
    themeToggle.innerHTML = '🌙';
    themeToggle.className = 'btn btn-sm btn-primary position-fixed';
    themeToggle.style.cssText = 'bottom: 80px; right: 20px; z-index: 9999; border-radius: 50%; width: 45px; height: 45px;';
    themeToggle.onclick = function() {
        document.body.classList.toggle('light-theme');
        this.innerHTML = document.body.classList.contains('light-theme') ? '☀️' : '🌙';
    };
    document.body.appendChild(themeToggle);
    */
});

// ============================================================
// ENHANCE EXISTING CHAT FUNCTIONS
// ============================================================
// Preserve your existing commentfetchData but enhance it
// const originalCommentFetch = window.commentfetchData;
// if (originalCommentFetch) {
//     window.commentfetchData = function() {
//         originalCommentFetch();
//         // Add animation to new comments
//         setTimeout(() => {
//             $('#comment_list .user-chat').each(function(index) {
//                 $(this).css('animation', `slideInRight 0.5s ease ${index * 0.1}s both`);
//             });
//         }, 100);
//     };
// }