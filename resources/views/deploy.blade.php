@extends('layouts.nuke')

@section('title', 'TARGETING CONSOLE — SENDNUKES.COM')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush

@section('content')

<div class="min-h-screen flex flex-col bg-grid" x-data="deployConsole()" x-init="init()">

    {{-- Top danger stripe --}}
    <div class="danger-stripe"></div>

    {{-- Header --}}
    <header class="flex items-center justify-between px-6 py-3 border-b border-red-900/35 bg-[#080808] flex-shrink-0">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-75 transition-opacity">
                <span class="text-red-600 text-xl flicker leading-none">☢</span>
                <span class="font-display text-sm tracking-[0.25em] text-[#d8c898]">SENDNUKES.COM</span>
            </a>
            <span class="text-red-950 mx-1">/</span>
            <span class="font-mono text-xs text-red-500/65 tracking-widest uppercase warning-blink-slow">
                TARGETING CONSOLE
            </span>
        </div>
        <div class="font-mono text-xs text-green-500/45 tracking-widest" x-text="utcTime">--:--:-- UTC</div>
    </header>

    {{-- Main: map + controls --}}
    <div class="flex-1 flex flex-col lg:flex-row overflow-hidden" style="min-height: 0;">

        {{-- LEFT: Map panel --}}
        <div class="flex-1 flex flex-col" style="min-height: 400px;">

            {{-- Status banner --}}
            <div class="px-4 py-2 bg-[#090202] border-b border-red-900/25
                        font-mono text-xs text-red-300/65 flex items-center gap-2 flex-shrink-0">
                <span class="warning-blink text-red-500 text-base leading-none">●</span>
                <span x-show="!target">
                    AWAITING TARGET DESIGNATION &nbsp;—&nbsp; CLICK MAP TO SELECT STRIKE COORDINATES
                </span>
                <span x-show="target" x-cloak>
                    TARGET DESIGNATED:
                    <span class="text-green-400 glow-green ml-1" x-text="coordLabel"></span>
                    &nbsp;—&nbsp;
                    <span class="text-red-400 warning-blink">LOCKED</span>
                </span>
            </div>

            {{-- Leaflet map --}}
            <div id="nuke-map" class="flex-1"></div>

            {{-- Coordinate bar --}}
            <div class="px-4 py-2 bg-[#080808] border-t border-red-900/18
                        flex items-center justify-between font-mono text-xs flex-shrink-0">
                <div class="flex items-center gap-3">
                    <span class="text-[#5a3828]/70 uppercase tracking-wider text-[10px]">LAT</span>
                    <span class="coord-display"
                          x-text="target ? target.lat.toFixed(6) + '°' : '------'">------</span>
                    <span class="text-[#5a3828]/70 uppercase tracking-wider text-[10px] ml-2">LNG</span>
                    <span class="coord-display"
                          x-text="target ? target.lng.toFixed(6) + '°' : '------'">------</span>
                </div>
                <div class="font-mono text-[10px] tracking-widest uppercase"
                     :class="target ? 'text-red-500 warning-blink' : 'text-[#4a2828]/50'"
                     x-text="target ? 'TARGET LOCKED' : 'NO TARGET'">NO TARGET</div>
            </div>
        </div>

        {{-- RIGHT: Controls panel --}}
        <div class="lg:w-96 nuke-panel flex flex-col border-t lg:border-t-0 lg:border-l border-red-900/28
                    overflow-y-auto">

            {{-- Panel heading --}}
            <div class="px-6 py-4 border-b border-red-900/28 flex-shrink-0">
                <h2 class="font-display tracking-[0.25em] text-[#e0cfa0] uppercase text-sm">
                    SELECT PAYLOAD
                </h2>
                <p class="font-mono text-[11px] text-[#5a3828]/75 mt-1">
                    Choose your nuclear greeting
                </p>
            </div>

            {{-- Nuke cards --}}
            <div class="p-3 space-y-2 flex-shrink-0">
                <template x-for="nuke in nukes" :key="nuke.id">
                    <div class="nuke-card p-3 rounded-sm"
                         :class="{ 'selected': selectedNuke === nuke.id }"
                         @click="selectedNuke = nuke.id">
                        <div class="flex items-start gap-3">
                            <div class="text-2xl leading-none flex-shrink-0 mt-0.5" x-text="nuke.icon"></div>
                            <div class="flex-1 min-w-0">
                                <div class="font-display text-[11px] tracking-widest text-[#d0b888] uppercase"
                                     x-text="nuke.name"></div>
                                <div class="font-mono text-[10px] text-[#6a4838]/80 mt-1 leading-snug"
                                     x-text="nuke.desc"></div>
                                <div class="flex gap-4 mt-1.5">
                                    <div class="font-mono text-[9px] text-red-500/65 tracking-wider">
                                        YIELD <span class="text-red-400" x-text="nuke.yield"></span>
                                    </div>
                                    <div class="font-mono text-[9px] text-amber-600/65 tracking-wider">
                                        RADIUS <span class="text-amber-500" x-text="nuke.radius"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Personal message --}}
            <div class="px-3 pb-3 flex-shrink-0">
                <label class="font-mono text-[10px] text-[#5a3828]/75 uppercase tracking-widest block mb-1.5">
                    Personal Communiqué <span class="normal-case opacity-60">(optional)</span>
                </label>
                <textarea
                    x-model="message"
                    placeholder="e.g. 'With love, from your secret admirer.'"
                    class="w-full bg-[#090202] border border-red-950/35 text-[#c0a878]
                           font-mono text-xs p-3 resize-none focus:outline-none
                           focus:border-red-800/55 placeholder-[#3a1818]/55"
                    rows="3"
                ></textarea>
            </div>

            {{-- Launch section --}}
            <div class="p-4 mt-auto border-t border-red-900/28 flex-shrink-0">

                {{-- Status indicators --}}
                <div class="flex gap-5 mb-4 font-mono text-[10px] uppercase tracking-widest">
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full flex-shrink-0 transition-colors duration-300"
                             :class="target ? 'bg-green-500' : 'bg-red-950'"></div>
                        <span :class="target ? 'text-green-400' : 'text-red-950'">Target</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full flex-shrink-0 transition-colors duration-300"
                             :class="selectedNuke ? 'bg-green-500' : 'bg-red-950'"></div>
                        <span :class="selectedNuke ? 'text-green-400' : 'text-red-950'">Payload</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full flex-shrink-0 bg-green-500 warning-blink-slow"></div>
                        <span class="text-green-400">Auth</span>
                    </div>
                </div>

                {{-- Hidden form submitted by JS --}}
                <form id="launch-form" method="POST" action="{{ route('launch') }}" style="display:none;">
                    @csrf
                </form>

                <button
                    type="button"
                    @click="submitLaunch()"
                    class="btn-launch w-full py-4 text-white font-display tracking-[0.2em] text-base uppercase"
                    :disabled="!target || !selectedNuke || launching"
                    :class="{ 'opacity-30 cursor-not-allowed': !target || !selectedNuke || launching }"
                >
                    <span x-show="!launching">🚀&nbsp; LAUNCH</span>
                    <span x-show="launching" x-cloak class="warning-blink">LAUNCHING...</span>
                </button>

                <p class="font-mono text-[9px] text-[#3a1818]/55 mt-3 text-center tracking-wider">
                    Simulated strikes only. No refunds. No regrets.
                </p>
            </div>

        </div>
    </div>

    {{-- Bottom danger stripe --}}
    <div class="danger-stripe"></div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('deployConsole', () => ({
        target:       null,
        selectedNuke: null,
        message:      '',
        launching:    false,
        coordLabel:   '',
        utcTime:      '--:--:-- UTC',
        _map:         null,
        _marker:      null,

        nukes: [
            {
                id:     'tactical-tickle',
                icon:   '💥',
                name:   'The Tactical Tickle',
                desc:   'Small, intimate. Makes a point without ruining the neighborhood property values.',
                yield:  '0.1 kt',
                radius: '0.8 km',
            },
            {
                id:     'ex-terminator',
                icon:   '❤️‍🔥',
                name:   'The Ex Terminator',
                desc:   'Precision-guided. You know exactly where to aim this one.',
                yield:  '5 kt',
                radius: '3.2 km',
            },
            {
                id:     'corporate-restructuring',
                icon:   '💼',
                name:   'The Corporate Restructuring',
                desc:   'Eliminates deadweight with surgical efficiency. HR approved.',
                yield:  '15 kt',
                radius: '7.1 km',
            },
            {
                id:     'birthday-surprise',
                icon:   '🎂',
                name:   'The Birthday Surprise',
                desc:   "Because birthday candles don't cut it anymore. Happy Birthday.",
                yield:  '50 kt',
                radius: '14 km',
            },
            {
                id:     'monday-obliterator',
                icon:   '📅',
                name:   'The Monday Obliterator',
                desc:   "For when the week has barely started and you're already done with it.",
                yield:  '150 kt',
                radius: '28 km',
            },
            {
                id:     'thermonuclear-hug',
                icon:   '🤗',
                name:   'The Thermonuclear Hug',
                desc:   'Warm. Very warm. Uncontrollably warm. Our most popular seasonal gift.',
                yield:  '1 MT',
                radius: '110 km',
            },
        ],

        init() {
            this.tick();
            setInterval(() => this.tick(), 1000);
            this.$nextTick(() => this.initMap());
        },

        tick() {
            const d = new Date();
            const pad = n => String(n).padStart(2, '0');
            this.utcTime = `${pad(d.getUTCHours())}:${pad(d.getUTCMinutes())}:${pad(d.getUTCSeconds())} UTC`;
        },

        initMap() {
            this._map = L.map('nuke-map', {
                center: [25, 15],
                zoom: 2,
                zoomControl: true,
                attributionControl: true,
            });

            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 19,
            }).addTo(this._map);

            const crosshairIcon = L.divIcon({
                html: `<div style="
                    width:44px;height:44px;position:relative;
                    transform:translate(-50%,-50%);
                ">
                    <div style="position:absolute;top:50%;left:0;right:0;height:2px;
                        background:#ff1a1a;transform:translateY(-50%);
                        box-shadow:0 0 7px #ff0000,0 0 14px #cc000088;"></div>
                    <div style="position:absolute;left:50%;top:0;bottom:0;width:2px;
                        background:#ff1a1a;transform:translateX(-50%);
                        box-shadow:0 0 7px #ff0000,0 0 14px #cc000088;"></div>
                    <div style="position:absolute;top:50%;left:50%;
                        transform:translate(-50%,-50%);
                        width:14px;height:14px;border:2px solid #ff1a1a;border-radius:50%;
                        box-shadow:0 0 10px #ff0000;"></div>
                </div>`,
                className: '',
                iconSize:   [44, 44],
                iconAnchor: [22, 22],
            });

            this._map.on('click', (e) => {
                const { lat, lng } = e.latlng;
                this.target     = { lat, lng };
                this.coordLabel = `${lat.toFixed(4)}°, ${lng.toFixed(4)}°`;

                if (this._marker) {
                    this._marker.setLatLng(e.latlng);
                } else {
                    this._marker = L.marker(e.latlng, { icon: crosshairIcon })
                        .addTo(this._map);
                }

                // Expanding ring animation
                const ring = L.circle(e.latlng, {
                    color: '#ff2020', weight: 1, opacity: 0.55,
                    fillOpacity: 0, radius: 80000,
                }).addTo(this._map);
                setTimeout(() => this._map.removeLayer(ring), 1600);
            });
        },

        submitLaunch() {
            if (!this.target || !this.selectedNuke || this.launching) return;
            this.launching = true;

            const form = document.getElementById('launch-form');
            const add  = (name, val) => {
                const inp  = document.createElement('input');
                inp.type   = 'hidden';
                inp.name   = name;
                inp.value  = val;
                form.appendChild(inp);
            };

            add('lat',       this.target.lat);
            add('lng',       this.target.lng);
            add('nuke_type', this.selectedNuke);
            add('message',   this.message);

            form.submit();
        },
    }));
});
</script>
@endpush