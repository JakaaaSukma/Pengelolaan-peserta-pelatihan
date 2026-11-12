<x-layouts.auth title="Masuk ke Akun">
    <div class="w-full max-w-md" x-data="{
        role: 'member',
        showPassword: false,
        email: '{{ old('email') }}',
        password: '',
        fillDemo(r) {
            this.role = r;
            if (r === 'member') {
                this.email = 'member@demo.com';
                this.password = 'password';
            } else {
                this.email = 'trainer@demo.com';
                this.password = 'password';
            }
        }
    }">
        <div class="glass-panel rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <!-- Decorative Red Accent Gradient Line -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-600 via-rose-500 to-red-800"></div>

            <!-- Header Title -->
            <div class="text-center mb-6 pt-2">
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-on-surface tracking-tight">
                    Masuk ke Sistem
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-on-surface-variant mt-1.5">
                    Monitoring terpadu pelatihan vokasi dan penempatan kerja
                </p>
            </div>

            <!-- Role Switcher Toggle -->
            <div class="p-1 rounded-2xl bg-slate-100/90 dark:bg-surface-container-highest/60 border border-slate-200/50 dark:border-white/5 flex mb-6 shadow-inner">
                <button type="button"
                        @click="role = 'member'"
                        :class="role === 'member' ? 'bg-red-600 text-white shadow-md font-bold' : 'text-slate-500 dark:text-on-surface-variant hover:text-slate-800 dark:hover:text-white font-medium'"
                        class="flex-1 py-2 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition-all">
                    <span class="material-symbols-outlined text-[18px]">person</span>
                    <span>Peserta (Member)</span>
                </button>
                <button type="button"
                        @click="role = 'trainer'"
                        :class="role === 'trainer' ? 'bg-red-600 text-white shadow-md font-bold' : 'text-slate-500 dark:text-on-surface-variant hover:text-slate-800 dark:hover:text-white font-medium'"
                        class="flex-1 py-2 rounded-xl text-xs sm:text-sm flex items-center justify-center gap-2 transition-all">
                    <span class="material-symbols-outlined text-[18px]">badge</span>
                    <span>Instruktur (Trainer)</span>
                </button>
            </div>

            <!-- Validation Error Alert -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[18px] text-rose-500">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-on-surface">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-on-surface-variant text-[20px]">mail</span>
                        <input type="email"
                               name="email"
                               id="email"
                               x-model="email"
                               required
                               placeholder="nama@email.com"
                               class="w-full pl-11 pr-4 py-2.5 glass-input text-xs sm:text-sm">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-on-surface">
                            Kata Sandi (Password)
                        </label>
                        <a href="javascript:void(0)" @click="$store.toast.notify('Untuk akun demo, silakan gunakan tombol demo di bawah.', 'info')" class="text-[11px] text-red-600 dark:text-rose-400 hover:underline">
                            Lupa password?
                        </a>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-on-surface-variant text-[20px]">lock</span>
                        <input :type="showPassword ? 'text' : 'password'"
                               name="password"
                               id="password"
                               x-model="password"
                               required
                               placeholder="••••••••"
                               class="w-full pl-11 pr-11 py-2.5 glass-input text-xs sm:text-sm">
                        <button type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                            <span class="material-symbols-outlined text-[18px]" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                        </button>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center">
                    <input type="checkbox"
                           name="remember"
                           id="remember"
                           class="w-4 h-4 rounded text-red-600 focus:ring-red-500/40 border-slate-300 dark:border-white/10 dark:bg-surface-container-highest">
                    <label for="remember" class="ml-2 text-xs text-slate-600 dark:text-on-surface-variant">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- Submit Button with Red Dominant Gradient -->
                <button type="submit"
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-500 hover:to-rose-600 text-white font-headline font-bold text-sm shadow-lg shadow-red-600/30 active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    <span>Masuk Sekarang</span>
                </button>
            </form>

            <!-- Quick Demo Login Buttons -->
            <div class="mt-6 pt-5 border-t border-slate-200/50 dark:border-white/10">
                <span class="block text-center text-[11px] font-semibold text-slate-400 dark:text-outline uppercase tracking-wider mb-3">
                    Isi Otomatis Akun Demo
                </span>
                <div class="grid grid-cols-2 gap-2.5">
                    <button type="button"
                            @click="fillDemo('member')"
                            class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-surface-container-high/60 hover:bg-red-500/15 hover:border-red-500/40 border border-slate-200/50 dark:border-white/5 text-slate-700 dark:text-on-surface text-xs font-semibold flex items-center justify-center gap-1.5 transition-all">
                        <span class="material-symbols-outlined text-[16px] text-red-500">person</span>
                        <span>Akun Member</span>
                    </button>
                    <button type="button"
                            @click="fillDemo('trainer')"
                            class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-surface-container-high/60 hover:bg-red-500/15 hover:border-red-500/40 border border-slate-200/50 dark:border-white/5 text-slate-700 dark:text-on-surface text-xs font-semibold flex items-center justify-center gap-1.5 transition-all">
                        <span class="material-symbols-outlined text-[16px] text-rose-500">badge</span>
                        <span>Akun Trainer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.auth>
