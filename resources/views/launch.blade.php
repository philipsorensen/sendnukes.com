@extends('layouts.nuke')

@section('title', 'LAUNCH SEQUENCE — SENDNUKES.COM')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-[#030303] relative overflow-hidden scanlines"
     x-data="launchSeq()"
     x-init="start()">

    {{-- Red grid overlay --}}
    <div class="fixed inset-0 bg-grid pointer-events-none opacity-40 z-0"></div>

    {{-- Nuclear flash overlay --}}
    <div x-show="flash" x-cloak
         class="nuclear-flash fixed inset-0 z-50 pointer-events-none"
         aria-hidden="true"></div>

    {{-- Border flicker when countdown is active --}}
    <div x-show="stage === 1" x-cloak
         class="fixed inset-0 border-4 border-red-700/70 pointer-events-none z-40 warning-blink"
         aria-hidden="true"></div>

    {{-- ── Stage 0: Authorization ── --}}
    <div x-show="stage === 0" x-cloak class="text-center z-20 px-8">
        <div class="font-mono text-xs text-green-500/60 tracking-[0.4em] mb-6 glow-green">
            NUCLEAR COMMAND &amp; CONTROL SYSTEM
        </div>
        <div class="font-display text-3xl md:text-5xl text-[#e0cfa0] tracking-[0.18em] mb-4">
            AUTHORIZATION CONFIRMED
        </div>
        <div class="font-mono text-sm text-red-500 warning-blink tracking-[0.3em] uppercase">
            PREPARING LAUNCH SEQUENCE…
        </div>
    </div>

    {{-- ── Stage 1: Countdown ── --}}
    <div x-show="stage === 1" x-cloak class="text-center z-20">
        <div class="font-mono text-xs text-red-500/70 tracking-[0.4em] mb-8 uppercase warning-blink">
            ⚠ &nbsp; LAUNCH SEQUENCE ACTIVE &nbsp; ⚠
        </div>
        <div class="font-bebas leading-none glow-red"
             style="font-size: clamp(8rem, 30vw, 20rem);
                    color: #ff1a1a;
                    text-shadow: 0 0 30px rgba(255,0,0,0.8), 0 0 80px rgba(200,0,0,0.4);"
             x-text="count"></div>
        <div class="font-mono text-xs text-[#5a2828] mt-4 tracking-[0.35em]">
            WARHEAD ARMING
        </div>
    </div>

    {{-- ── Stage 2: LAUNCH ── --}}
    <div x-show="stage === 2" x-cloak class="text-center z-20">
        <div class="font-display tracking-[0.2em] leading-none mb-2"
             style="font-size: clamp(3rem, 12vw, 7rem); color: #e0cfa0;">
            LAUNCH
        </div>
        <div class="font-display tracking-[0.2em] leading-none glow-red warning-blink"
             style="font-size: clamp(2rem, 8vw, 5rem); color: #ff1a1a;">
            CONFIRMED
        </div>
    </div>

    {{-- ── Stage 3: Mushroom Cloud ── --}}
    <div x-show="stage === 3" x-cloak
         class="text-center z-20 flex flex-col items-center w-full">

        <div class="font-mono text-xs text-amber-500/70 tracking-[0.35em] mb-6 uppercase glow-amber">
            ☢ &nbsp; IMPACT DETECTED &nbsp; ☢
        </div>

        {{-- Shockwave rings (centered) --}}
        <div class="relative flex items-center justify-center" style="height: 340px; width: 260px;">
            <div class="shockwave-ring" style="animation-delay: 0.2s;"></div>
            <div class="shockwave-ring" style="animation-delay: 0.8s;"></div>
            <div class="shockwave-ring" style="animation-delay: 1.4s;"></div>

            {{-- Mushroom cloud layers --}}
            <div class="mushroom-top"  style="animation-delay: 0.5s;"></div>
            <div class="mushroom-cap"  style="animation-delay: 0.2s;"></div>
            <div class="mushroom-stem" style="animation-delay: 0s;"></div>
            <div class="mushroom-base" style="animation-delay: 0.1s;"></div>
        </div>
    </div>

    {{-- ── Stage 4: Confirmation ── --}}
    <div x-show="stage === 4" x-cloak
         class="text-center z-20 max-w-md px-8 w-full">

        <div class="font-mono text-xs text-green-500/70 tracking-[0.35em] mb-5 glow-green">
            ☢ &nbsp; MISSION COMPLETE &nbsp; ☢
        </div>

        <div class="font-display leading-none mb-1"
             style="font-size: clamp(3rem, 10vw, 5rem); color: #e0cfa0;">
            DELIVERY
        </div>
        <div class="font-display leading-none glow-red mb-8"
             style="font-size: clamp(3rem, 10vw, 5rem); color: #ff1a1a;">
            CONFIRMED
        </div>

        {{-- Casualty count teaser --}}
        <div class="font-mono text-[10px] text-[#5a3828]/70 uppercase tracking-wider mb-1">
            Congratulations — you just killed
        </div>
        <div class="font-bebas glow-red leading-none mb-6"
             style="font-size: clamp(2.5rem, 10vw, 4.5rem); color: #ff1a1a;">
            ???,???
        </div>
        <div class="font-stencil text-xs text-[#5a3828]/55 italic mb-6">
            See full report on your certificate →
        </div>

        {{-- Summary panel --}}
        <div class="nuke-panel p-4 mb-7 text-left font-mono text-xs space-y-2">
            <div class="flex justify-between items-center">
                <span class="text-[#5a3828]/80 uppercase tracking-wider text-[10px]">Target</span>
                <span class="text-green-400 glow-green" x-text="coordLabel"></span>
            </div>
            <div class="w-full h-px bg-red-950/30"></div>
            <div class="flex justify-between items-center">
                <span class="text-[#5a3828]/80 uppercase tracking-wider text-[10px]">Payload</span>
                <span class="text-amber-400" x-text="nukeName"></span>
            </div>
            <div class="w-full h-px bg-red-950/30"></div>
            <div class="flex justify-between items-center">
                <span class="text-[#5a3828]/80 uppercase tracking-wider text-[10px]">Status</span>
                <span class="text-red-500 warning-blink uppercase tracking-widest">Detonated</span>
            </div>
        </div>

        <a href="{{ route('confirmation') }}"
           class="btn-launch px-10 py-4 text-white font-display tracking-[0.18em] text-sm uppercase inline-block mb-4">
            VIEW DELIVERY CERTIFICATE
        </a>

        <br>

        <a href="{{ route('deploy') }}"
           class="font-mono text-xs text-[#5a3020]/70 hover:text-[#b07850] transition-colors">
            Deploy another nuke →
        </a>
    </div>

</div>

@endsection

@push('scripts')
<script>
const _launchData = @json($launchData ?? []);

document.addEventListener('alpine:init', () => {
    Alpine.data('launchSeq', () => ({
        stage:      0,
        count:      5,
        flash:      false,
        coordLabel: '',
        nukeName:   '',

        start() {
            // Build display strings
            if (_launchData.lat && _launchData.lng) {
                const lat = parseFloat(_launchData.lat).toFixed(4);
                const lng = parseFloat(_launchData.lng).toFixed(4);
                this.coordLabel = `${lat}°, ${lng}°`;
            } else {
                this.coordLabel = 'CLASSIFIED';
            }

            const nameMap = {
                'tactical-tickle':          'The Tactical Tickle',
                'ex-terminator':            'The Ex Terminator',
                'corporate-restructuring':  'The Corporate Restructuring',
                'birthday-surprise':        'The Birthday Surprise',
                'monday-obliterator':       'The Monday Obliterator',
                'thermonuclear-hug':        'The Thermonuclear Hug',
            };
            this.nukeName = nameMap[_launchData.nuke_type] ?? 'Unknown Payload';

            // Stage 0 → 1 after 1.6s
            setTimeout(() => {
                this.stage = 1;
                this._countdown();
            }, 1600);
        },

        _countdown() {
            let c = 5;
            this.count = c;
            const iv = setInterval(() => {
                c--;
                this.count = c;
                if (c <= 0) {
                    clearInterval(iv);
                    setTimeout(() => this._launch(), 500);
                }
            }, 900);
        },

        _launch() {
            this.stage = 2;

            // Flash
            setTimeout(() => {
                this.flash = true;
                setTimeout(() => { this.flash = false; }, 1600);
            }, 250);

            // Mushroom cloud
            setTimeout(() => { this.stage = 3; }, 1100);

            // Final stage
            setTimeout(() => { this.stage = 4; }, 5200);
        },
    }));
});
</script>
@endpush