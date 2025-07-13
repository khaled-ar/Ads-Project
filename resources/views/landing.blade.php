<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'خطوة')</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Three.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.min.js"></script>

    <!-- Vite Assets -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <!-- Additional Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- Scroll progress indicator -->
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    <header>
        <div class="scroll-down" onclick="scrollToSection('about')">
            <i class="fas fa-chevron-down"></i>
        </div>
    </header>

    <nav id="mainNav">
        <div class="nav-logo-container">
            <a href="#" class="nav-logo">
                <img src="{{ asset('logo.png') }}" alt="Logo">
            </a>
            <!-- 3D Logo Container -->
            <div id="logo3d-container"></div>
            <button id="toggleNav" aria-label="Toggle Navigation">☰</button>
        </div>

        <ul id="navList">
            <li class="nav-3d-btn"><a href="#about">من نحن</a></li>
            <li class="nav-3d-btn"><a href="#goals">أهدافنا</a></li>
            <li class="nav-3d-btn"><a href="#customers">عملاؤنا</a></li>
            <li class="nav-3d-btn"><a href="#join">انضم إلينا</a></li>
            <li class="nav-3d-btn"><a href="#stats">إحصائيات</a></li>
            <li class="nav-3d-btn"><a href="#download">حمل التطبيق</a></li>
            <li class="nav-3d-btn"><a href="#contact">اتصل بنا</a></li>
        </ul>
    </nav>

    <div class="container">
        <section id="about" class="about-section">
            <h2>من نحن</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>مرحبًا بكم في موقعنا المتخصص في إعلانات السيارات وملصقات السيارات. نحن نقدم منصة شاملة تجمع بين
                        المعلنين ومالكي السيارات الذين يرغبون في استغلال مساحة سيارتهم للإعلان.</p>
                    <p>تأسس موقعنا عام 2023 بهدف إنشاء سوق متكامل للإعلان على السيارات، حيث نقدم حلولاً مبتكرة للشركات
                        الصغيرة والمتوسطة للوصول إلى جمهور أوسع، وفي نفس الوقت نمكن مالكي السيارات من كسب دخل إضافي من
                        خلال مشاركة سيارتهم كوسيلة إعلانية.</p>
                    <p>نحن نؤمن بقوة الإعلان المحلي والتسويق المستهدف، ونسعى جاهدين لتوفير تجربة سلسة وفعالة لكل من
                        المعلنين ومالكي السيارات.</p>
                </div>
                <div class="about-image">
                    <img src="{{ asset('image1_large.jpg') }}" alt="سيارة بإعلان">
                </div>
            </div>
        </section>

        <section id="goals" class="goals-section">
            <h2>أهدافنا</h2>
            <div class="goals-grid">
                <div class="goal-card">
                    <div class="goal-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>تعزيز الإعلانات المحلية</h3>
                    <p>نسعى لدعم الأعمال المحلية من خلال توفير وسيلة إعلانية فعالة وبأسعار معقولة تصل إلى الجمهور
                        المستهدف مباشرة.</p>
                </div>
                <div class="goal-card">
                    <div class="goal-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3>تسهيل الوصول لخدمات الملصقات</h3>
                    <p>نوفر منصة سهلة الاستخدام تربط بين مالكي السيارات وشركات الإعلان ومصممي الملصقات المحترفين.</p>
                </div>
                <div class="goal-card">
                    <div class="goal-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3>خلق فرص دخل إضافية</h3>
                    <p>نمكن مالكي السيارات من تحقيق دخل إضافي من خلال تحويل سياراتهم إلى وسائل إعلانية متنقلة.</p>
                </div>
            </div>
        </section>

        <section id="customers" class="customers">
            <h2>عملاؤنا</h2>
            <div class="join-content">
                <p>
                    نفتخر بشراكتنا الناجحة مع مجموعة متميزة من العملاء الذين وثقوا بخدماتنا. في قسم عملائنا، نعرض شعارات
                    الشركات والمؤسسات الرائدة التي اخترتنا كشريك موثوق لتحقيق أهدافها. هذه الشراكات تشهد على جودة
                    خدماتنا والتزامنا بتلبية توقعات عملائنا. كما نشارك آراء وتقييمات بعض عملائنا الكرام التي تعكس
                    تجاربهم الحقيقية مع فريقنا.
                </p>
                <div class="image-label-container">
                    @foreach($customers as $customer)
                    <div class="image-label-item">
                        <img src="{{ asset($customer['logo']) }}" alt="{{ $customer['name'] }}" class="inline-icon">
                        <span class="image-label">{{ $customer['name'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="join" class="join-section">
            <h2>انضم إلينا</h2>
            <div class="join-content">
                <p>هل ترغب في أن تصبح جزءًا من مجتمعنا المتنامي؟ سواء كنت صاحب عمل تبحث عن وسيلة إعلانية مبتكرة، أو مالك
                    سيارة ترغب في كسب دخل إضافي، يمكنك الانضمام إلينا اليوم!</p>
                <p>للتسجيل، ما عليك سوى ملء نموذج الاتصال أدناه وسنقوم بالتواصل معك لتزويدك بكافة التفاصيل وخطوات البدء.
                </p>
                <p>كما يمكنك تحميل تطبيقنا للهواتف الذكية للوصول إلى جميع ميزاتنا أينما كنت.</p>
                <a href="#contact" class="btn join-btn">انضم إلينا الآن</a>
            </div>
        </section>

        <section id="stats" class="stats-section">
            <h2>إحصائيات الزيارات</h2>
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['monthly_visitors'] }}+</div>
                    <div class="stat-label">زائر شهريًا</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['active_ads'] }}+</div>
                    <div class="stat-label">إعلان نشط</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['registered_cars'] }}+</div>
                    <div class="stat-label">سيارة مسجلة</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['satisfaction_rate'] }}%</div>
                    <div class="stat-label">رضا العملاء</div>
                </div>
            </div>
        </section>

        <section id="download" class="download-section">
            <h2>حمل تطبيقنا الآن</h2>
            <p>احصل على تجربة أفضل من خلال تطبيقنا المخصص للهواتف الذكية. تصفح الإعلانات، تواصل مع المعلنين، وأدر حملاتك
                الإعلانية من أي مكان وفي أي وقت.</p>
            <div class="download-links">
                <a href="{{ $appLinks['android'] }}" class="download-link android">
                    <span>Google Play</span>
                    <i class="fab fa-google-play download-icon"></i>
                </a>
                <a href="{{ $appLinks['ios'] }}" class="download-link ios">
                    <span>App Store</span>
                    <i class="fab fa-apple download-icon"></i>
                </a>
            </div>
        </section>

        <section id="contact" class="contact-section">
            <h2>اتصل بنا</h2>
            <form class="contact-form" id="contactForm" action="{{ route('landing.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">الاسم الكامل</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">الرسالة</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="btn">إرسال الرسالة</button>
            </form>
        </section>
    </div>

    <footer>
        <h3>إعلانات السيارات وملصقات السيارات</h3>
        <div class="social-links">
            <a href="{{ $socialLinks['facebook'] }}"><i class="fab fa-facebook-f"></i></a>
            <a href="{{ $socialLinks['twitter'] }}"><i class="fab fa-twitter"></i></a>
            <a href="{{ $socialLinks['instagram'] }}"><i class="fab fa-instagram"></i></a>
            <a href="{{ $socialLinks['linkedin'] }}"><i class="fab fa-linkedin-in"></i></a>
            <a href="{{ $socialLinks['youtube'] }}"><i class="fab fa-youtube"></i></a>
        </div>
        <p class="copyright">جميع الحقوق محفوظة &copy; {{ date('Y') }}</p>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
