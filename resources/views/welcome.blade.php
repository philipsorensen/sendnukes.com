@extends('layouts.nuke')

@section('title', 'SEND NUKES — "Because flowers don\'t leave a crater."')

@section('content')

<div class="min-h-screen flex flex-col bg-grid relative overflow-hidden"
     x-data="landingPage()"
     x-init="init()">

    {{-- Falling-ash particles canvas --}}
    <canvas id="particles" class="fixed inset-0 pointer-events-none z-10 opacity-25" aria-hidden="true"></canvas>

    {{-- Top danger stripe --}}
    <div class="danger-stripe z-20 relative"></div>

    {{-- Header --}}
    <header class="relative z-20 flex items-center justify-between px-8 py-4 border-b border-red-900/25">
        <div class="flex items-center gap-3">
            <span class="text-red-600 text-2xl flicker leading-none" aria-label="radioactive">☢</span>
            <span class="font-display text-[#d8c898] tracking-[0.3em] uppercase text-sm">SENDNUKES.COM</span>
        </div>
        <div class="font-mono text-xs text-green-500/50 tracking-widest hidden sm:block">
            GLOBAL DELIVERY SERVICE &nbsp;·&nbsp; EST. {{ date('Y') }}
        </div>
    </header>

    {{-- Hero --}}
    <main class="relative z-20 flex-1 flex flex-col items-center justify-center text-center px-6 py-16">

        {{-- Pulsing radioactive symbol --}}
        <div class="relative mb-10">
            <div class="absolute inset-0 -m-10 rounded-full border border-red-900/20 animate-ping"
                 style="animation-duration: 4.5s;"></div>
            <div class="absolute inset-0 -m-20 rounded-full border border-red-950/10 animate-ping"
                 style="animation-duration: 4.5s; animation-delay: 1.5s;"></div>
            <div class="spin-slow text-8xl leading-none glow-red flicker"
                 style="color: #cc1a1a; display: inline-block;">
                ☢
            </div>
        </div>

        {{-- Priority label --}}
        <div class="font-mono text-[10px] tracking-[0.45em] text-red-600/55 uppercase mb-5">
            ⚠&nbsp; PRIORITY NUCLEAR DELIVERY SERVICE &nbsp;⚠
        </div>

        {{-- Main headline --}}
        <h1 class="font-display uppercase leading-none mb-5 max-w-4xl"
            style="font-size: clamp(3rem, 10vw, 6rem); letter-spacing: -0.02em; color: #e0cfa0;">
            SEND<span style="color: #cc1a1a;"> NUKES</span>
        </h1>

        {{-- Rotating slogan --}}
        <div class="h-10 overflow-hidden mb-10 max-w-2xl w-full flex items-center justify-center">
            <p class="font-stencil text-lg md:text-xl text-[#b0a075]/75 italic leading-tight transition-all duration-700"
               x-text="slogan"></p>
        </div>

        {{-- Quick stats --}}
        <div class="flex items-center gap-8 mb-12 font-mono text-xs text-[#706050]/75 tracking-widest uppercase">
            <div class="text-center">
                <div class="font-bebas text-3xl text-red-500 glow-red leading-none"
                     x-text="deliveries.toLocaleString()">24,819</div>
                <div class="mt-1">Deliveries</div>
            </div>
            <div class="w-px h-8 bg-red-950/50"></div>
            <div class="text-center">
                <div class="font-bebas text-3xl text-amber-500 leading-none">6</div>
                <div class="mt-1">Payload Types</div>
            </div>
            <div class="w-px h-8 bg-red-950/50"></div>
            <div class="text-center">
                <div class="font-bebas text-3xl text-green-500 glow-green leading-none">195</div>
                <div class="mt-1">Countries Served</div>
            </div>
        </div>

        {{-- CTA --}}
        <a href="{{ route('deploy') }}"
           class="btn-launch text-white font-display tracking-[0.22em] text-xl px-16 py-5 uppercase mb-5">
            INITIATE DEPLOYMENT
        </a>

        <p class="font-mono text-xs text-[#a06060] tracking-wider italic">
            All nuclear strikes are simulated. <em>Probably.</em>
        </p>

    </main>

    {{-- Footer --}}
    <footer class="relative z-20 px-8 py-5 border-t border-red-950/20
                   flex flex-col sm:flex-row items-center justify-between gap-2">
        <div class="font-stencil text-xs text-[#4a3828]/70">
            "The thinking person's gift-giving platform."
        </div>
        <div class="flex gap-4 font-mono text-[10px] text-[#4a3828]/60 tracking-wider">
            <span>No refunds</span>
            <span>·</span>
            <span>Not liable for craters</span>
            <span>·</span>
            <span>Fallout sold separately</span>
            <span>·</span>
            <span title="You know what you were looking for.">Not those kind of nukes</span>
        </div>
    </footer>

    {{-- Bottom danger stripe --}}
    <div class="danger-stripe z-20 relative"></div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('landingPage', () => ({
        slogans: [
            '"Because flowers don\'t leave a crater."',
            '"Send warmth. Send radiation."',
            '"Hugs are temporary. Fallout is forever."',
            '"Nothing says \'I care\' like a small tactical nuke."',
            '"Give the gift that really makes an impact."',
            '"Send your loved ones the warm embrace of a nuclear blast."',
        ],
        sloganIndex: 0,
        slogan:     '"Because flowers don\'t leave a crater."',
        deliveries: 24819,

        init() {
            setInterval(() => {
                this.sloganIndex = (this.sloganIndex + 1) % this.slogans.length;
                this.slogan = this.slogans[this.sloganIndex];
            }, 3800);

            setInterval(() => {
                if (Math.random() > 0.65) this.deliveries++;
            }, 4500);

            this.$nextTick(() => initParticles());
        },
    }));
});

function initParticles() {
    const canvas = document.getElementById('particles');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    function resize() {
        canvas.width  = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const dots = Array.from({ length: 70 }, () => ({
        x:      Math.random() * canvas.width,
        y:      Math.random() * canvas.height,
        r:      Math.random() * 2 + 0.4,
        dx:     (Math.random() - 0.5) * 0.25,
        dy:     Math.random() * 0.45 + 0.08,
        alpha:  Math.random() * 0.45 + 0.08,
        hue:    Math.random() > 0.85 ? '#ff2020' : '#a09070',
    }));

    (function loop() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        dots.forEach(p => {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = p.hue;
            ctx.globalAlpha = p.alpha;
            ctx.fill();
            p.x += p.dx;
            p.y += p.dy;
            if (p.y > canvas.height + 4) {
                p.y = -4;
                p.x = Math.random() * canvas.width;
            }
        });
        requestAnimationFrame(loop);
    })();
}
</script>
@endpush