<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
    <input type="text" name="name" value="{{ old('name', $kasir?->name) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
    @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
    <input type="email" name="email" value="{{ old('email', $kasir?->email) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
    @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
</div>

@if ($showPassword ?? false)
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm" required>
        @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm" required>
    </div>
@endif

@if ($showAktif ?? false)
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Status Akun</label>
        <select name="aktif" class="w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="1" @selected((string) old('aktif', $kasir?->aktif ? 1 : 0) === '1')>Aktif — bisa login</option>
            <option value="0" @selected((string) old('aktif', $kasir?->aktif ? 1 : 0) === '0')>Nonaktif — resign / berhenti</option>
        </select>
        <p class="text-xs text-gray-500 mt-1">Kasir nonaktif tidak bisa masuk ke sistem.</p>
        @error('aktif')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
@endif
