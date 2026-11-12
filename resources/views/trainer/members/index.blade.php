<x-layouts.app title="Daftar Member">
    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="rounded-3xl p-6 md:p-8 glass-panel shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/15 text-red-600 dark:text-rose-400 mb-2">
                    <span class="material-symbols-outlined text-[16px] mr-1">group</span>
                    Peserta Pelatihan Kerja
                </span>
                <h1 class="font-headline text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-on-surface">
                    Daftar Member & Monitoring
                </h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-on-surface-variant mt-1">
                    Cari, filter berdasarkan tahapan, dan pantau perkembangan setiap pencari kerja secara transparan.
                </p>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="rounded-2xl p-4 glass-panel shadow-sm">
            <form action="{{ route('trainer.members.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative flex-1 w-full">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Cari nama, email, jurusan, atau skill peserta..."
                           class="w-full pl-11 pr-4 py-2 glass-input text-xs sm:text-sm">
                </div>

                <div class="w-full sm:w-60">
                    <select name="tahap" onchange="this.form.submit()" class="w-full glass-input text-xs sm:text-sm">
                        <option value="">-- Semua Tahapan --</option>
                        @foreach($stages as $key => $st)
                            <option value="{{ $key }}" {{ request('tahap') == $key ? 'selected' : '' }}>
                                {{ $st['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-md shadow-red-600/20 transition-all">
                    Terapkan
                </button>

                @if(request('q') || request('tahap'))
                    <a href="{{ route('trainer.members.index') }}" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-surface-container-high text-xs font-semibold text-slate-600 dark:text-on-surface-variant text-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Members Table -->
        <div class="rounded-3xl glass-panel shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200/50 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-on-surface-variant bg-slate-50/50 dark:bg-surface-container-highest/20">
                            <th class="py-4 px-6">Peserta</th>
                            <th class="py-4 px-4">Kontak & NIK</th>
                            <th class="py-4 px-4">Pendidikan / Jurusan</th>
                            <th class="py-4 px-4">Tahapan Saat Ini</th>
                            <th class="py-4 px-4">Progres</th>
                            <th class="py-4 px-4">Status Penempatan</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs sm:text-sm">
                        @forelse($members as $m)
                            @php
                                $profile = $m->profile;
                                $pct = $profile ? $profile->progress_percentage : 16;
                            @endphp
                            <tr class="hover:bg-red-500/5 transition-colors">
                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $m->avatar_url }}" alt="{{ $m->name }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-red-500/30">
                                        <div>
                                            <a href="{{ route('trainer.members.show', $m->id) }}" class="font-bold text-slate-800 dark:text-on-surface hover:text-red-600 transition-colors block">
                                                {{ $m->name }}
                                            </a>
                                            <span class="text-[11px] text-slate-400">{{ $m->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-slate-600 dark:text-on-surface-variant">
                                    <span class="font-medium text-slate-700 dark:text-on-surface block">{{ $profile?->no_hp ?? '-' }}</span>
                                    <span class="text-[11px] text-slate-400">NIK: {{ $profile?->nik ? substr($profile->nik, 0, 6) . '******' : '-' }}</span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-slate-600 dark:text-on-surface-variant">
                                    <span class="font-semibold block text-slate-700 dark:text-on-surface">{{ $profile?->jurusan ?? '-' }}</span>
                                    <span class="text-[11px] text-slate-400">{{ $profile?->pendidikan_terakhir ?? 'Belum isi' }}</span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/15 text-red-600 dark:text-rose-400">
                                        {{ ucfirst(str_replace('_', ' ', $profile?->tahap_saat_ini ?? 'pendaftaran')) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap w-36">
                                    <div class="flex items-center gap-2">
                                        <div class="w-full bg-slate-200 dark:bg-surface-variant h-2 rounded-full overflow-hidden">
                                            <div class="bg-gradient-to-r from-red-600 to-rose-500 h-full rounded-full" style="width: {{ $pct }}%"></div>
                                        </div>
                                        <span class="text-[11px] font-bold text-slate-500">{{ $pct }}%</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <x-badge-status :status="$m->latestPlacement?->status ?? 'proses'" />
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-right">
                                    <a href="{{ route('trainer.members.show', $m->id) }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-semibold text-xs shadow-md shadow-red-600/20 transition-all">
                                        Detail Profil
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-400 text-xs">
                                    Tidak ada data member yang cocok dengan filter pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($members->hasPages())
                <div class="p-4 border-t border-slate-200/50 dark:border-white/10">
                    {{ $members->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
