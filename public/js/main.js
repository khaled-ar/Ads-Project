// Scroll progress indicator
        window.onscroll = function() {
            updateProgressBar();
            checkSectionVisibility();
            updateNavOnScroll();
        };
        
        function updateProgressBar() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
        }
        
        // Scroll to section smoothly
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            window.scrollTo({
                top: section.offsetTop - 70,
                behavior: 'smooth'
            });
        }
        
        // Add active class to nav items when scrolling
        const sections = document.querySelectorAll('section');
        const navItems = document.querySelectorAll('nav ul li a');
        
        function checkSectionVisibility() {
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                const scrollPosition = window.pageYOffset;
                
                if (scrollPosition >= sectionTop - 300 && scrollPosition < sectionTop + sectionHeight - 100) {
                    section.classList.add('visible');
                    
                    // Update active nav item
                    const id = section.getAttribute('id');
                    navItems.forEach(item => {
                        item.classList.remove('active');
                        if (item.getAttribute('href') === `#${id}`) {
                            item.classList.add('active');
                        }
                    });
                }
            });
        }
        
        // Navbar scroll effect
        function updateNavOnScroll() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 100) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }
        
        // Form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('شكرًا لتواصلك معنا! سنقوم بالرد عليك في أقرب وقت ممكن.');
            this.reset();
        });
        
        // Initialize animations on load
        document.addEventListener('DOMContentLoaded', function() {
            checkSectionVisibility();
            updateNavOnScroll();
            
            // Animate floating cars with random delays
            const cars = document.querySelectorAll('.floating-car');
            cars.forEach(car => {
                const randomDelay = Math.random() * 10;
                car.style.animationDelay = `${randomDelay}s`;
            });
        });

document.getElementById('toggleNav').addEventListener('click', function() {
        const navList = document.getElementById('navList');
        navList.classList.toggle('show');
    });

    document.addEventListener('click', (event) => {
        if (!toggleNav.contains(event.target) && !navList.contains(event.target)) {
            navList.classList.remove('show'); // Hide the menu if clicking outside
        }
    });