document.addEventListener('DOMContentLoaded', function() {
    initStories();
    highlightFirstStory();
});
function initStories() {
    const storyCircles = document.querySelectorAll('.story-circle');
    storyCircles.forEach(circle => {
        circle.addEventListener('click', function(e) {
            if (!e.target.classList.contains('story-username')) {
                const prizeValue = this.dataset.prizeValue;
                const image_url = this.dataset.imageUrl;
                const title = this.dataset.title;
                const form_url = this.dataset.prizeFormUrl;
                showStory(image_url, title, prizeValue, form_url);
            }
        });

        circle.addEventListener('mouseenter', function() {
            this.querySelector('.story-border').style.transform = 'scale(1.05)';
        });

        circle.addEventListener('mouseleave', function() {
            this.querySelector('.story-border').style.transform = 'scale(1)';
        });
    });
}

function showStory(image_url, title, prizeValue, form_url) {
    const viewer = document.createElement('div');
    viewer.className = 'story-viewer';
    viewer.innerHTML = `
        <div class="story-viewer-content">
            <div class="story-progress-container">
                <div class="story-progress-bar"></div>
            </div>
            <div class="story-close-btn">&times;</div>
            <img src="${image_url}" alt="${title}" class="viewer-story-image">
            <div class="story-viewer-footer">
                ${prizeValue > 0 ? `
                <a href="${form_url}" class="view-form-btn">
                    <span>اربح الان</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                ` : ''}
            </div>
        </div>
    `;

    document.body.appendChild(viewer);
    document.body.style.overflow = 'hidden';

    // Start showing the viewer
    setTimeout(() => {
        viewer.style.opacity = '1';

        // Get the progress bar element
        const progressBar = viewer.querySelector('.story-progress-bar');

        // Start the progress bar animation
        progressBar.style.width = '100%';
        progressBar.style.transition = 'width 10s linear';

        // Close when transition completes
        progressBar.addEventListener('transitionend', function() {
            closeViewer(viewer);
        });

        // Manual close button
        viewer.querySelector('.story-close-btn').addEventListener('click', function() {
            closeViewer(viewer);
        });

        // Pause on hover
        viewer.addEventListener('mouseenter', function() {
            progressBar.style.transition = 'none';
            progressBar.style.width = progressBar.offsetWidth + 'px';
        });

        // Resume on mouse leave
        viewer.addEventListener('mouseleave', function() {
            const remainingWidth = 100 - (parseInt(progressBar.style.width) || 0);
            const remainingTime = (remainingWidth / 100) * 5000; // 5s total

            progressBar.style.transition = `width ${remainingTime}ms linear`;
            progressBar.style.width = '100%';

            // Reattach the transitionend listener
            progressBar.addEventListener('transitionend', function() {
                closeViewer(viewer);
            });
        });

    }, 10);
}

function closeViewer(viewer) {
    viewer.style.opacity = '0';
    setTimeout(() => {
        if (viewer.parentNode) {
            document.body.removeChild(viewer);
        }
        document.body.style.overflow = 'auto';
    }, 300);
}

function highlightFirstStory() {
    const firstStory = document.querySelector('.story-circle');
    if (firstStory) {
        firstStory.classList.add('new-story');
        setTimeout(() => firstStory.classList.remove('new-story'), 10000);
    }
}
