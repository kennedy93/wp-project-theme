/**
 * Main JavaScript file for WP Project Theme
 */

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {

    // Mobile menu toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            document.querySelector('nav').classList.toggle('active');
        });
    }

    // Project Filter AJAX functionality
    const filterForm = document.getElementById('projects-filter-form');
    const applyFiltersBtn = document.getElementById('apply-filters');
    const fallbackSubmitBtn = document.getElementById('fallback-submit');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const projectsContainer = document.getElementById('projects-container');

    if (filterForm && applyFiltersBtn && clearFiltersBtn && projectsContainer) {
        
        // Check if AJAX is available, if not, show fallback submit button
        if (typeof wpProjectAjax === 'undefined') {
            applyFiltersBtn.style.display = 'none';
            if (fallbackSubmitBtn) {
                fallbackSubmitBtn.style.display = 'inline-block';
            }
        }
        
        // Apply filters button click
        applyFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (typeof wpProjectAjax !== 'undefined') {
                applyProjectFilters();
            } else {
                // Fallback to regular form submission
                filterForm.submit();
            }
        });

        // Clear filters button click
        clearFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearProjectFilters();
        });

        // Function to apply project filters via AJAX
        function applyProjectFilters() {
            const startDate = document.getElementById('start_date_filter').value;
            const endDate = document.getElementById('end_date_filter').value;
            const nonce = document.querySelector('[name="wp_project_nonce"]').value;

            if (!startDate || !endDate) {
                alert('Please select both start and end dates.');
                return;
            }

            // Show loading state
            applyFiltersBtn.textContent = 'Filtering...';
            applyFiltersBtn.disabled = true;
            projectsContainer.classList.add('filter-loading');

            // Prepare form data
            const formData = new FormData();
            formData.append('action', 'filter_projects');
            formData.append('start_date', startDate);
            formData.append('end_date', endDate);
            formData.append('nonce', nonce);

            // Make AJAX request
            fetch(wpProjectAjax.ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    projectsContainer.innerHTML = data.data;
                } else {
                    console.error('Filter error:', data);
                    projectsContainer.innerHTML = '<div class="no-projects"><h2>Error loading projects</h2><p>Please try again later.</p></div>';
                }
            })
            .catch(error => {
                console.error('AJAX error:', error);
                projectsContainer.innerHTML = '<div class="no-projects"><h2>Error loading projects</h2><p>Please check your connection and try again.</p></div>';
            })
            .finally(() => {
                // Reset button state
                applyFiltersBtn.textContent = 'Apply Filters';
                applyFiltersBtn.disabled = false;
                projectsContainer.classList.remove('filter-loading');
            });
        }

        // Function to clear project filters
        function clearProjectFilters() {
            document.getElementById('start_date_filter').value = '';
            document.getElementById('end_date_filter').value = '';
            
            // Reload the page to show all projects
            window.location.href = window.location.pathname;
        }
    }

    // Smooth scroll for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Copy to clipboard functionality for social sharing
    window.copyToClipboard = function(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(function() {
                showCopyNotification('Link copied to clipboard!');
            }).catch(function() {
                fallbackCopyToClipboard(text);
            });
        } else {
            fallbackCopyToClipboard(text);
        }
    };

    // Fallback copy method for older browsers
    function fallbackCopyToClipboard(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showCopyNotification('Link copied to clipboard!');
        } catch (err) {
            showCopyNotification('Failed to copy link');
        }
        
        document.body.removeChild(textArea);
    }

    // Show copy notification
    function showCopyNotification(message) {
        // Remove existing notification if any
        const existingNotification = document.querySelector('.copy-notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'copy-notification';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary, #1a365d);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Enhanced reading progress indicator (if needed)
    const progressBar = document.createElement('div');
    progressBar.className = 'reading-progress';
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: var(--accent, #d4a017);
        z-index: 9999;
        transition: width 0.1s ease;
    `;

    // Only add progress bar on single posts
    if (document.body.classList.contains('single-post')) {
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            progressBar.style.width = scrolled + '%';
        });
    }

});
