<div class="space-y-6 max-w-4xl">
    <div>
        <h1 class="font-poppins text-[24px] text-navy dark:text-white font-bold">Profil Admin</h1>
        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Kelola identitas dan kata sandi akun Anda.</p>
    </div>
    <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252] flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center gap-4 flex-1">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto {{ $user->name }}" class="w-14 h-14 rounded-full object-cover ring-2 ring-brand/30">
            @else
                <span class="w-14 h-14 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-bold text-[22px]" aria-hidden="true">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            @endif
            <div class="flex-1">
                <div class="font-poppins font-semibold text-[16px] text-primary dark:text-white">{{ $user->name }}</div>
                <div class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">{{ $user->email }}</div>
            </div>
            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-brand/15 text-secondary dark:text-[#9CC2FF] border border-brand/20">Admin</span>
        </div>
        <form wire:submit="savePhoto" class="flex flex-wrap items-center gap-2">
            <label class="px-3 py-2 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] text-[13px] font-medium cursor-pointer hover:bg-[#E7EEFF] dark:hover:bg-[#263252]">
                {{ $photoUpload ? $photoUpload->getClientOriginalName() : 'Pilih foto…' }}
                <input type="file" wire:model="photoUpload" accept="image/*" class="hidden">
            </label>
            @if($photoUpload)
                <img src="{{ $photoUpload->temporaryUrl() }}" alt="Pratinjau" class="w-10 h-10 rounded-full object-cover">
                <button class="px-3 py-2 rounded-lg bg-navy dark:bg-brand text-white text-[13px] font-semibold">Unggah</button>
            @endif
            @if($user->photo)
                <button type="button" wire:click="removePhoto" wire:confirm="Hapus foto profil?" class="px-3 py-2 rounded-lg text-[13px] text-error dark:text-[#FFB4AB] hover:bg-red-50 dark:hover:bg-[#BA1A1A]/15">Hapus</button>
            @endif
        </form>
        @error('photoUpload')<p class="text-error dark:text-[#FFB4AB] text-[12px] w-full">{{ $message }}</p>@enderror
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252]">
            <h2 class="font-poppins font-semibold text-[16px] text-navy dark:text-white mb-3">Edit Profil</h2>
            <form wire:submit="saveProfile" class="space-y-3">
                <div>
                    <label class="block text-[13px] font-medium mb-1">Nama</label>
                    <input wire:model="name" class="w-full h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px] text-[#111C2D] dark:text-[#DAE2FD]" placeholder="Nama">
                    @error('name')<p class="text-error dark:text-[#FFB4AB] text-[12px] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[13px] font-medium mb-1">Email</label>
                    <input wire:model="email" type="email" class="w-full h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px] text-[#111C2D] dark:text-[#DAE2FD]" placeholder="Email">
                    @error('email')<p class="text-error dark:text-[#FFB4AB] text-[12px] mt-1">{{ $message }}</p>@enderror
                </div>
                <button class="px-4 py-2.5 rounded-lg bg-navy dark:bg-brand text-white text-[14px] font-semibold">Simpan</button>
            </form>
        </div>
        <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252]">
            <h2 class="font-poppins font-semibold text-[16px] text-navy dark:text-white mb-3">Ganti Password</h2>
            <form wire:submit="changePassword" class="space-y-3">
                <div>
                    <label class="block text-[13px] font-medium mb-1">Password saat ini</label>
                    <input wire:model="current_password" type="password" class="w-full h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]" placeholder="********">
                    @error('current_password')<p class="text-error dark:text-[#FFB4AB] text-[12px] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[13px] font-medium mb-1">Password baru</label>
                    <input wire:model="new_password" type="password" class="w-full h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]" placeholder="Minimal 6 karakter">
                    @error('new_password')<p class="text-error dark:text-[#FFB4AB] text-[12px] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[13px] font-medium mb-1">Konfirmasi password baru</label>
                    <input wire:model="new_password_confirmation" type="password" class="w-full h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]" placeholder="Ulangi password baru">
                </div>
                <button class="px-4 py-2.5 rounded-lg bg-navy dark:bg-brand text-white text-[14px] font-semibold">Ganti</button>
            </form>
        </div>
    </div>
</div>
