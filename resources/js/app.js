import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Prayer time countdown component
Alpine.data('prayerCountdown', () => ({
    nextPrayer: '',
    countdown: '',
    init() {
        this.updateCountdown();
        setInterval(() => this.updateCountdown(), 1000);
    },
    updateCountdown() {
        const now = new Date();
        const prayers = window.prayerTimes || {};
        const names = ['Subuh', 'Dzuhur', 'Ashar', 'Maghrib', 'Isya'];
        let next = null;
        let nextName = '';

        for (const name of names) {
            if (!prayers[name.toLowerCase()]) continue;
            const [h, m] = prayers[name.toLowerCase()].split(':').map(Number);
            const t = new Date(now);
            t.setHours(h, m, 0, 0);
            if (t > now) {
                next = t;
                nextName = name;
                break;
            }
        }

        if (!next) {
            // Next day Subuh
            if (prayers['subuh']) {
                const [h, m] = prayers['subuh'].split(':').map(Number);
                next = new Date(now);
                next.setDate(next.getDate() + 1);
                next.setHours(h, m, 0, 0);
                nextName = 'Subuh';
            }
        }

        if (next) {
            this.nextPrayer = nextName;
            const diff = Math.floor((next - now) / 1000);
            const hh = Math.floor(diff / 3600).toString().padStart(2, '0');
            const mm = Math.floor((diff % 3600) / 60).toString().padStart(2, '0');
            const ss = (diff % 60).toString().padStart(2, '0');
            this.countdown = `${hh}:${mm}:${ss}`;
        }
    }
}));

// Mobile menu — state `open` (template memakai `open`; alias `isOpen` untuk kompatibilitas)
Alpine.data('mobileMenu', () => ({
    open: false,
    get isOpen() { return this.open; },
    set isOpen(v) { this.open = v; },
    toggle() { this.open = !this.open; },
    close() { this.open = false; },
    initNavbar() {
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('main-navbar');
            if (!navbar) return;
            navbar.classList.toggle('navbar-scrolled', window.scrollY > 40);
        }, { passive: true });
    }
}));

// Gallery lightbox
Alpine.data('lightbox', () => ({
    open: false,
    current: '',
    currentCaption: '',
    images: [],
    currentIndex: 0,
    show(src, caption, images = [], index = 0) {
        this.current = src;
        this.currentCaption = caption;
        this.images = images;
        this.currentIndex = index;
        this.open = true;
        document.body.style.overflow = 'hidden';
    },
    close() {
        this.open = false;
        document.body.style.overflow = '';
    },
    prev() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
            this.current = this.images[this.currentIndex].src;
            this.currentCaption = this.images[this.currentIndex].caption;
        }
    },
    next() {
        if (this.currentIndex < this.images.length - 1) {
            this.currentIndex++;
            this.current = this.images[this.currentIndex].src;
            this.currentCaption = this.images[this.currentIndex].caption;
        }
    }
}));

// Notification dropdown
Alpine.data('notifications', () => ({
    open: false,
    count: 0,
    toggle() { this.open = !this.open; }
}));

// Admin sidebar
Alpine.data('adminSidebar', () => ({
    open: window.innerWidth >= 1024,
    collapsed: false,
    toggle() { this.open = !this.open; },
    collapse() { this.collapsed = !this.collapsed; }
}));

// Donation form
Alpine.data('donationForm', () => ({
    amount: '',
    customAmount: '',
    method: 'transfer',
    presets: [50000, 100000, 250000, 500000],
    selectPreset(val) {
        this.amount = val;
        this.customAmount = '';
    },
    get finalAmount() {
        return this.customAmount || this.amount;
    },
    formatRupiah(val) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(val);
    }
}));

// Toast notifications
Alpine.data('toast', () => ({
    show: false,
    message: '',
    type: 'success',
    display(msg, type = 'success') {
        this.message = msg;
        this.type = type;
        this.show = true;
        setTimeout(() => { this.show = false; }, 4000);
    }
}));

// Announcement Popup
Alpine.data('announcementPopup', () => ({
    open: false,
    currentIndex: 0,
    items: window.announcementPopups || [],
    init() {
        if (this.items.length === 0) return;
        // Cek apakah sudah pernah ditutup hari ini
        const key = 'popup_dismissed_' + new Date().toDateString();
        if (sessionStorage.getItem(key)) return;
        setTimeout(() => { this.open = true; }, 800);
    },
    close() {
        this.open = false;
        const key = 'popup_dismissed_' + new Date().toDateString();
        sessionStorage.setItem(key, '1');
        document.body.style.overflow = '';
    },
    prev() {
        if (this.currentIndex > 0) this.currentIndex--;
    },
    next() {
        if (this.currentIndex < this.items.length - 1) this.currentIndex++;
    },
    get current() {
        return this.items[this.currentIndex] || null;
    }
}));

// Marquee / Running Text Bar
Alpine.data('marqueeBar', () => ({
    paused: false,
    pause() { this.paused = true; },
    resume() { this.paused = false; }
}));

// Clock for TV display
Alpine.data('clock', () => ({
    time: '',
    date: '',
    hijri: '',
    init() {
        this.updateClock();
        setInterval(() => this.updateClock(), 1000);
    },
    updateClock() {
        const now = new Date();
        this.time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        this.date = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }
}));

// Alpine.start() dibungkus try/catch agar satu komponen yang error tidak
// mematikan seluruh inisialisasi di bawahnya (termasuk scroll-reveal).
try {
    Alpine.start();
} catch (e) {
    console.error('[app] Alpine gagal start:', e);
}

// Scroll reveal + efek navbar — dijalankan segera (modul deferred = DOM siap)
// atau saat DOMContentLoaded bila dokumen masih loading.
initScrollReveal();

function initScrollReveal() {
    if (window.__revealReady) return;

    const navbar = document.getElementById('main-navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-md', 'bg-white');
                navbar.classList.remove('bg-transparent');
            } else {
                navbar.classList.remove('shadow-md');
            }
        }, { passive: true });
    }

    // Auto-hide flash messages
    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => {
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-10px)';
            flash.style.transition = 'all 0.5s ease';
            setTimeout(() => flash.remove(), 500);
        }, 4000);
    }

    // Scroll reveal animations — smooth seperti PPT
    const targets = document.querySelectorAll('[data-animate]');
    window.__revealReady = true;
    if (!targets.length) return;

    // Fallback: tanpa IntersectionObserver, tampilkan semua langsung.
    if (!('IntersectionObserver' in window)) {
        targets.forEach(el => el.classList.add('animate-in'));
        return;
    }

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const delay = el.dataset.delay || 0;
                setTimeout(() => {
                    el.classList.add('animate-in');
                }, parseInt(delay));
                revealObserver.unobserve(el);
            }
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -60px 0px'
    });

    targets.forEach(el => {
        revealObserver.observe(el);
    });
}

// Jaga-jaga: bila modul tereksekusi sebelum DOM selesai diparsing
// (mis. di-bundle tanpa defer), daftarkan juga via DOMContentLoaded.
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollReveal);
}
