@extends('layouts.app')

@section('content')
<div class="public-page">
    <div class="profile-card">

        <div class="avatar">
            @if($b->logo)
                <img src="{{ asset('storage/' . $b->logo) }}" alt="{{ $b->name }}">
            @else
                {{ mb_substr($b->name, 0, 1) }}
            @endif
        </div>

        <h1>{{ $b->name }}</h1>

        <div class="category">
            {{ $b->category?->name ?? 'کسب‌وکار' }}
        </div>

        @if($b->description)
            <div class="info description-box">
                <div class="info-title">📝 درباره کسب‌وکار</div>
                <p class="description">{!! nl2br(e($b->description)) !!}</p>
            </div>
        @endif

        <div class="actions">
            @if($b->mobile)
                <a href="tel:{{ $b->mobile }}" class="action">
                    📞 <span>تماس</span>
                </a>
            @endif

            @if($b->telegram)
                <a href="{{ $b->telegram }}" target="_blank" rel="noopener noreferrer" class="action">
                    💬 <span>Telegram</span>
                </a>
            @endif

            @if($b->instagram)
                <a href="{{ $b->instagram }}" target="_blank" rel="noopener noreferrer" class="action">
                    📸 <span>Instagram</span>
                </a>
            @endif

            @if($b->rubika)
                <a href="{{ $b->rubika }}" target="_blank" rel="noopener noreferrer" class="action">
                    🟣 <span>Rubika</span>
                </a>
            @endif

            @if($b->website)
                <a href="{{ $b->website }}" target="_blank" rel="noopener noreferrer" class="action">
                    🌐 <span>وب‌سایت</span>
                </a>
            @endif
        </div>

        @if($b->address || ($b->latitude && $b->longitude))
            <div class="info address-box">
                <div class="info-title">📍 آدرس کسب‌وکار</div>

                @if($b->address)
                    <p class="address-text">{{ $b->address }}</p>
                @else
                    <p class="address-text text-muted">موقعیت مکانی ثبت شده است.</p>
                @endif

                @if($b->latitude && $b->longitude)
                    <div class="address-actions">
                        <a
                            target="_blank"
                            rel="noopener noreferrer"
                            class="map-btn"
                            href="https://www.google.com/maps/dir/?api=1&destination={{ $b->latitude }},{{ $b->longitude }}">
                            🧭 مسیریابی
                        </a>

                        <a
                            target="_blank"
                            rel="noopener noreferrer"
                            class="map-btn secondary"
                            href="https://www.google.com/maps?q={{ $b->latitude }},{{ $b->longitude }}">
                            🗺️ مشاهده روی نقشه
                        </a>
                    </div>
                @endif
            </div>
        @endif

        @if($b->phone)
            <div class="info">
                <b>☎ تلفن</b>
                <p dir="ltr">{{ $b->phone }}</p>
            </div>
        @endif

        <div class="powered">QRCard</div>
    </div>
</div>
@endsection
