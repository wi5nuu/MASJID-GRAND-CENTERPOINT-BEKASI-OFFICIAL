{{-- Global Confirm Modal — pengganti confirm() bawaan browser --}}
{{-- Pakai: <form ... data-confirm="Pesan?" data-confirm-title="Judul" data-confirm-ok="Ya, Hapus" data-confirm-variant="danger|success|primary"> --}}
{{-- Aturan kontras: background terang → teks gelap --}}
<div x-data="confirmModal()" @confirm-modal.window="open($event.detail)" @keydown.escape.window="close()"
    x-show="show" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" role="dialog" aria-modal="true">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-neutral-900/60 backdrop-blur-sm" @click="close()"
        x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    {{-- Card --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden"
        x-show="show" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-3" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-3">
        {{-- Header terang + teks gelap --}}
        <div class="relative px-6 pt-6 pb-4" :class="headerBg">
            <button type="button" @click="close()" aria-label="Tutup"
                class="absolute top-4 right-4 p-1.5 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-black/5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 ring-4" :class="iconWrap">
                    <template x-if="variant === 'success'">
                        <svg class="w-6 h-6" :class="iconColor" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </template>
                    <template x-if="variant !== 'success'">
                        <svg class="w-6 h-6" :class="iconColor" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    </template>
                </div>
                <div class="min-w-0">
                    <h3 class="text-neutral-900 font-bold text-base leading-tight" x-text="title"></h3>
                    <p class="text-neutral-500 text-xs mt-1">Tindakan ini memerlukan konfirmasi</p>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="px-6 pb-6">
            <p class="text-sm text-neutral-600 leading-relaxed" x-text="message"></p>
            <div class="flex gap-3 mt-5">
                <button type="button" @click="confirm()" :class="buttonClass"
                    class="flex-1 text-white text-sm font-semibold py-2.5 px-4 rounded-xl transition-colors shadow-sm" x-text="okLabel"></button>
                <button type="button" @click="close()"
                    class="px-5 py-2.5 rounded-xl border border-neutral-300 text-neutral-700 text-sm font-medium hover:bg-neutral-50 transition-colors">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmModal() {
    return {
        show: false,
        form: null,
        title: 'Konfirmasi',
        message: 'Apakah Anda yakin?',
        okLabel: 'Ya, Lanjutkan',
        variant: 'danger',
        // Background terang → teks gelap (kontras aman)
        get headerBg() {
            return this.variant === 'success'
                ? 'bg-emerald-50'
                : (this.variant === 'primary' ? 'bg-primary-50' : 'bg-red-50');
        },
        get iconWrap() {
            return this.variant === 'success'
                ? 'bg-emerald-100 ring-emerald-200'
                : (this.variant === 'primary' ? 'bg-primary-100 ring-primary-200' : 'bg-red-100 ring-red-200');
        },
        get iconColor() {
            return this.variant === 'success'
                ? 'text-emerald-600'
                : (this.variant === 'primary' ? 'text-primary-600' : 'text-red-600');
        },
        get buttonClass() {
            return this.variant === 'success'
                ? 'bg-emerald-600 hover:bg-emerald-700'
                : (this.variant === 'primary'
                    ? 'bg-primary-600 hover:bg-primary-700'
                    : 'bg-red-600 hover:bg-red-700');
        },
        open(detail) {
            this.form = detail.form || null;
            this.title = detail.title || 'Konfirmasi';
            this.message = detail.message || 'Apakah Anda yakin?';
            this.okLabel = detail.ok || 'Ya, Lanjutkan';
            this.variant = ['danger', 'success', 'primary'].includes(detail.variant) ? detail.variant : 'danger';
            this.show = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.show = false;
            this.form = null;
            document.body.style.overflow = '';
        },
        confirm() {
            const f = this.form;
            this.show = false;
            document.body.style.overflow = '';
            this.form = null;
            if (f) { f.dataset.confirmed = '1'; f.submit(); }
        }
    };
}

// Intersep semua form ber-atribut data-confirm
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (!form.dataset.confirm || form.dataset.confirmed === '1') return;
    e.preventDefault();
    window.dispatchEvent(new CustomEvent('confirm-modal', { detail: {
        form: form,
        message: form.dataset.confirm,
        title: form.dataset.confirmTitle || 'Konfirmasi',
        ok: form.dataset.confirmOk || 'Ya, Lanjutkan',
        variant: form.dataset.confirmVariant || 'danger',
    }}));
});
</script>
