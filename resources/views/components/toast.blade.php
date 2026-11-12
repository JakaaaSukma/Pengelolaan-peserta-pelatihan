<div x-data
     x-show="$store.toast.show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-8 scale-90"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-8 scale-90"
     style="display: none;"
     class="fixed bottom-20 md:bottom-8 right-4 md:right-8 z-50 max-w-sm rounded-2xl p-4 glass-modal shadow-2xl flex items-center gap-3">
    <div class="p-2 rounded-xl"
         :class="{
            'bg-emerald-500/20 text-emerald-400': $store.toast.type === 'success',
            'bg-rose-500/20 text-rose-400': $store.toast.type === 'error',
            'bg-sky-500/20 text-sky-400': $store.toast.type === 'info',
         }">
        <span class="material-symbols-outlined text-[20px]"
              x-text="$store.toast.type === 'success' ? 'check_circle' : ($store.toast.type === 'error' ? 'error' : 'info')"></span>
    </div>
    <div class="flex-1">
        <p class="text-xs md:text-sm font-medium text-slate-800 dark:text-on-surface" x-text="$store.toast.message"></p>
    </div>
    <button @click="$store.toast.show = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
        <span class="material-symbols-outlined text-[16px]">close</span>
    </button>
</div>

