@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.kasir')

@section('title', 'Profil Saya')

@section('content')
@if(auth()->user()->role === 'kasir')
    <x-kasir.nav-tabs />
@endif

<div class="ruto-fade-in space-y-6" style="margin-top: 1.5rem;">
    <div class="ruto-card ruto-card-padded" style="max-width: 42rem;">
        <div style="max-width: 36rem;">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="ruto-card ruto-card-padded" style="max-width: 42rem;">
        <div style="max-width: 36rem;">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
        <div class="ruto-card ruto-card-padded" style="max-width: 42rem;">
            <div style="max-width: 36rem;">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    @endif
</div>
@endsection
