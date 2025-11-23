// --- 1. KONEKSI KE SUPABASE ---
const SUPABASE_URL = 'https://dalvxyyjyrxzgsxaaecm.supabase.co';
const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImRhbHZ4eXlqeXJ4emdzeGFhZWNtIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjMzOTA3MDMsImV4cCI6MjA3ODk2NjcwM30.ki_odtAUlowB1s0JnIx5YC4ftmYqHo6IWQZ_LHbPVas';
const supabase = window.supabase.createClient(SUPABASE_URL, SUPABASE_KEY);

document.addEventListener('DOMContentLoaded', async () => {
    
    // --- 2. LOGIKA MENGAMBIL DETAIL PAKET ---
    
    const urlParams = new URLSearchParams(window.location.search);
    const packageId = urlParams.get('id');

    if (packageId) {
        // B. Fetch data dari Supabase berdasarkan ID
        const { data, error } = await supabase
            .from('packages')
            .select('*')
            .eq('id', packageId)
            .single();

        if (error) {
            console.error("Error:", error);
            document.getElementById('loading').innerText = "Gagal memuat data. Paket tidak ditemukan.";
        } else {
            // C. Tampilkan data ke HTML
            // Pastikan 'title', 'description', 'price_info', 'image_url' sesuai nama kolom di Supabase Anda
            document.getElementById('detail-title').innerText = data.title; 
            document.getElementById('detail-desc').innerText = data.description;
            document.getElementById('detail-price').innerText = data.price_info;
            document.getElementById('detail-img').src = data.image_url;
            document.getElementById('detail-page-title').innerText = `${data.title} - Desa Wisata`;

            // ============================================================
            // [BARU] UPDATE TOMBOL PESAN AGAR MEMBAWA NAMA PAKET
            // ============================================================
            const pesanBtn = document.querySelector('a[href="index.html#pemesanan"]');
            if (pesanBtn) {
                // Kita ubah linknya menjadi: index.html?paket=NamaPaket#pemesanan
                // encodeURIComponent() penting agar spasi di nama paket terbaca benar
                pesanBtn.href = `index.html?paket=${encodeURIComponent(data.title)}#pemesanan`;
            }
            // ============================================================

            // D. Sembunyikan loading, tampilkan konten
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('detail-content').classList.remove('hidden');
        }
    } else {
        document.getElementById('loading').innerText = "ID Paket tidak ditemukan.";
    }


    // --- 3. LOGIKA DARK MODE ---
    const themeToggleBtn = document.getElementById('theme-toggle');
    
    const sunIcon = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M12 12a5 5 0 100-10 5 5 0 000 10z"></path></svg>`;
    const moonIcon = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>`;

    let isDarkMode = localStorage.getItem('theme') === 'dark';

    const updateTheme = () => {
        isDarkMode = !isDarkMode;
        localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        applyTheme();
    };

    const applyTheme = () => {
        if (isDarkMode) {
            document.documentElement.classList.add('dark');
            if(themeToggleBtn) themeToggleBtn.innerHTML = sunIcon;
        } else {
            document.documentElement.classList.remove('dark');
            if(themeToggleBtn) themeToggleBtn.innerHTML = moonIcon;
        }
    };

    if(themeToggleBtn) themeToggleBtn.addEventListener('click', updateTheme);
    applyTheme();
});