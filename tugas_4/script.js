document.addEventListener('DOMContentLoaded', () => {
    // 1. Targetkan BODY (Bukan HTML) biar sinkron sama PHP & CSS
    const body = document.body;
    const toggleBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');

    // 2. Fungsi Ganti Ikon
    function updateIcon(isDark) {
        if (!themeIcon) return;
        if (isDark) {
            themeIcon.classList.remove('ri-moon-line');
            themeIcon.classList.add('ri-sun-line'); // Jadi Matahari
        } else {
            themeIcon.classList.remove('ri-sun-line');
            themeIcon.classList.add('ri-moon-line'); // Jadi Bulan
        }
    }

    // 3. Cek Status Awal dari LocalStorage
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        body.classList.add('dark-mode'); // Paksa Body jadi gelap
        updateIcon(true);
    }

    // 4. Event Klik Tombol
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            // A. Toggle Class di BODY
            body.classList.toggle('dark-mode');
            
            // B. Cek status sekarang (Gelap/Terang?)
            const isDarkMode = body.classList.contains('dark-mode');

            // C. Simpan ke Memori Browser
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
            
            // D. Update Ikon
            updateIcon(isDarkMode);
        });
    }

    // --- LOGIKA SLIDER (Tetap dipertahankan) ---
    const slides = document.querySelectorAll('.slide');
    if (slides.length > 0) {
        let currentSlide = 0;
        const slideInterval = 5000;
        
        function nextSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }
        setInterval(nextSlide, slideInterval);
    }
});