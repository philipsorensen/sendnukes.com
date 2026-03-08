@extends('layouts.nuke')

@section('title', 'DELIVERY CONFIRMED — SENDNUKES.COM')

@section('content')

<div class="min-h-screen flex flex-col bg-grid py-12 px-4" x-data="{ copied: false }">

    {{-- Fixed stripes --}}
    <div class="danger-stripe fixed top-0 left-0 right-0 z-30"></div>
    <div class="danger-stripe fixed bottom-0 left-0 right-0 z-30"></div>

    <div class="max-w-xl mx-auto w-full mt-8 mb-8">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="font-mono text-[10px] tracking-[0.45em] text-red-600/55 mb-3 uppercase">
                ☢ &nbsp; CERTIFIED NUCLEAR DELIVERY &nbsp; ☢
            </div>
            <h1 class="font-display text-4xl md:text-5xl text-[#e0cfa0] tracking-[0.18em] uppercase">
                SENDNUKES.COM
            </h1>
            <div class="font-mono text-xs text-[#5a3828]/70 tracking-wider mt-1.5">
                Official Nuclear Greeting Service &nbsp;·&nbsp; Est. {{ date('Y') }}
            </div>
        </div>

        {{-- Certificate card --}}
        <div class="nuke-panel relative overflow-hidden" style="border-color: rgba(190,0,0,0.4);">

            {{-- Corner ornaments --}}
            <div class="absolute top-4 left-4  w-7 h-7 border-l-2 border-t-2 border-red-800/40 pointer-events-none"></div>
            <div class="absolute top-4 right-4 w-7 h-7 border-r-2 border-t-2 border-red-800/40 pointer-events-none"></div>
            <div class="absolute bottom-4 left-4  w-7 h-7 border-l-2 border-b-2 border-red-800/40 pointer-events-none"></div>
            <div class="absolute bottom-4 right-4 w-7 h-7 border-r-2 border-b-2 border-red-800/40 pointer-events-none"></div>

            {{-- "DELIVERED" diagonal stamp --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10"
                 style="transform: rotate(-18deg);">
                <div class="stamp">DELIVERED</div>
            </div>

            {{-- Certificate body --}}
            <div class="relative z-20 p-8 md:p-12">

                {{-- Intro text --}}
                <div class="text-center mb-7">
                    <div class="font-mono text-[10px] text-[#5a3828]/75 tracking-widest uppercase mb-2">
                        This certifies that
                    </div>
                    <div class="font-display text-xl md:text-2xl text-[#e0cfa0] tracking-wider uppercase">
                        A NUCLEAR GREETING
                    </div>
                    <div class="font-mono text-[10px] text-[#5a3828]/75 tracking-widest uppercase mt-2 mb-1">
                        was successfully deployed on
                    </div>
                    <div class="font-display text-base text-amber-500 glow-amber mt-1">
                        {{ now()->format('d M Y — H:i:s') }} UTC
                    </div>
                </div>

                {{-- Casualty count — the star of the show --}}
                <div class="text-center border border-red-900/35 bg-[#0a0101] py-6 px-4 mb-7">
                    <div class="font-mono text-[11px] text-[#c8a878] uppercase tracking-[0.35em] mb-2">
                        Congratulations — you just killed
                    </div>
                    <div class="font-bebas leading-none glow-red"
                         style="font-size: clamp(3rem, 14vw, 6rem); color: #ff1a1a;">
                        {{ $casualties }}
                    </div>
                    <div class="font-display text-sm text-[#e0c890] tracking-[0.15em] uppercase mt-1">
                        people
                    </div>
                    <div class="font-stencil text-xs text-[#a08060] italic mt-3">
                        (estimated, based on average urban density)
                    </div>
                </div>

                {{-- Data table --}}
                <div class="border border-red-900/28 divide-y divide-red-950/30 mb-7">

                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-mono text-[10px] text-[#5a3828]/70 uppercase tracking-wider">
                            Target Coordinates
                        </span>
                        <span class="font-mono text-xs text-green-400 glow-green">
                            @if(isset($launchData['lat']) && isset($launchData['lng']))
                                {{ number_format((float)$launchData['lat'], 6) }}°,
                                {{ number_format((float)$launchData['lng'], 6) }}°
                            @else
                                CLASSIFIED
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-mono text-[10px] text-[#5a3828]/70 uppercase tracking-wider">
                            Payload Type
                        </span>
                        <span class="font-mono text-xs text-amber-400">{{ $nukeDisplayName }}</span>
                    </div>

                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-mono text-[10px] text-[#5a3828]/70 uppercase tracking-wider">
                            Estimated Warmth
                        </span>
                        <span class="font-mono text-xs text-red-400">Very Very Very Warm</span>
                    </div>

                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-mono text-[10px] text-[#5a3828]/70 uppercase tracking-wider">
                            Crater Diameter
                        </span>
                        <span class="font-mono text-xs text-[#c0a878]">{{ $craterSize }} km</span>
                    </div>

                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-mono text-[10px] text-[#5a3828]/70 uppercase tracking-wider">
                            Radiation Level
                        </span>
                        <span class="font-mono text-xs text-green-400 glow-green warning-blink-slow">
                            ELEVATED
                        </span>
                    </div>

                    <div class="flex justify-between items-center px-4 py-3">
                        <span class="font-mono text-[10px] text-[#5a3828]/70 uppercase tracking-wider">
                            Delivery Status
                        </span>
                        <span class="font-mono text-xs text-red-500 warning-blink">CONFIRMED ✓</span>
                    </div>

                    @if(!empty($launchData['message']))
                    <div class="flex justify-between items-start px-4 py-3">
                        <span class="font-mono text-[10px] text-[#5a3828]/70 uppercase tracking-wider flex-shrink-0">
                            Personal Note
                        </span>
                        <span class="font-stencil text-xs text-[#b09070] italic max-w-[58%] text-right leading-snug">
                            "{{ $launchData['message'] }}"
                        </span>
                    </div>
                    @endif

                </div>

                {{-- Fake barcode --}}
                <div class="text-center mb-5">
                    <div class="inline-flex gap-px items-end justify-center">
                        @for($i = 0; $i < 48; $i++)
                            <div style="
                                width: {{ [1,1,2,2,3][array_rand([0,1,2,3,4])] }}px;
                                height: {{ rand(20, 38) }}px;
                                background: rgba(180,150,90,{{ number_format(rand(25, 65) / 100, 2) }});
                            "></div>
                        @endfor
                    </div>
                    <div class="font-mono text-[9px] text-[#4a3020] mt-1 tracking-widest">
                        SN-{{ strtoupper(substr(md5(($launchData['lat'] ?? '0') . ($launchData['lng'] ?? '0') . ($launchData['nuke_type'] ?? '')), 0, 14)) }}
                    </div>
                </div>

                <div class="text-center font-stencil text-[11px] text-[#4a3020]/65 italic">
                    {{ $slogan }}
                </div>

            </div>
        </div>

        {{-- Action buttons --}}
        <div class="flex flex-wrap gap-3 mt-6 justify-center">
            <button
                @click="
                    navigator.clipboard.writeText(window.location.href).catch(() => {});
                    copied = true;
                    setTimeout(() => copied = false, 2200);
                "
                class="font-mono text-xs tracking-widest uppercase px-6 py-3
                       border border-red-900/45 text-[#b09070]
                       hover:border-red-700/70 hover:text-red-300
                       transition-all cursor-pointer"
            >
                <span x-show="!copied">SHARE CERTIFICATE</span>
                <span x-show="copied" x-cloak class="text-green-400">COPIED ✓</span>
            </button>

            <a href="{{ route('deploy') }}"
               class="btn-launch font-display tracking-[0.2em] text-sm uppercase px-8 py-3 text-white inline-block">
                DEPLOY ANOTHER
            </a>
        </div>

        <div class="text-center mt-6 font-mono text-[9px] text-[#362010]/60 leading-relaxed">
            SENDNUKES.COM — The thinking person's greeting card service.<br>
            All nuclear strikes are simulated. Craters may vary. Side effects include: laughter.
        </div>

    </div>

</div>

@endsection