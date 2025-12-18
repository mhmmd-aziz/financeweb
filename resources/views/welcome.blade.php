<!doctype html>
<html lang="en" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cashely - Smart Money Management</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">
  <script src="/_sdk/element_sdk.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { box-sizing: border-box; }
    * { transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease; }
    @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(5deg); } }
    @keyframes slideInLeft { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes scaleIn { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-slide-left { animation: slideInLeft 0.6s ease-out forwards; }
    .animate-slide-right { animation: slideInRight 0.6s ease-out forwards; }
    .animate-scale { animation: scaleIn 0.5s ease-out forwards; }
    .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover:hover { transform: translateY(-12px); }
    .gradient-text { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .theme-transition { transition: all 0.3s ease; }
    .glass-effect { backdrop-filter: blur(10px); }
  </style>
  <style>@view-transition { navigation: auto; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full overflow-auto">
  <div id="app" class="w-full h-full theme-transition" style="min-height: 100%;">
   
   <nav id="nav" class="fixed top-0 left-0 right-0 z-50 glass-effect">
    <div class="max-w-7xl mx-auto px-6 py-4">
     <div class="flex items-center justify-between">
      
      <div class="flex items-center gap-3">
        <img 
            id="logo-icon"
            src="{{ asset('images/logoc.png') }}" 
            alt="Logo Cashly" 
            class="h-12 w-auto object-contain"
        >
        </div>

      <div class="hidden md:flex gap-8 items-center">
        <a href="#features" id="nav-features" class="hover:opacity-70 transition-opacity font-medium">Fitur</a> 
        <a href="#pricing" id="nav-pricing" class="hover:opacity-70 transition-opacity font-medium">Harga</a> 
        <a href="#testimonials" id="nav-testimonials" class="hover:opacity-70 transition-opacity font-medium">Testimoni</a>
      </div>
      <div class="flex items-center gap-4">
        <button id="theme-toggle" class="w-10 h-10 rounded-lg flex items-center justify-center hover:scale-110 transition-transform" aria-label="Toggle theme"> <span id="theme-icon" class="text-2xl">🌙</span> </button> 
        <button id="nav-login" class="px-6 py-2 rounded-full font-semibold hover:scale-105 transition-transform border-2">Masuk</button> 
        <button id="nav-register" class="px-6 py-2 rounded-full font-semibold hover:scale-105 transition-transform">Daftar</button>
      </div>
     </div>
    </div>
   </nav>

   <section id="hero" class="relative pt-32 pb-20 px-6 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
     <div id="float-1" class="absolute top-20 left-10 w-72 h-72 rounded-full opacity-20 blur-3xl animate-float" style="animation-delay: 0s;"></div>
     <div id="float-2" class="absolute bottom-20 right-10 w-96 h-96 rounded-full opacity-20 blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>
    <div class="max-w-7xl mx-auto relative z-10">
     <div class="grid md:grid-cols-2 gap-12 items-center">
      <div class="animate-slide-left">
       <div class="inline-block px-4 py-2 rounded-full mb-6 text-sm font-semibold" id="hero-badge">
        ✨  Atur keungan dengan mudah
       </div>
       <h1 id="hero-title" class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Atur Keuangan Mu Dengan Mudah <span class="gradient-text">Cashely</span></h1>
       <p id="hero-subtitle" class="text-xl mb-8 opacity-80">Website Untuk Manajemen Keunagan, Dengan grafik dan vissualisasi dengan mudah</p>
       <div class="flex flex-wrap gap-4"><button id="cta-primary-hero" class="px-8 py-4 rounded-full font-bold text-lg hover:scale-105 transition-transform shadow-lg"> Mulai Sekarang Gratis</div>
      </div>
      <div class="relative animate-slide-right">
       <div class="relative z-10">
        <svg viewbox="0 0 400 500" class="w-full drop-shadow-2xl"><rect x="50" y="20" width="300" height="460" rx="40" id="phone-frame" fill="#1f2937" /> <rect x="65" y="35" width="270" height="430" rx="30" id="phone-screen" fill="#111827" /> <circle cx="200" cy="55" r="3" fill="#6366f1" opacity="0.5" /> <rect x="250" y="52" width="30" height="6" rx="3" fill="#10b981" opacity="0.7" /> <rect x="90" y="80" width="220" height="120" rx="20" fill="url(#cardGradient)" /> <text x="110" y="110" fill="white" opacity="0.8" font-size="14" font-weight="500"> Total Saldo </text> <text x="110" y="145" fill="white" font-size="32" font-weight="bold"> Rp 24,5 jt </text> <text x="110" y="175" fill="#10b981" font-size="14"> ↗ +12.5% bulan ini </text> <rect x="90" y="220" width="100" height="80" rx="15" id="stat-card-1" fill="#6366f1" opacity="0.2" /> <rect x="210" y="220" width="100" height="80" rx="15" id="stat-card-2" fill="#10b981" opacity="0.2" /> <text x="110" y="245" fill="#6366f1" font-size="12" font-weight="600"> Pemasukan </text> <text x="110" y="270" fill="currentColor" font-size="20" font-weight="bold"> 8,4 jt </text> <circle cx="270" cy="250" r="15" fill="#10b981" opacity="0.3" /> <text x="230" y="245" fill="#10b981" font-size="12" font-weight="600"> Pengeluaran </text> <text x="230" y="270" fill="currentColor" font-size="20" font-weight="bold"> 3,2 jt </text> <rect x="90" y="320" width="220" height="50" rx="12" id="trans-1" fill="#374151" opacity="0.3" /> <circle cx="110" cy="345" r="12" fill="#f59e0b" /> <text x="135" y="343" fill="currentColor" font-size="13" font-weight="600"> Belanja </text> <text x="135" y="357" fill="currentColor" opacity="0.6" font-size="11"> Tokopedia </text> <text x="275" y="350" fill="currentColor" font-size="14" font-weight="bold" text-anchor="end"> -156rb </text> <rect x="90" y="380" width="220" height="50" rx="12" id="trans-2" fill="#374151" opacity="0.3" /> <circle cx="110" cy="405" r="12" fill="#10b981" /> <text x="135" y="403" fill="currentColor" font-size="13" font-weight="600"> Gaji </text> <text x="135" y="417" fill="currentColor" opacity="0.6" font-size="11"> PT Abadi </text> <text x="275" y="410" fill="#10b981" font-size="14" font-weight="bold" text-anchor="end"> +3,2 jt </text> <defs> <lineargradient id="cardGradient" x1="0%" y1="0%" x2="100%" y2="100%"> <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" /> <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" /> </lineargradient> </defs> </svg>
       </div>
       <div class="absolute -top-8 -right-8 px-6 py-4 rounded-2xl shadow-xl animate-float" id="float-card-1" style="animation-delay: 1s;">
        <div class="text-3xl mb-2">📈</div> <div class="font-bold text-sm">+25%</div> <div class="text-xs opacity-70">Tabungan</div>
       </div>
       <div class="absolute -bottom-8 -left-8 px-6 py-4 rounded-2xl shadow-xl animate-float" id="float-card-2" style="animation-delay: 3s;">
        <div class="text-3xl mb-2">🎯</div> <div class="font-bold text-sm">Target Tercapai!</div> <div class="text-xs opacity-70">Rp 5 juta</div>
       </div>
      </div>
     </div>
    </div>
   </section>

   <section id="features" class="py-20 px-6">
    <div class="max-w-7xl mx-auto">
     <div class="text-center mb-16 animate-scale">
      <h2 id="features-title" class="text-4xl md:text-5xl font-bold mb-4 gradient-text">Fitur Kami</h2>
      <p id="features-subtitle" class="text-xl opacity-80">Semua yang kamu butuhkan untuk meanajemen keuangan anda</p>
     </div>
     <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="card-hover rounded-3xl p-8" id="feature-card-1">
       <div class="text-5xl mb-4">📊</div> <h3 id="feature-1-title" class="text-2xl font-bold mb-3">Smart Tracking</h3> <p id="feature-1-desc" class="opacity-80">Monitoring Progres Target, Saldo dll</p>
      </div>
      <div class="card-hover rounded-3xl p-8" id="feature-card-2">
       <div class="text-5xl mb-4">🎯</div> <h3 id="feature-2-title" class="text-2xl font-bold mb-3">Budget Goals</h3> <p id="feature-2-desc" class="opacity-80"> Buat target don monitoring progres target</p>
      </div>
      <div class="card-hover rounded-3xl p-8" id="feature-card-3">
       <div class="text-5xl mb-4">💡</div> <h3 id="feature-3-title" class="text-2xl font-bold mb-3">Insights</h3> <p id="feature-3-desc" class="opacity-80">Insight dengan grafik dan visualisasi mudah</p>
      </div>
      <div class="card-hover rounded-3xl p-8" id="feature-card-4">
       <div class="text-5xl mb-4">🔐</div> <h3 id="feature-4-title" class="text-2xl font-bold mb-3">Aman</h3> <p id="feature-4-desc" class="opacity-80">Karena hanya mencatat aja</p>
      </div>
     </div>
    </div>
   </section>

   <section class="py-20 px-6">
    <div class="max-w-4xl mx-auto text-center rounded-3xl p-12" id="final-cta">
     <h2 class="text-4xl md:text-5xl font-bold mb-6">Siap Mengontrol Keuangan Anda?</h2>
     <p class="text-xl mb-8 opacity-90">Bergabung dengan ribuan pengguna yang sudah mengelola uang lebih cerdas</p><button id="cta-final" class="px-10 py-5 rounded-full font-bold text-xl hover:scale-105 transition-transform shadow-xl"> Mulai Gratis Sekarang </button>
    </div>
   </section>

   <footer class="py-8 px-6 border-t" id="footer">
    <div class="max-w-7xl mx-auto text-center">
     <p id="footer-text" class="opacity-70">© 2024 Keuanganku. Hak cipta dilindungi.</p>
    </div>
   </footer>
  </div>

  <script>
    let isDarkMode = true;
    
    // Backend routes dari Laravel
    const routes = {
      userLogin: '/app/login',
      userRegister: '/app/register',
      userDashboard: '/app',
    };

    const defaultConfig = {
      background_color: '#0a0a1a',
      surface_color: '#1a1a2e',
      text_color: '#ffffff',
      primary_action_color: '#6366f1',
      secondary_action_color: '#8b5cf6',
      site_title: 'Cashely',
      nav_features: 'Fitur',
      nav_pricing: 'Harga',
      nav_testimonials: 'Testimoni',
      hero_title: 'Kelola Uang Anda Lebih Cerdas',
      hero_subtitle: 'Lacak pengeluaran, atur anggaran, dan capai tujuan keuangan Anda dengan platform kami',
      cta_primary: 'Daftar Gratis',
      cta_secondary: 'Lihat Demo',
      cta_login: 'Masuk',
      features_title: 'Fitur Lengkap',
      features_subtitle: 'Semua yang Anda butuhkan untuk mengontrol keuangan',
      feature_1_title: 'Pelacakan Otomatis',
      feature_1_desc: 'Kategorikan dan lacak semua transaksi Anda secara otomatis dan real-time',
      feature_2_title: 'Target Anggaran',
      feature_2_desc: 'Tetapkan dan pantau batas pengeluaran Anda dengan mudah dan notifikasi pintar',
      feature_3_title: 'Analisis Keuangan',
      feature_3_desc: 'Dapatkan wawasan keuangan personal dan rekomendasi dari AI',
      feature_4_title: 'Sinkronisasi Aman',
      feature_4_desc: 'Keamanan setara bank dengan sinkronisasi otomatis di semua perangkat Anda',
      pricing_title: 'Harga Sederhana',
      plan_free_title: 'Gratis',
      plan_free_price: 'Rp 0',
      plan_pro_title: 'Pro',
      plan_pro_price: 'Rp 49.000',
      testimonials_title: 'Dipercaya Pengguna',
      testimonial_1_text: '"Keuanganku benar-benar mengubah hidup finansial saya! Akhirnya saya punya kontrol penuh atas pengeluaran."',
      testimonial_1_author: 'Siti Nurhaliza',
      testimonial_2_text: '"Aplikasi budgeting terbaik yang pernah saya pakai. Sangat intuitif dan wawasannya sangat membantu!"',
      testimonial_2_author: 'Budi Santoso',
      testimonial_3_text: '"Akhirnya berhasil mencapai target tabungan saya berkat Keuanganku! Fitur pelacakannya luar biasa."',
      testimonial_3_author: 'Dewi Lestari',
      footer_text: '© 2024 Keuanganku. Hak cipta dilindungi.',
      font_family: 'Inter, system-ui, sans-serif',
      font_size: 16
    };

    function toggleTheme() {
      isDarkMode = !isDarkMode;
      applyTheme();
    }

    function applyTheme() {
      const config = window.elementSdk ? window.elementSdk.config : defaultConfig;
      const bgColor = config.background_color || defaultConfig.background_color;
      const surfaceColor = config.surface_color || defaultConfig.surface_color;
      const textColor = config.text_color || defaultConfig.text_color;
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;
      const secondaryColor = config.secondary_action_color || defaultConfig.secondary_action_color;
      
      if (isDarkMode) {
        document.body.style.background = `linear-gradient(to bottom, ${bgColor}, ${surfaceColor})`;
        document.body.style.color = textColor;
        document.getElementById('theme-icon').textContent = '🌙';
        
        // Nav
        document.getElementById('nav').style.background = `rgba(26, 26, 46, 0.8)`;
        document.getElementById('nav').style.borderBottom = '1px solid rgba(255, 255, 255, 0.1)';
        
        // --- BAGIAN INI DIMATIKAN AGAR LOGO TIDAK BIRU ---
        // document.getElementById('logo-icon').style.background = primaryColor;
        
        document.getElementById('nav-login').style.background = 'transparent';
        document.getElementById('nav-login').style.borderColor = primaryColor;
        document.getElementById('nav-login').style.color = textColor;
        document.getElementById('nav-register').style.background = primaryColor;
        document.getElementById('nav-register').style.color = '#fff';
        
        // Hero
        document.getElementById('float-1').style.background = primaryColor;
        document.getElementById('float-2').style.background = secondaryColor;
        document.getElementById('hero-badge').style.background = 'rgba(99, 102, 241, 0.2)';
        document.getElementById('hero-badge').style.color = primaryColor;
        document.getElementById('cta-primary-hero').style.background = primaryColor;
        document.getElementById('cta-primary-hero').style.color = '#fff';
        document.getElementById('cta-secondary-hero').style.borderColor = primaryColor;
        document.getElementById('cta-secondary-hero').style.color = textColor;
        
        // Float cards
        document.getElementById('float-card-1').style.background = surfaceColor;
        document.getElementById('float-card-1').style.color = textColor;
        document.getElementById('float-card-2').style.background = surfaceColor;
        document.getElementById('float-card-2').style.color = textColor;
        
        // Feature cards
        for (let i = 1; i <= 4; i++) {
          const card = document.getElementById(`feature-card-${i}`);
          card.style.background = 'rgba(255, 255, 255, 0.05)';
          card.style.color = textColor;
        }
        
        // Pricing cards (Jika ada)
        const pCard1 = document.getElementById('pricing-card-1'); if(pCard1) {
            pCard1.style.background = 'rgba(255, 255, 255, 0.05)';
            pCard1.style.borderColor = 'rgba(255, 255, 255, 0.1)';
            pCard1.style.color = textColor;
        }
        const pCard2 = document.getElementById('pricing-card-2'); if(pCard2) {
            pCard2.style.background = primaryColor;
            pCard2.style.color = '#fff';
        }
        
        const planFreeBtn = document.getElementById('plan-free-btn'); if(planFreeBtn) {
            planFreeBtn.style.borderColor = primaryColor;
            planFreeBtn.style.color = textColor;
        }
        const planProBtn = document.getElementById('plan-pro-btn'); if(planProBtn) {
            planProBtn.style.background = '#fff';
            planProBtn.style.color = primaryColor;
        }
        
        // Final CTA
        document.getElementById('final-cta').style.background = 'rgba(99, 102, 241, 0.1)';
        document.getElementById('final-cta').style.color = textColor;
        document.getElementById('cta-final').style.background = primaryColor;
        document.getElementById('cta-final').style.color = '#fff';
        
        // Footer
        document.getElementById('footer').style.borderColor = 'rgba(255, 255, 255, 0.1)';
        document.getElementById('footer').style.color = textColor;
        
      } else {
        document.body.style.background = 'linear-gradient(to bottom, #f9fafb, #ffffff)';
        document.body.style.color = '#111827';
        document.getElementById('theme-icon').textContent = '☀️';
        
        // Nav
        document.getElementById('nav').style.background = 'rgba(255, 255, 255, 0.8)';
        document.getElementById('nav').style.borderBottom = '1px solid rgba(0, 0, 0, 0.1)';
        
        // --- BAGIAN INI DIMATIKAN AGAR LOGO TIDAK BIRU ---
        // document.getElementById('logo-icon').style.background = primaryColor;
        
        document.getElementById('nav-login').style.background = 'transparent';
        document.getElementById('nav-login').style.borderColor = primaryColor;
        document.getElementById('nav-login').style.color = '#111827';
        document.getElementById('nav-register').style.background = primaryColor;
        document.getElementById('nav-register').style.color = '#fff';
        
        // Hero
        document.getElementById('float-1').style.background = primaryColor;
        document.getElementById('float-2').style.background = secondaryColor;
        document.getElementById('hero-badge').style.background = 'rgba(99, 102, 241, 0.1)';
        document.getElementById('hero-badge').style.color = primaryColor;
        document.getElementById('cta-primary-hero').style.background = primaryColor;
        document.getElementById('cta-primary-hero').style.color = '#fff';
        document.getElementById('cta-secondary-hero').style.borderColor = primaryColor;
        document.getElementById('cta-secondary-hero').style.color = '#111827';
        
        // Float cards
        document.getElementById('float-card-1').style.background = '#ffffff';
        document.getElementById('float-card-1').style.color = '#111827';
        document.getElementById('float-card-2').style.background = '#ffffff';
        document.getElementById('float-card-2').style.color = '#111827';
        
        // Feature cards
        for (let i = 1; i <= 4; i++) {
          const card = document.getElementById(`feature-card-${i}`);
          card.style.background = '#ffffff';
          card.style.color = '#111827';
        }
        
        // Pricing
        const pCard1 = document.getElementById('pricing-card-1'); if(pCard1) {
            pCard1.style.background = '#ffffff';
            pCard1.style.borderColor = 'rgba(0, 0, 0, 0.1)';
            pCard1.style.color = '#111827';
        }
        const pCard2 = document.getElementById('pricing-card-2'); if(pCard2) {
            pCard2.style.background = primaryColor;
            pCard2.style.color = '#fff';
        }

        const planFreeBtn = document.getElementById('plan-free-btn'); if(planFreeBtn) {
            planFreeBtn.style.borderColor = primaryColor;
            planFreeBtn.style.color = '#111827';
        }
        const planProBtn = document.getElementById('plan-pro-btn'); if(planProBtn) {
            planProBtn.style.background = '#fff';
            planProBtn.style.color = primaryColor;
        }
        
        // Final CTA
        document.getElementById('final-cta').style.background = 'rgba(99, 102, 241, 0.05)';
        document.getElementById('final-cta').style.color = '#111827';
        document.getElementById('cta-final').style.background = primaryColor;
        document.getElementById('cta-final').style.color = '#fff';
        
        // Footer
        document.getElementById('footer').style.borderColor = 'rgba(0, 0, 0, 0.1)';
        document.getElementById('footer').style.color = '#111827';
      }
    }

    async function onConfigChange(config) {
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;
      const secondaryColor = config.secondary_action_color || defaultConfig.secondary_action_color;
      const baseSize = config.font_size || defaultConfig.font_size;
      
      applyTheme();
      
      // Update gradient text
      document.querySelectorAll('.gradient-text').forEach(el => {
        el.style.background = `linear-gradient(135deg, ${primaryColor} 0%, ${secondaryColor} 100%)`;
        el.style.webkitBackgroundClip = 'text';
        el.style.webkitTextFillColor = 'transparent';
        el.style.backgroundClip = 'text';
      });
      
      // Update text content (hanya sebagian agar aman)
      if(document.getElementById('logo-text')) document.getElementById('logo-text').textContent = config.site_title || defaultConfig.site_title;
    }

    // Initialize
    onConfigChange(defaultConfig);
    
    // Theme toggle
    document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
    
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
    
    // --- PERBAIKAN NAVIGATION FUNCTIONS (TIDAK BUKA TAB BARU) ---
    function navigateToUserLogin() {
      window.location.href = routes.userLogin; // Menggunakan href agar tetap di tab sama
    }
    
    function navigateToUserRegister() {
      window.location.href = routes.userRegister;
    }
    
    function navigateToUserDashboard() {
      window.location.href = routes.userDashboard;
    }
    
    // Attach event listeners to buttons
    document.getElementById('nav-login').addEventListener('click', navigateToUserLogin);
    document.getElementById('nav-register').addEventListener('click', navigateToUserRegister);
    document.getElementById('cta-primary-hero').addEventListener('click', navigateToUserRegister);
    document.getElementById('cta-secondary-hero').addEventListener('click', (e) => {
      e.preventDefault();
      const demoSection = document.getElementById('features');
      if (demoSection) {
        demoSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
    const freeBtn = document.getElementById('plan-free-btn'); if(freeBtn) freeBtn.addEventListener('click', navigateToUserRegister);
    const proBtn = document.getElementById('plan-pro-btn'); if(proBtn) proBtn.addEventListener('click', navigateToUserRegister);
    document.getElementById('cta-final').addEventListener('click', navigateToUserRegister);
  </script>
 </body>
</html>