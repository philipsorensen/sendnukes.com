```
  ███████╗███████╗███╗   ██╗██████╗ ███╗   ██╗██╗   ██╗██╗  ██╗███████╗███████╗
  ██╔════╝██╔════╝████╗  ██║██╔══██╗████╗  ██║██║   ██║██║ ██╔╝██╔════╝██╔════╝
  ███████╗█████╗  ██╔██╗ ██║██║  ██║██╔██╗ ██║██║   ██║█████╔╝ █████╗  ███████╗
  ╚════██║██╔══╝  ██║╚██╗██║██║  ██║██║╚██╗██║██║   ██║██╔═██╗ ██╔══╝  ╚════██║
  ███████║███████╗██║ ╚████║██████╔╝██║ ╚████║╚██████╔╝██║  ██╗███████╗███████║
  ╚══════╝╚══════╝╚═╝  ╚═══╝╚═════╝ ╚═╝  ╚═══╝ ╚═════╝ ╚═╝  ╚═╝╚══════╝╚══════╝
                               ☢  s e n d n u k e s . c o m  ☢
```

> *"Because flowers don't leave a crater."*

---

## What is this?

**sendnukes.com** is a dark-humor, absurdist satire greeting site. Instead of sending flowers or an e-card, you drop a nuclear payload on a loved one's city — complete with a mushroom cloud animation, a dramatic launch sequence, and a personalized destruction certificate.

It is, of course, completely fictional. No nukes were harmed in the making of this website.

---

## The Experience

```
  [ Landing Page ]
       ↓  Click "INITIATE LAUNCH"
  [ Deploy ]  — pick a target on the map, choose your payload, write a message
       ↓  POST /launch
  [ Launch Sequence ]  — animated countdown + mushroom cloud
       ↓  auto-redirect
  [ Confirmation ]  — official certificate of devastation
```

### Available Payloads

| ID | Name | Crater Radius | Est. Casualties |
|----|------|--------------|----------------|
| `tactical-tickle` | The Tactical Tickle | 0.8 km | ~2,400 |
| `ex-terminator` | The Ex Terminator | 3.2 km | ~48,000 |
| `corporate-restructuring` | The Corporate Restructuring | 7.1 km | ~140,000 |
| `birthday-surprise` | The Birthday Surprise | 14.0 km | ~420,000 |
| `monday-obliterator` | The Monday Obliterator | 28.5 km | ~980,000 |
| `thermonuclear-hug` | The Thermonuclear Hug | 110.0 km | ~4,800,000 |

*(Casualty figures include ±20% random variance for replayability.)*

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel (PHP) |
| Frontend | Blade templates |
| Styles | Tailwind CSS v4 (via `@tailwindcss/vite`) |
| JS | Alpine.js v3 (CDN) |
| Maps | Leaflet.js v1.9.4 — dark CartoDB tiles |
| Build | Vite |

### Fonts
- **Russo One** — display headings
- **Bebas Neue** — numerals & countdowns
- **Courier Prime** — monospace / body
- **Special Elite** — stencil / certificate stamp

### Design Language
Near-black backgrounds, deep red (`#b80000`), radioactive green (`#33ff00`), amber warnings. Grain overlay, flicker animations, danger stripes, CSS mushroom cloud, nuclear flash, shockwave rings.

---

## Routes

```
GET  /              Landing page
GET  /deploy        Target selector (map + nuke picker)
POST /launch        Validate input, store in session, redirect →
GET  /launch        Animated launch sequence
GET  /confirmation  Certificate of devastation
```

---

## Local Setup

```bash
# Clone & install
git clone <repo-url> sendnukes.com
cd sendnukes.com

composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Run
php artisan serve &
npm run dev
```

Open `http://localhost:8000` and begin your warmongering.

---

## Views

```
resources/views/
├── layouts/
│   └── nuke.blade.php        Base layout (fonts, Alpine, Vite)
├── welcome.blade.php          Landing page
├── deploy.blade.php           Map + nuke selector
├── launch.blade.php           Animated launch sequence
└── confirmation.blade.php     Destruction certificate
```

---

## Disclaimer

This is **satire**. No real weapons, no real harm, no real nukes. Just dark humor and questionable taste in greeting cards. Please don't send this to your ex without a sense of irony.

---

---

☢ &nbsp; Built with Laravel, questionable judgment, and a deep appreciation for absurdism &nbsp; ☢