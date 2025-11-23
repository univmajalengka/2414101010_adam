// --- 1. KONEKSI KE SUPABASE ---
const SUPABASE_URL = 'https://dalvxyyjyrxzgsxaaecm.supabase.co';
const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImRhbHZ4eXlqeXJ4emdzeGFhZWNtIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjMzOTA3MDMsImV4cCI6MjA3ODk2NjcwM30.ki_odtAUlowB1s0JnIx5YC4ftmYqHo6IWQZ_LHbPVas';

const supabase = window.supabase.createClient(SUPABASE_URL, SUPABASE_KEY);

// --- 2. LOGIKA RENDER DATA ---

async function loadSiteContent() {
    const { data, error } = await supabase.from('site_content').select('key_name, content_value');
    if (error) return console.error('Error site_content:', error);
    const content = data.reduce((acc, item) => { acc[item.key_name] = item.content_value; return acc; }, {});
    
    const setIds = ['page_title', 'main_title', 'main_subtitle', 'video_caption', 'hero_subtitle'];
    setIds.forEach(id => { if(document.getElementById(id)) document.getElementById(id).innerText = content[id.replace('page_', 'main_')] || content[id]; });
}

// Fungsi untuk memuat opsi paket ke dalam dropdown formulir
async function loadPackageOptions() {
    const { data, error } = await supabase.from('packages').select('id, title');
    if (error) return console.error('Error loadPackageOptions:', error);

    const selectElement = document.getElementById('form-paket');
    if (selectElement) {
        data.forEach(pkg => {
            const option = document.createElement('option');
            option.value = pkg.title; // Kita simpan Nama Paketnya
            option.textContent = pkg.title;
            selectElement.appendChild(option);
        });

        // Cek apakah ada pre-selected paket dari URL (misal dari halaman detail)
        const urlParams = new URLSearchParams(window.location.search);
        const preSelected = urlParams.get('paket');
        if (preSelected) {
            selectElement.value = decodeURIComponent(preSelected);
        }
    }
}

async function loadPackages() {
    const { data, error } = await supabase.from('packages').select('*');
    if (error) return console.error('Error packages:', error);
    
    const container = document.getElementById('paket-wisata-container');
    if (!container) return;
    container.innerHTML = ''; 

    data.forEach(pkg => {
        const cardHtml = `
            <article class="flex flex-col md:flex-row bg-ios-card-light dark:bg-ios-card-dark rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <img src="${pkg.image_url}" alt="${pkg.title}" class="h-48 w-full md:w-60 object-cover">
                <div class="p-5 flex flex-col justify-between w-full">
                    <div>
                        <small class="text-gray-500 dark:text-gray-400">🗓️ Pilihan Paket</small>
                        <h3 class="text-xl font-bold mt-1">${pkg.title}</h3> 
                        <p class="text-lg font-semibold text-ios-primary mt-3">${pkg.price_info}</p>
                    </div>
                    <a href="detail.html?id=${pkg.id}" class="mt-4 inline-block px-5 py-2 bg-ios-secondary text-white text-sm font-medium rounded-lg shadow-sm hover:bg-orange-600 transition w-fit">
                        Lihat Detail
                    </a>
                </div>
            </article>`;
        container.innerHTML += cardHtml;
    });
}

// --- 3. JALANKAN LOGIKA ---
document.addEventListener('DOMContentLoaded', () => {
    loadSiteContent();
    loadPackages();
    loadPackageOptions(); // <-- MEMUAT DROPDOWN PAKET

    // -- Nav & Dark Mode --
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('nav-menu');
    if (menuToggle && navMenu) menuToggle.addEventListener('click', () => navMenu.classList.toggle('hidden'));

    const themeBtns = [document.getElementById('theme-toggle'), document.getElementById('theme-toggle-mobile')];
    const sunIcon = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M12 12a5 5 0 100-10 5 5 0 000 10z"></path></svg>`;
    const moonIcon = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>`;
    
    const applyTheme = () => {
        const isDark = localStorage.getItem('theme') === 'dark';
        if (isDark) { document.documentElement.classList.add('dark'); themeBtns.forEach(b => {if(b) b.innerHTML = sunIcon}); }
        else { document.documentElement.classList.remove('dark'); themeBtns.forEach(b => {if(b) b.innerHTML = moonIcon}); }
    };
    themeBtns.forEach(b => { if(b) b.addEventListener('click', () => {
        localStorage.setItem('theme', localStorage.getItem('theme') === 'dark' ? 'light' : 'dark');
        applyTheme();
    })});
    applyTheme();
// --- 3. LOGIKA ACTIVE NAV ON SCROLL ---
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('ul#nav-links li a.nav-link');

    if (sections.length > 0 && navLinks.length > 0) {
        
        // ==== INI PERBAIKANNYA ====
        const observerOptions = {
            root: null,
            // TRIK JITU: Kita set margin negatif 50% dari atas dan bawah.
            // Artinya: JS hanya akan mendeteksi section yang menyentuh GARIS TENGAH layar.
            // Ini sangat akurat untuk section pendek maupun panjang.
            rootMargin: '-50% 0px -50% 0px', 
            threshold: 0
        };
        // ==========================

        const observerCallback = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(link => {
                        link.classList.remove('nav-active');
                    });
                    
                    const activeLink = document.querySelector(`ul#nav-links li a[href="#${entry.target.id}"]`);
                    if (activeLink) {
                        activeLink.classList.add('nav-active');
                    }
                }
            });
        };

        const observer = new IntersectionObserver(observerCallback, observerOptions);
        sections.forEach(section => {
            observer.observe(section);
        });
    }
    // -- Form Booking --
    const bookingForm = document.getElementById('booking-form');
    const submitButton = document.getElementById('form-submit-button');
    const formStatus = document.getElementById('form-status');

    if (bookingForm) {
        bookingForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            submitButton.disabled = true; submitButton.innerText = 'Mengirim...'; 
            formStatus.innerText = ''; formStatus.classList.remove('text-red-500', 'text-green-500');

            try {
                const ktpFile = document.getElementById('form-ktp').files[0];
                const kkFile = document.getElementById('form-kk').files[0];
                // VALIDASI FILE DAN PAKET
                if (!ktpFile || !kkFile) throw new Error('Harap upload file KTP dan KK.');
                const selectedPaket = document.getElementById('form-paket').value;
                if (!selectedPaket) throw new Error('Harap pilih paket wisata.');

                const ktpPath = `public/ktp-${Date.now()}-${ktpFile.name}`;
                const kkPath = `public/kk-${Date.now()}-${kkFile.name}`;

                const { data: ktpData, error: ktpErr } = await supabase.storage.from('dokumen-pemesanan').upload(ktpPath, ktpFile);
                if (ktpErr) throw ktpErr;
                const { data: kkData, error: kkErr } = await supabase.storage.from('dokumen-pemesanan').upload(kkPath, kkFile);
                if (kkErr) throw kkErr;

                const formData = {
                    nama: document.getElementById('form-nama').value,
                    alamat: document.getElementById('form-alamat').value,
                    nomor_wa: document.getElementById('form-wa').value,
                    jumlah_orang: parseInt(document.getElementById('form-jumlah').value),
                    nama_paket: selectedPaket, // <-- KIRIM NAMA PAKET KE SUPABASE
                    setuju_aturan: document.getElementById('form-aturan').checked,
                    setuju_syarat: document.getElementById('form-syarat').checked,
                    ktp_url: ktpData.path, kk_url: kkData.path
                };

                const { error: dbErr } = await supabase.from('bookings').insert(formData);
                if (dbErr) throw dbErr;

                formStatus.innerText = 'Pemesanan berhasil!'; formStatus.classList.add('text-green-500'); 
                bookingForm.reset();
            } catch (error) {
                console.error(error); formStatus.innerText = `Error: ${error.message}`; formStatus.classList.add('text-red-500');
            } finally {
                submitButton.disabled = false; submitButton.innerText = 'Kirim Pemesanan';
            }
        });
    }
    // ... (kode form booking Anda di atas sini) ...

    // =============================================
    // ===== LOGIKA HERO SLIDER (BARU) =====
    // =============================================
    const slides = document.querySelectorAll('.hero-slide');
    let currentSlide = 0;
    const slideInterval = 5000; // Ganti gambar setiap 5000ms (5 detik)

    if (slides.length > 0) {
        setInterval(() => {
            // 1. Sembunyikan slide saat ini
            slides[currentSlide].classList.remove('opacity-100');
            slides[currentSlide].classList.add('opacity-0');

            // 2. Pindah ke slide berikutnya (looping)
            currentSlide = (currentSlide + 1) % slides.length;

            // 3. Tampilkan slide baru
            slides[currentSlide].classList.remove('opacity-0');
            slides[currentSlide].classList.add('opacity-100');
        }, slideInterval);
    }
    // =============================================


// ... (kode form booking Anda di atas sini) ...

    // =============================================
    // ===== LOGIKA GALERI SLIDER MANUAL =====
    // =============================================
    const galleryTrack = document.getElementById('gallery-track');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    
    // Kita punya 2 gambar, indexnya 0 dan 1
    let galleryIndex = 0; 
    const totalSlides = 2; 

    // Fungsi untuk update posisi slider
    const updateGalleryPosition = () => {
        // Geser track berdasarkan index (0% atau -100%)
        galleryTrack.style.transform = `translateX(-${galleryIndex * 100}%)`;
    };

    if (prevBtn && nextBtn && galleryTrack) {
        // Klik Tombol Next
        nextBtn.addEventListener('click', () => {
            galleryIndex = (galleryIndex + 1) % totalSlides; // Loop kembali ke 0 jika sudah habis
            updateGalleryPosition();
        });

        // Klik Tombol Prev
        prevBtn.addEventListener('click', () => {
            galleryIndex = (galleryIndex - 1 + totalSlides) % totalSlides; // Loop mundur
            updateGalleryPosition();
        });
    }
    // =============================================

}); // <-- INI KURUNG TUTUP PENUTUP DARI document.addEventListener