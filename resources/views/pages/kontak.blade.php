@extends('layouts.app')

@section('title', 'Kontak')
@section('meta_description', 'Hubungi tim SIMAKSI — informasi kontak dan form pertanyaan seputar sistem deteksi satwa liar Sumatra.')

@section('content')

    {{-- Page Header --}}
    <section class="bg-forest-900 pt-24 pb-16 lg:pt-32 lg:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl lg:text-5xl font-bold font-heading text-cream-50 mb-4">
                Kontak
            </h1>
            <p class="text-cream-100/70 text-lg max-w-2xl mx-auto">
                Punya pertanyaan tentang SIMAKSI? Jangan ragu untuk menghubungi kami.
            </p>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-12 lg:py-16 bg-cream-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

                {{-- Info Kontak --}}
                <div>
                    <x-section-heading
                        title="Informasi Kontak"
                        align="left"
                    />

                    <div class="space-y-6">
                        {{-- Tim --}}
                        <div class="bg-white rounded-2xl p-6 border border-cream-100 shadow-sm">
                            <h3 class="text-lg font-bold font-heading text-forest-900 mb-4">Tim Pengembang</h3>
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 shrink-0 bg-canopy-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-forest-900">Mahasiswa Capstone</p>
                                        <p class="text-sm text-text-500">Semester 5</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 shrink-0 bg-canopy-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-forest-900">Program Studi</p>
                                        <p class="text-sm text-text-500">Informasi akan ditambahkan</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 shrink-0 bg-canopy-500/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-forest-900">Email</p>
                                        <p class="text-sm text-text-500">simaksi@university.ac.id</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Project Info --}}
                        <div class="bg-gradient-to-br from-forest-900 to-forest-700 rounded-2xl p-6 text-cream-50">
                            <h3 class="text-lg font-bold font-heading mb-3">Tentang Project Ini</h3>
                            <p class="text-cream-100/70 text-sm leading-relaxed">
                                SIMAKSI adalah Capstone Project yang mengintegrasikan AI dan data
                                ekologi untuk konservasi satwa liar Sumatra. Sistem ini dikembangkan
                                sebagai alat bantu bagi peneliti dan petugas konservasi.
                            </p>
                            <a href="{{ url('/tentang') }}"
                               class="inline-flex items-center gap-2 mt-4 text-canopy-500 font-semibold text-sm
                                      hover:gap-3 transition-all duration-300">
                                Pelajari lebih lanjut
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Form Kontak --}}
                <div>
                    <x-section-heading
                        title="Kirim Pesan"
                        align="left"
                    />

                    <div class="bg-white rounded-2xl p-6 lg:p-8 border border-cream-100 shadow-sm">
                        <form id="contact-form" class="space-y-5">
                            <div>
                                <label for="contact-name" class="block text-sm font-semibold text-forest-900 mb-1.5">
                                    Nama Lengkap
                                </label>
                                <input type="text" id="contact-name" name="name" required
                                       class="w-full px-4 py-3 bg-cream-50 border border-cream-100 rounded-xl text-text-900
                                              placeholder:text-text-500/50 focus:outline-none focus:ring-2
                                              focus:ring-canopy-500/40 focus:border-canopy-500 transition-all duration-300"
                                       placeholder="Masukkan nama Anda">
                            </div>

                            <div>
                                <label for="contact-email" class="block text-sm font-semibold text-forest-900 mb-1.5">
                                    Email
                                </label>
                                <input type="email" id="contact-email" name="email" required
                                       class="w-full px-4 py-3 bg-cream-50 border border-cream-100 rounded-xl text-text-900
                                              placeholder:text-text-500/50 focus:outline-none focus:ring-2
                                              focus:ring-canopy-500/40 focus:border-canopy-500 transition-all duration-300"
                                       placeholder="email@contoh.com">
                            </div>

                            <div>
                                <label for="contact-subject" class="block text-sm font-semibold text-forest-900 mb-1.5">
                                    Subjek
                                </label>
                                <input type="text" id="contact-subject" name="subject" required
                                       class="w-full px-4 py-3 bg-cream-50 border border-cream-100 rounded-xl text-text-900
                                              placeholder:text-text-500/50 focus:outline-none focus:ring-2
                                              focus:ring-canopy-500/40 focus:border-canopy-500 transition-all duration-300"
                                       placeholder="Topik pesan Anda">
                            </div>

                            <div>
                                <label for="contact-message" class="block text-sm font-semibold text-forest-900 mb-1.5">
                                    Pesan
                                </label>
                                <textarea id="contact-message" name="message" rows="5" required
                                          class="w-full px-4 py-3 bg-cream-50 border border-cream-100 rounded-xl text-text-900
                                                 placeholder:text-text-500/50 focus:outline-none focus:ring-2
                                                 focus:ring-canopy-500/40 focus:border-canopy-500 transition-all duration-300
                                                 resize-y"
                                          placeholder="Tulis pesan Anda di sini..."></textarea>
                            </div>

                            <button type="submit" id="contact-submit"
                                    class="w-full px-6 py-3.5 bg-canopy-500 text-cream-50 font-semibold rounded-xl
                                           hover:bg-forest-700 active:scale-95 transition-all duration-300
                                           shadow-md hover:shadow-lg">
                                Kirim Pesan
                            </button>
                        </form>

                        {{-- Success toast (hidden by default) --}}
                        <div id="contact-toast"
                             class="hidden mt-4 px-4 py-3 bg-canopy-500/10 border border-canopy-500/20 rounded-xl
                                    text-canopy-500 text-sm font-medium text-center">
                            Pesan berhasil dikirim. Terima kasih!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('contact-form');
    var toast = document.getElementById('contact-toast');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Simulate sending (form belum terhubung ke backend)
        var btn = document.getElementById('contact-submit');
        btn.textContent = 'Mengirim...';
        btn.disabled = true;

        setTimeout(function () {
            form.reset();
            btn.textContent = 'Kirim Pesan';
            btn.disabled = false;
            toast.classList.remove('hidden');

            setTimeout(function () {
                toast.style.transition = 'opacity 0.3s';
                toast.style.opacity = '0';
                setTimeout(function () {
                    toast.classList.add('hidden');
                    toast.style.opacity = '1';
                }, 300);
            }, 3000);
        }, 1000);
    });
});
</script>
@endpush
