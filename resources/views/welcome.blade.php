<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Full-Stack Developer — Portfolio</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        /* ── Reset & Base ───────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #000000;
            --bg-2:      transparent;
            --bg-card:   rgba(10, 10, 12, 0.75);
            --border:    rgba(255,255,255,0.08);
            --text:      #f0f0f0;
            --muted:     #888888;
            --accent:    #a855f7;      /* violet-purple */
            --accent-dim: #7c3aed;    /* deeper purple for gradients */
            --accent-2:  #ffffff;
            --radius:    12px;
        }

        html { scroll-behavior: smooth; }

        body {
            background: #000000;
            color: var(--text);
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ── Fixed star background canvas ──────────────────────────── */
        #star-canvas {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        /* ── Section dividers ───────────────────────────────────────── */
        section:not(#home) {
            position: relative;
        }
        section:not(#home)::before {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--border), transparent);
        }

        /* ── Scrollbar ──────────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 2px; box-shadow: 0 0 6px rgba(168,85,247,0.6); }

        /* ── Selection ──────────────────────────────────────────────── */
        ::selection { background: var(--accent); color: #000; }

        /* ── Utility ────────────────────────────────────────────────── */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
        .section-label {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--accent);
            display: block;
            margin-bottom: 0.75rem;
        }
        .fade-in { opacity: 0; transform: translateY(28px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        /* ── Navbar ─────────────────────────────────────────────────── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.4s ease, backdrop-filter 0.4s ease;
        }
        nav.scrolled {
            background: rgba(8,8,8,0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
        }
        .nav-logo {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.08em;
            color: var(--text);
            text-decoration: none;
        }
        .nav-logo span { color: var(--accent); }
        .nav-links { display: flex; gap: 2.5rem; list-style: none; }
        .nav-links a {
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
            position: relative;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -3px; left: 0;
            width: 0; height: 1px;
            background: var(--accent);
            transition: width 0.3s ease;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--text); }
        .nav-links a:hover::after, .nav-links a.active::after { width: 100%; }

        /* Hamburger */
        .nav-toggle { display: none; background: none; border: none; cursor: pointer; color: var(--text); font-size: 1.3rem; }
        .nav-mobile { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(8,8,8,0.98); z-index: 99; flex-direction: column; align-items: center; justify-content: center; gap: 2.5rem; }
        .nav-mobile.open { display: flex; }
        .nav-mobile a { font-size: 1.8rem; font-weight: 700; color: var(--text); text-decoration: none; letter-spacing: 0.06em; transition: color 0.2s; }
        .nav-mobile a:hover { color: var(--accent); }
        .nav-mobile-close { position: absolute; top: 1.5rem; right: 2rem; background: none; border: none; color: var(--muted); font-size: 1.5rem; cursor: pointer; }

        /* ── Hero ───────────────────────────────────────────────────── */
        #home {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* Three.js canvas fills full hero */
        #hero-canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        /* Dark gradient overlay so text is readable over the 3D scene */
        #home::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.80) 0%, rgba(0,0,0,0.25) 55%, rgba(0,0,0,0.0) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 8rem 2rem 6rem 6rem;
            max-width: 680px;
        }
        /* Purple ambient glow behind hero text */
        .hero-content::before {
            content: '';
            position: absolute;
            top: 50%; left: 20%;
            transform: translate(-50%, -50%);
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(168,85,247,0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: -1;
        }

        .hero-eyebrow {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .hero-eyebrow-line {
            width: 40px; height: 1px;
            background: var(--accent);
        }
        .hero-eyebrow span {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--accent);
        }

        .hero-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(3rem, 7vw, 6.5rem);
            font-weight: 700;
            line-height: 1.0;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }
        .hero-name .dim { color: rgba(240,240,240,0.18); }

        .hero-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(1rem, 2.5vw, 1.5rem);
            font-weight: 400;
            color: var(--muted);
            margin-bottom: 1.75rem;
        }
        .hero-title strong { color: var(--accent); font-weight: 600; }

        .hero-bio {
            font-size: 0.95rem;
            color: var(--muted);
            max-width: 420px;
            line-height: 1.8;
            margin-bottom: 2.5rem;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.8rem;
            background: var(--accent);
            color: #fff;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 2px;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover { background: #9333ea; transform: translateY(-2px); box-shadow: 0 0 24px rgba(168,85,247,0.4); }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.8rem;
            background: transparent;
            color: var(--text);
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            border: 1px solid var(--border);
            border-radius: 2px;
            transition: border-color 0.2s, color 0.2s, transform 0.2s;
        }
        .btn-outline:hover { border-color: var(--accent); color: var(--accent); transform: translateY(-2px); }

        .hero-scroll-hint {
            position: absolute;
            bottom: 2.5rem;
            left: 6rem;
            z-index: 3;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--muted);
            font-size: 0.72rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }
        .scroll-line {
            width: 40px; height: 1px;
            background: var(--muted);
            animation: scrollPulse 2s ease-in-out infinite;
        }
        @keyframes scrollPulse {
            0%, 100% { width: 40px; opacity: 1; }
            50% { width: 70px; opacity: 0.5; }
        }

        /* ── About ──────────────────────────────────────────────────── */
        #about { padding: 7rem 0; background: transparent; }
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1.3fr;
            gap: 5rem;
            align-items: center;
        }
        .about-img-wrap {
            position: relative;
        }
        .about-img-wrap img {
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            object-position: top;
            filter: brightness(0.8) contrast(1.1) grayscale(0.2);
            border-radius: var(--radius);
        }
        .about-img-frame {
            position: absolute;
            top: 1.5rem; left: 1.5rem; right: -1.5rem; bottom: -1.5rem;
            border: 1px solid var(--accent);
            border-radius: var(--radius);
            pointer-events: none;
            opacity: 0.35;
            box-shadow: 0 0 40px rgba(168,85,247,0.15);
        }
        .about-badge {
            position: absolute;
            bottom: -1.5rem; right: -1rem;
            background: rgba(8, 8, 10, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem 1.25rem;
            text-align: center;
        }
        .about-badge .num {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
            display: block;
        }
        .about-badge .label { font-size: 0.72rem; color: var(--muted); letter-spacing: 0.08em; }

        .about-heading {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 1.5rem;
        }
        .about-heading span { color: var(--accent); }

        .about-text {
            color: var(--muted);
            line-height: 1.9;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .about-facts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem 2rem;
            margin-top: 2rem;
        }
        .about-fact {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
        }
        .about-fact .key {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--muted);
        }
        .about-fact .val {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text);
        }

        /* ── Skills ─────────────────────────────────────────────────── */
        #skills { padding: 7rem 0; }
        .skills-heading-wrap {
            margin-bottom: 3.5rem;
        }
        .section-heading {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 700;
            line-height: 1.1;
        }
        .section-heading span { color: var(--accent); }

        .skills-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }
        .skills-tab {
            padding: 0.5rem 1.25rem;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border: 1px solid var(--border);
            border-radius: 2px;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.2s;
        }
        .skills-tab.active, .skills-tab:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #000;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .skill-item {
            background: rgba(8, 8, 10, 0.72);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            transition: background 0.2s;
        }
        .skill-item:hover { background: #161616; }
        .skill-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .skill-name {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .skill-icon {
            width: 28px; height: 28px;
            border-radius: 6px;
            background: rgba(168,85,247,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: var(--accent);
        }
        .skill-pct {
            font-size: 0.75rem;
            color: var(--muted);
        }
        .skill-bar {
            height: 2px;
            background: var(--border);
            border-radius: 2px;
            overflow: hidden;
        }
        .skill-bar-fill {
            height: 100%;
            background: linear-gradient(to right, #7c3aed, #a855f7);
            border-radius: 2px;
            width: 0;
            transition: width 1s ease 0.3s;
        }

        /* ── Projects ───────────────────────────────────────────────── */
        #projects { padding: 7rem 0; background: transparent; }
        .projects-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 3rem;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
        }
        .project-card {
            background: rgba(8, 8, 10, 0.72);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: transform 0.3s ease, border-color 0.3s;
            display: flex;
            flex-direction: column;
        }
        .project-card:hover { transform: translateY(-6px); border-color: rgba(168,85,247,0.4); box-shadow: 0 8px 32px rgba(168,85,247,0.1); }

        .project-card.large { grid-column: span 7; }
        .project-card.small { grid-column: span 5; }
        .project-card.full  { grid-column: span 4; }

        .project-thumb {
            width: 100%;
            aspect-ratio: 16/9;
            background: #0d0d0d;
            overflow: hidden;
            position: relative;
        }
        .project-thumb-inner {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: rgba(200,169,110,0.15);
            transition: transform 0.4s ease;
        }
        .project-card:hover .project-thumb-inner { transform: scale(1.08); }

        .project-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .project-tags {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
        }
        .project-tag {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.2rem 0.6rem;
            border: 1px solid var(--border);
            border-radius: 2px;
            color: var(--muted);
        }
        .project-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
        }
        .project-desc { font-size: 0.85rem; color: var(--muted); line-height: 1.7; flex: 1; }
        .project-links {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }
        .project-link {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--accent);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            transition: opacity 0.2s;
        }
        .project-link:hover { opacity: 0.7; }

        /* ── Experience ─────────────────────────────────────────────── */
        #experience { padding: 7rem 0; }
        .exp-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem 5rem;
        }
        .exp-col-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .exp-col-title i { color: var(--accent); }
        .timeline { display: flex; flex-direction: column; gap: 0; }
        .timeline-item {
            position: relative;
            padding-left: 1.5rem;
            padding-bottom: 2rem;
        }
        .timeline-item:last-child { padding-bottom: 0; }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--accent);
        }
        .timeline-item::after {
            content: '';
            position: absolute;
            left: 3.5px;
            top: 18px;
            bottom: 0;
            width: 1px;
            background: var(--border);
        }
        .timeline-item:last-child::after { display: none; }
        .timeline-date {
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            color: var(--accent);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        .timeline-role {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 0.15rem;
        }
        .timeline-org { font-size: 0.82rem; color: var(--muted); margin-bottom: 0.5rem; }
        .timeline-desc { font-size: 0.82rem; color: var(--muted); line-height: 1.7; }

        /* ── Contact ────────────────────────────────────────────────── */
        #contact { padding: 7rem 0; background: transparent; }
        .contact-inner {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 5rem;
            align-items: start;
        }
        .contact-heading {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.25rem;
        }
        .contact-heading span { color: var(--accent); }
        .contact-sub { font-size: 0.95rem; color: var(--muted); line-height: 1.8; margin-bottom: 2.5rem; }
        .contact-socials {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .contact-social-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 1.25rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            text-decoration: none;
            color: var(--text);
            font-size: 0.88rem;
            font-weight: 500;
            transition: border-color 0.2s, background 0.2s;
        }
        .contact-social-link:hover { border-color: var(--accent); background: rgba(200,169,110,0.05); }
        .contact-social-link i { width: 20px; color: var(--accent); font-size: 1rem; }

        /* Form */
        .contact-form { display: flex; flex-direction: column; gap: 1rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
        .form-group label { font-size: 0.75rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); }
        .form-group input, .form-group textarea {
            background: rgba(8, 8, 10, 0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.75rem 1rem;
            color: var(--text);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s;
            outline: none;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: var(--accent); }
        .form-group textarea { resize: vertical; min-height: 120px; }

        /* ── Footer ─────────────────────────────────────────────────── */
        footer {
            padding: 2rem 0;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }
        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            width: 100%;
            flex-wrap: wrap;
        }
        .footer-copy { font-size: 0.8rem; color: var(--muted); }
        .footer-copy span { color: var(--accent); }
        .footer-links { display: flex; gap: 1.5rem; }
        .footer-links a { font-size: 0.8rem; color: var(--muted); text-decoration: none; transition: color 0.2s; }
        .footer-links a:hover { color: var(--accent); }

        /* ── Responsive ─────────────────────────────────────────────── */
        @media (max-width: 1024px) {
            .hero-content { padding: 8rem 2rem 4rem; max-width: 600px; }
            .hero-scroll-hint { left: 2rem; }
            .about-grid { grid-template-columns: 1fr; gap: 3rem; }
            .about-img-wrap { max-width: 360px; margin: 0 auto; }
            .exp-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .contact-inner { grid-template-columns: 1fr; gap: 3rem; }
            .project-card.large, .project-card.small { grid-column: span 12; }
            .project-card.full  { grid-column: span 12; }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-toggle { display: block; }
            .form-row { grid-template-columns: 1fr; }
            .about-facts { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- Fixed star background (behind everything) -->
<canvas id="star-canvas"></canvas>

<!-- ══ NAVBAR ════════════════════════════════════════════════════════ -->
<nav id="navbar">
    <a href="#home" class="nav-logo">DEV<span>.</span></a>
    <ul class="nav-links">
        <li><a href="#home" class="active">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#skills">Skills</a></li>
        <li><a href="#projects">Projects</a></li>
        <li><a href="#experience">Experience</a></li>
        <li><a href="#contact">Contact</a></li>
    </ul>
    <button class="nav-toggle" id="navToggle" aria-label="Open menu">
        <i class="fa-solid fa-bars"></i>
    </button>
</nav>

<!-- Mobile Nav -->
<div class="nav-mobile" id="navMobile">
    <button class="nav-mobile-close" id="navClose"><i class="fa-solid fa-xmark"></i></button>
    <a href="#home" onclick="closeMobile()">Home</a>
    <a href="#about" onclick="closeMobile()">About</a>
    <a href="#skills" onclick="closeMobile()">Skills</a>
    <a href="#projects" onclick="closeMobile()">Projects</a>
    <a href="#experience" onclick="closeMobile()">Experience</a>
    <a href="#contact" onclick="closeMobile()">Contact</a>
</div>

<!-- ══ HERO ══════════════════════════════════════════════════════════ -->
<section id="home">
    <!-- Three.js 3D scene -->
    <canvas id="hero-canvas"></canvas>

    <div class="hero-content">
        <div class="hero-eyebrow">
            <div class="hero-eyebrow-line"></div>
            <span>Full-Stack Developer</span>
        </div>

        <h1 class="hero-name">
            Mr. Neang<br>
            <span class="dim">Rothana</span><span style="color:var(--accent)">.</span>
        </h1>

        <p class="hero-title">
            Building <strong>scalable products</strong> from frontend to backend
        </p>

        <p class="hero-bio">
            Passionate full-stack developer who turns ideas into polished digital experiences.
            I write clean code, ship fast, and obsess over the details that make software feel great.
        </p>

        <div class="hero-cta">
            <a href="#projects" class="btn-primary">
                <i class="fa-solid fa-code"></i> View Work
            </a>
            <a href="#contact" class="btn-outline">
                <i class="fa-solid fa-paper-plane"></i> Let's Talk
            </a>
        </div>
    </div>

    <div class="hero-scroll-hint">
        <div class="scroll-line"></div>
        <span>Scroll down</span>
    </div>
</section>

<!-- ══ ABOUT ══════════════════════════════════════════════════════════ -->
<section id="about">
    <div class="container">
        <div class="about-grid fade-in">
            <div class="about-img-wrap">
                <img src="{{ asset('images/hero.png') }}" alt="About photo"
                     onerror="this.src='https://via.placeholder.com/400x540/111111/888888?text=Photo'">
                <div class="about-img-frame"></div>
                <div class="about-badge">
                    <span class="num">Y4</span>
                    <span class="label">University</span>
                </div>
            </div>

            <div>
                <span class="section-label">About Me</span>
                <h2 class="about-heading">
                    Background &amp;<br><span>Goals</span>
                </h2>
                <p class="about-text">
                    I'm a full-stack developer with a strong foundation in both frontend and backend technologies. 
                    I love working on projects that challenge me to think across the entire stack — from crafting 
                    pixel-perfect interfaces to architecting solid server-side logic.
                </p>
                <p class="about-text">
                    My goal is to build products that are not only technically sound but also genuinely enjoyable 
                    to use. I'm always learning, always shipping, and always raising the bar for myself.
                </p>

                <div class="about-facts">
                    <div class="about-fact">
                        <span class="key">Name</span>
                        <span class="val">Mr. Neang Rothana</span>
                    </div>
                    <div class="about-fact">
                        <span class="key">Location</span>
                        <span class="val">Phnom Penh, Cambodia</span>
                    </div>
                    <div class="about-fact">
                        <span class="key">Focus</span>
                        <span class="val">Full-Stack Dev</span>
                    </div>
                    <div class="about-fact">
                        <span class="key">Status</span>
                        <span class="val">Year 4 Student</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ SKILLS ══════════════════════════════════════════════════════════ -->
<section id="skills">
    <div class="container">
        <div class="skills-heading-wrap fade-in">
            <span class="section-label">Technical Abilities</span>
            <h2 class="section-heading">My <span>Skills</span></h2>
        </div>

        <div class="skills-tabs fade-in">
            <button class="skills-tab active" data-filter="all">All</button>
            <button class="skills-tab" data-filter="frontend">Frontend</button>
            <button class="skills-tab" data-filter="backend">Backend</button>
            <button class="skills-tab" data-filter="tools">Tools & DevOps</button>
        </div>

        <div class="skills-grid fade-in" id="skillsGrid">
            <!-- Frontend -->
            <div class="skill-item" data-cat="frontend">
                <div class="skill-top">
                    <div class="skill-name"><span class="skill-icon"><i class="fa-brands fa-html5"></i></span> HTML5</div>
                    <span class="skill-pct">95%</span>
                </div>
                <div class="skill-bar"><div class="skill-bar-fill" data-width="95"></div></div>
            </div>
            <div class="skill-item" data-cat="frontend">
                <div class="skill-top">
                    <div class="skill-name"><span class="skill-icon"><i class="fa-brands fa-css3-alt"></i></span> CSS3 / Tailwind</div>
                    <span class="skill-pct">90%</span>
                </div>
                <div class="skill-bar"><div class="skill-bar-fill" data-width="90"></div></div>
            </div>
            <div class="skill-item" data-cat="frontend">
                <div class="skill-top">
                    <div class="skill-name"><span class="skill-icon"><i class="fa-brands fa-js"></i></span> JavaScript / ES6+</div>
                    <span class="skill-pct">88%</span>
                </div>
                <div class="skill-bar"><div class="skill-bar-fill" data-width="88"></div></div>
            </div>
            <div class="skill-item" data-cat="frontend">
                <div class="skill-top">
                    <div class="skill-name"><span class="skill-icon"><i class="fa-brands fa-react"></i></span> React.js</div>
                    <span class="skill-pct">82%</span>
                </div>
                <div class="skill-bar"><div class="skill-bar-fill" data-width="82"></div></div>
            </div>
            <!-- Backend -->
            <div class="skill-item" data-cat="backend">
                <div class="skill-top">
                    <div class="skill-name"><span class="skill-icon"><i class="fa-brands fa-php"></i></span> PHP / Laravel</div>
                    <span class="skill-pct">90%</span>
                </div>
                <div class="skill-bar"><div class="skill-bar-fill" data-width="90"></div></div>
            </div>
            <div class="skill-item" data-cat="backend">
                <div class="skill-top">
                    <div class="skill-name"><span class="skill-icon"><i class="fa-brands fa-node-js"></i></span> Node.js</div>
                    <span class="skill-pct">78%</span>
                </div>
                <div class="skill-bar"><div class="skill-bar-fill" data-width="78"></div></div>
            </div>
            <div class="skill-item" data-cat="backend">
                <div class="skill-top">
                    <div class="skill-name"><span class="skill-icon"><i class="fa-solid fa-database"></i></span> MySQL / PostgreSQL</div>
                    <span class="skill-pct">85%</span>
                </div>
                <div class="skill-bar"><div class="skill-bar-fill" data-width="85"></div></div>
            </div>
            <div class="skill-item" data-cat="backend">
                <div class="skill-top">
                    <div class="skill-name"><span class="skill-icon"><i class="fa-solid fa-server"></i></span> REST API Design</div>
                    <span class="skill-pct">87%</span>
                </div>
                <div class="skill-bar"><div class="skill-bar-fill" data-width="87"></div></div>
            </div>
            <!-- Tools -->
            <div class="skill-item" data-cat="tools">
                <div class="skill-top">
                    <div class="skill-name"><span class="skill-icon"><i class="fa-brands fa-git-alt"></i></span> Git / GitHub</div>
                    <span class="skill-pct">92%</span>
                </div>
                <div class="skill-bar"><div class="skill-bar-fill" data-width="92"></div></div>
            </div>
        </div>
    </div>
</section>

<!-- ══ PROJECTS ══════════════════════════════════════════════════════ -->
<section id="projects">
    <div class="container">
        <div class="projects-header fade-in">
            <div>
                <span class="section-label">Your Best Work</span>
                <h2 class="section-heading">Featured <span>Projects</span></h2>
            </div>
            <a href="https://github.com/SteroiCode" target="_blank" class="btn-outline" style="white-space:nowrap;">
                <i class="fa-brands fa-github"></i> GitHub
            </a>
        </div>

        <div class="projects-grid fade-in">
            <!-- Large featured project -->
            <div class="project-card large">
                <div class="project-thumb">
                    <div class="project-thumb-inner">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                </div>
                <div class="project-body">
                    <div class="project-tags">
                        <span class="project-tag">Laravel</span>
                        <span class="project-tag">React</span>
                        <span class="project-tag">MySQL</span>
                        <span class="project-tag">Featured</span>
                    </div>
                    <h3 class="project-title">E-Commerce Platform</h3>
                    <p class="project-desc">
                        A full-featured online store with product management, cart system, Stripe payments,
                        order tracking, and an admin dashboard. Built with Laravel API + React frontend.
                    </p>
                    <div class="project-links">
                        <a href="#" class="project-link"><i class="fa-brands fa-github"></i> Code</a>
                        <a href="#" class="project-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> Live Demo</a>
                    </div>
                </div>
            </div>

            <!-- Secondary project -->
            <div class="project-card small">
                <div class="project-thumb">
                    <div class="project-thumb-inner">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                </div>
                <div class="project-body">
                    <div class="project-tags">
                        <span class="project-tag">Node.js</span>
                        <span class="project-tag">Vue</span>
                        <span class="project-tag">PostgreSQL</span>
                    </div>
                    <h3 class="project-title">Analytics Dashboard</h3>
                    <p class="project-desc">
                        Real-time data visualization dashboard with custom charts, user role management,
                        and CSV export functionality.
                    </p>
                    <div class="project-links">
                        <a href="#" class="project-link"><i class="fa-brands fa-github"></i> Code</a>
                        <a href="#" class="project-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> Live</a>
                    </div>
                </div>
            </div>

            <!-- Bottom row -->
            <div class="project-card full">
                <div class="project-thumb" style="aspect-ratio:16/8; overflow:hidden; position:relative;">
                    <iframe
                        src="https://aquarium-booking-production.up.railway.app"
                        style="width:200%; height:200%; border:none; transform:scale(0.5); transform-origin:top left; pointer-events:none;"
                        loading="lazy"
                        scrolling="no"
                        title="Aquariums Booking Preview"
                    ></iframe>
                    <div style="position:absolute;inset:0;"></div>
                </div>
                <div class="project-body">
                    <div class="project-tags">
                        <span class="project-tag">Laravel</span>
                        <span class="project-tag">PHP</span>
                        <span class="project-tag">MySQL</span>
                    </div>
                    <h3 class="project-title">Aquariums Booking</h3>
                    <p class="project-desc">An aquarium ticket booking system with scheduling, seat management, and admin controls.</p>
                    <div class="project-links">
                        <a href="https://github.com/SteroiCode/aquariums-booking" target="_blank" class="project-link"><i class="fa-brands fa-github"></i> Code</a>
                        <a href="https://aquarium-booking-production.up.railway.app" target="_blank" class="project-link"><i class="fa-solid fa-arrow-up-right-from-square"></i> Live Demo</a>
                    </div>
                </div>
            </div>

            <div class="project-card full">
                <div class="project-thumb" style="aspect-ratio:16/8">
                    <div class="project-thumb-inner">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                </div>
                <div class="project-body">
                    <div class="project-tags">
                        <span class="project-tag">Laravel</span>
                        <span class="project-tag">WebSockets</span>
                    </div>
                    <h3 class="project-title">Real-Time Chat App</h3>
                    <p class="project-desc">WebSocket-powered messaging with rooms, auth, and file sharing.</p>
                    <div class="project-links">
                        <a href="#" class="project-link"><i class="fa-brands fa-github"></i> Code</a>
                    </div>
                </div>
            </div>

            <div class="project-card full">
                <div class="project-thumb" style="aspect-ratio:16/8">
                    <div class="project-thumb-inner">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                </div>
                <div class="project-body">
                    <div class="project-tags">
                        <span class="project-tag">React</span>
                        <span class="project-tag">REST API</span>
                    </div>
                    <h3 class="project-title">Portfolio CMS</h3>
                    <p class="project-desc">Headless CMS for portfolio management with drag-and-drop ordering.</p>
                    <div class="project-links">
                        <a href="#" class="project-link"><i class="fa-brands fa-github"></i> Code</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ EXPERIENCE ════════════════════════════════════════════════════ -->
<section id="experience">
    <div class="container">
        <div class="fade-in" style="margin-bottom:3.5rem">
            <span class="section-label">Education & Work</span>
            <h2 class="section-heading">My <span>Experience</span></h2>
        </div>

        <div class="exp-grid fade-in">
            <!-- Work -->
            <div>
                <div class="exp-col-title">
                    <i class="fa-solid fa-briefcase"></i> Work History
                </div>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">1 Year · Duration</div>
                        <div class="timeline-role">IT Support & Network Technician</div>
                        <div class="timeline-org">Company Name · Full-time</div>
                        <div class="timeline-desc">
                            Installed and configured CCTV security camera systems and Wi-Fi routers.
                            Assisted with network setup, cable connections, and troubleshooting.
                            Performed basic maintenance and resolved connectivity issues.
                            Supported users with basic technical and network-related problems.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Education -->
            <div>
                <div class="exp-col-title">
                    <i class="fa-solid fa-graduation-cap"></i> Education
                </div>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">Currently Year 4</div>
                        <div class="timeline-role">Bachelor of Software Engineering</div>
                        <div class="timeline-org">BELTEI International University</div>
                        <div class="timeline-desc">
                            Studying software engineering with a focus on full-stack development,
                            data structures, algorithms, databases, and software architecture.
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">Completed</div>
                        <div class="timeline-role">High School Diploma</div>
                        <div class="timeline-org">CPV High School</div>
                        <div class="timeline-desc">
                            Completed high school education. Also studied Arduino programming,
                            microcontroller fundamentals, and electronic components at the same institution.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ CONTACT ════════════════════════════════════════════════════════ -->
<section id="contact">
    <div class="container">
        <div class="contact-inner fade-in">
            <div>
                <span class="section-label">Email & Social Links</span>
                <h2 class="contact-heading">Let's <span>Build</span><br>Something.</h2>
                <p class="contact-sub">
                    Have a project in mind or just want to connect? 
                    I'm currently open to new opportunities and collaborations. 
                    Drop me a message — I'll get back to you within 24 hours.
                </p>

                <div class="contact-socials">
                    <a href="mailto:nrothana41@gmail.com" class="contact-social-link">
                        <i class="fa-solid fa-envelope"></i>
                        <span>nrothana41@gmail.com</span>
                    </a>
                    <a href="https://github.com/SteroiCode" target="_blank" class="contact-social-link">
                        <i class="fa-brands fa-github"></i>
                        <span>github.com/SteroiCode</span>
                    </a>
                    <a href="https://www.linkedin.com/feed/" target="_blank" class="contact-social-link">
                        <i class="fa-brands fa-linkedin"></i>
                        <span>LinkedIn — Mr. Neang Rothana</span>
                    </a>
                    <a href="https://t.me/STEROI1" target="_blank" class="contact-social-link">
                        <i class="fa-brands fa-telegram"></i>
                        <span>Telegram — @STEROI1</span>
                    </a>
                </div>

                <!-- Telegram QR Code -->
                <div style="margin-top:2rem;">
                    <p style="font-size:0.72rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--muted);margin-bottom:0.75rem;">
                        Scan to contact on Telegram
                    </p>
                    <a href="https://t.me/STEROI1" target="_blank" style="display:inline-block;">
                        <img src="{{ asset('images/telegram-qr.png') }}"
                             alt="Telegram QR @STEROI1"
                             style="width:140px;height:140px;border-radius:12px;border:1px solid var(--border);transition:transform 0.2s;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'"
                             onerror="this.parentElement.parentElement.style.display='none'">
                    </a>
                </div>
            </div>

            <form class="contact-form" onsubmit="handleSubmit(event)">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" placeholder="john@example.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" placeholder="Project Collaboration">
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" placeholder="Tell me about your project..." required></textarea>
                </div>
                <button type="submit" class="btn-primary" style="align-self:flex-start">
                    <i class="fa-solid fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ══ FOOTER ════════════════════════════════════════════════════════ -->
<footer>
    <div class="container">
        <div class="footer-inner">
            <p class="footer-copy">
                © 2026 <span>Mr. Neang Rothana</span>. Built with Laravel &amp; love.
            </p>
            <div class="footer-links">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#projects">Projects</a>
                <a href="#contact">Contact</a>
            </div>
        </div>
    </div>
</footer>

<!-- Three.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js"></script>

<!-- ══ STAR FIELD BACKGROUND (fixed, full page) ═══════════════════════ -->
<script>
window.addEventListener('load', function () {
    try {
        const canvas = document.getElementById('star-canvas');
        const renderer = new THREE.WebGLRenderer({ canvas, antialias: false, alpha: false });
        renderer.setPixelRatio(1);
        renderer.setSize(window.innerWidth, window.innerHeight, false);

        const scene = new THREE.Scene();
        scene.background = new THREE.Color(0x000000);

        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 1;

        window.addEventListener('resize', () => {
            renderer.setSize(window.innerWidth, window.innerHeight, false);
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
        });

        // ── Stars ──
        const count = 3000;
        const pos   = new Float32Array(count * 3);
        const sizes = new Float32Array(count);
        for (let i = 0; i < count; i++) {
            pos[i * 3]     = (Math.random() - 0.5) * 200;
            pos[i * 3 + 1] = (Math.random() - 0.5) * 200;
            pos[i * 3 + 2] = (Math.random() - 0.5) * 100 - 10;
            sizes[i] = Math.random() * 1.5 + 0.3;
        }
        const geo = new THREE.BufferGeometry();
        geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
        geo.setAttribute('size',     new THREE.BufferAttribute(sizes, 1));

        const mat = new THREE.ShaderMaterial({
            uniforms: { uTime: { value: 0 } },
            vertexShader: `
                attribute float size;
                uniform float uTime;
                varying float vAlpha;
                void main() {
                    vAlpha = 0.3 + 0.7 * fract(sin(dot(position.xy, vec2(12.9898,78.233))) * 43758.5453);
                    // subtle twinkle
                    float twinkle = 0.75 + 0.25 * sin(uTime * (0.5 + vAlpha) + position.x * 10.0);
                    vAlpha *= twinkle;
                    gl_PointSize = size * twinkle;
                    gl_Position  = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
                }
            `,
            fragmentShader: `
                varying float vAlpha;
                void main() {
                    float d = length(gl_PointCoord - 0.5);
                    if (d > 0.5) discard;
                    float a = (1.0 - d * 2.0) * vAlpha;
                    gl_FragColor = vec4(1.0, 1.0, 1.0, a);
                }
            `,
            transparent: true,
            depthWrite: false,
            blending: THREE.AdditiveBlending,
        });

        scene.add(new THREE.Points(geo, mat));

        let t = 0;
        function animate() {
            requestAnimationFrame(animate);
            t += 0.003;
            mat.uniforms.uTime.value = t;
            renderer.render(scene, camera);
        }
        animate();
    } catch(e) { console.error('Star canvas error:', e); }
});
</script>

<!-- ══ THREE.JS 3D HERO SCENE ════════════════════════════════════════ -->
<script>
window.addEventListener('load', function () {
try {
(function () {
    const canvas = document.getElementById('hero-canvas');
    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x000000, 0);

    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(55, 1, 0.01, 200);
    camera.position.set(0, 1.8, 5.5);
    camera.lookAt(0, 0, 0);

    function resize() {
        const s = document.getElementById('home');
        renderer.setSize(s.clientWidth, s.clientHeight, false);
        camera.aspect = s.clientWidth / s.clientHeight;
        camera.updateProjectionMatrix();
    }
    resize();
    window.addEventListener('resize', resize);

    /* ═══════════════════════════════════════════════════════
       1. EVENT HORIZON — solid black sphere
    ═══════════════════════════════════════════════════════ */
    const horizonGeo = new THREE.SphereGeometry(0.72, 128, 128);
    const horizonMat = new THREE.MeshBasicMaterial({ color: 0x000000 });
    const horizon = new THREE.Mesh(horizonGeo, horizonMat);
    scene.add(horizon);

    /* ═══════════════════════════════════════════════════════
       2. PHOTON SPHERE — razor-thin glowing rim around the black sphere
    ═══════════════════════════════════════════════════════ */
    const photonGeo = new THREE.SphereGeometry(0.76, 128, 128);
    const photonMat = new THREE.ShaderMaterial({
        uniforms: { uTime: { value: 0 } },
        vertexShader: `
            varying vec3 vNormal;
            varying vec3 vViewDir;
            void main() {
                vNormal  = normalize(normalMatrix * normal);
                vec4 mvPos = modelViewMatrix * vec4(position, 1.0);
                vViewDir = normalize(-mvPos.xyz);
                gl_Position = projectionMatrix * mvPos;
            }
        `,
        fragmentShader: `
            varying vec3 vNormal;
            varying vec3 vViewDir;
            uniform float uTime;
            void main() {
                float rim = 1.0 - max(dot(vNormal, vViewDir), 0.0);
                rim = pow(rim, 6.0);
                float b = rim * (0.7 + 0.1 * sin(uTime * 0.6));
                gl_FragColor = vec4(vec3(b * 0.95, b * 0.93, b * 0.88), rim * 0.55);
            }
        `,
        transparent: true,
        depthWrite: false,
        side: THREE.FrontSide,
        blending: THREE.AdditiveBlending,
    });
    scene.add(new THREE.Mesh(photonGeo, photonMat));

    /* ═══════════════════════════════════════════════════════
       3. GRAVITATIONAL LENSING — bright arc above the horizon
          Two thin tori stacked to fake the bent-light arc
    ═══════════════════════════════════════════════════════ */
    function makeLensArc(radius, tube, brightness) {
        const geo = new THREE.TorusGeometry(radius, tube, 64, 512);
        const mat = new THREE.ShaderMaterial({
            uniforms: { uTime: { value: 0 }, uBright: { value: brightness } },
            vertexShader: `
                varying vec2 vUv;
                void main() {
                    vUv = uv;
                    gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
                }
            `,
            fragmentShader: `
                varying vec2 vUv;
                uniform float uTime;
                uniform float uBright;
                void main() {
                    // Cross-section: bright thin line at centre
                    float edge = abs(vUv.y - 0.5) * 2.0;
                    float core = pow(1.0 - edge, 8.0);

                    // Only the top arc is bright (near side = gravitational lensing)
                    // vUv.x 0→1 around torus. Top ≈ 0.45–0.55, bottom ≈ 0.95–0.05
                    float nearTop = smoothstep(0.42, 0.50, vUv.x) * smoothstep(0.58, 0.50, vUv.x);
                    float nearBot = smoothstep(0.92, 0.98, vUv.x) + smoothstep(0.08, 0.02, vUv.x);
                    nearBot = clamp(nearBot, 0.0, 1.0) * 0.4;

                    float b = core * (nearTop + nearBot) * uBright;
                    gl_FragColor = vec4(vec3(b), b * 0.9);
                }
            `,
            transparent: true,
            depthWrite: false,
            side: THREE.DoubleSide,
            blending: THREE.AdditiveBlending,
        });
        return { mesh: new THREE.Mesh(geo, mat), mat };
    }

    // Primary bright photon ring just above horizon
    const lensA = makeLensArc(0.78, 0.015, 1.4);
    lensA.mesh.rotation.x = Math.PI * 0.5;
    scene.add(lensA.mesh);

    // Secondary dimmer ring slightly above
    const lensB = makeLensArc(0.80, 0.008, 0.6);
    lensB.mesh.rotation.x = Math.PI * 0.5;
    scene.add(lensB.mesh);

    /* ═══════════════════════════════════════════════════════
       4. ACCRETION DISK — large flat tilted glowing ring
          Dark overall, one blazing near-side arc
    ═══════════════════════════════════════════════════════ */
    const diskGeo = new THREE.TorusGeometry(1.6, 0.52, 128, 512);
    const diskMat = new THREE.ShaderMaterial({
        uniforms: { uTime: { value: 0 } },
        vertexShader: `
            varying vec2 vUv;
            uniform float uTime;
            void main() {
                vUv = uv;
                vec3 p = position;
                // Slight wobble for realism
                float a = atan(p.y, p.x);
                p.z += sin(a * 4.0 + uTime * 0.25) * 0.018;
                gl_Position = projectionMatrix * modelViewMatrix * vec4(p, 1.0);
            }
        `,
        fragmentShader: `
            varying vec2 vUv;
            uniform float uTime;

            // Pseudo-random
            float hash(vec2 p){ return fract(sin(dot(p,vec2(127.1,311.7)))*43758.5453); }

            void main() {
                // Tube cross-section falloff
                float edge = abs(vUv.y - 0.5) * 2.0;
                float core  = pow(1.0 - edge, 4.0);       // tight bright centre
                float shell = pow(1.0 - edge, 1.5) * 0.15; // faint outer glow

                // Flowing filaments along the ring
                float flow    = fract(vUv.x * 8.0 - uTime * 0.08);
                float streak  = smoothstep(0.0, 0.18, flow) * smoothstep(0.55, 0.18, flow);

                // Fine noise for texture
                float n = hash(vec2(floor(vUv.x * 180.0), floor(uTime * 0.04)));
                float noise = mix(0.25, 1.0, n);

                // ── Near-side arc (viewer side, top of tilted disk) ──
                // Roughly vUv.x 0.42–0.58 is the near-top arc
                float nearArc = smoothstep(0.38, 0.50, vUv.x) * smoothstep(0.62, 0.50, vUv.x);
                // Opposite arc is dimmer (far side lensing)
                float farArc  = (smoothstep(0.88, 0.95, vUv.x) + smoothstep(0.12, 0.05, vUv.x));
                farArc = clamp(farArc, 0.0, 1.0) * 0.22;

                float arcLight = nearArc * 1.0 + farArc;

                // Combine
                float b = (core * arcLight + shell) * (streak * 0.5 + 0.5) * noise;
                b = clamp(b, 0.0, 1.0);

                // Slight warm-grey tint on the bright arc
                vec3 col = mix(vec3(0.0), vec3(0.92, 0.88, 0.80), b);
                float alpha = smoothstep(0.0, 0.03, edge < 1.0 ? b : 0.0);
                alpha = b * 0.95;

                gl_FragColor = vec4(col, alpha);
            }
        `,
        transparent: true,
        depthWrite: false,
        side: THREE.DoubleSide,
        blending: THREE.AdditiveBlending,
    });

    const disk = new THREE.Mesh(diskGeo, diskMat);
    // Tilt like the reference — viewer looks slightly from above/side
    disk.rotation.x = Math.PI * 0.44;
    disk.rotation.z = Math.PI * 0.04;
    scene.add(disk);

    // Thin outer ring — very faint haze
    const outerGeo = new THREE.TorusGeometry(2.1, 0.12, 48, 300);
    const outerMat = new THREE.ShaderMaterial({
        uniforms: { uTime: { value: 0 } },
        vertexShader: `varying vec2 vUv; void main(){ vUv=uv; gl_Position=projectionMatrix*modelViewMatrix*vec4(position,1.0); }`,
        fragmentShader: `
            varying vec2 vUv;
            uniform float uTime;
            void main(){
                float edge = abs(vUv.y-0.5)*2.0;
                float core = pow(1.0-edge, 5.0);
                float near = smoothstep(0.40,0.50,vUv.x)*smoothstep(0.60,0.50,vUv.x);
                float b = core * near * 0.3;
                gl_FragColor = vec4(vec3(b),b*0.6);
            }
        `,
        transparent: true, depthWrite: false,
        side: THREE.DoubleSide, blending: THREE.AdditiveBlending,
    });
    const outerRing = new THREE.Mesh(outerGeo, outerMat);
    outerRing.rotation.x = disk.rotation.x;
    outerRing.rotation.z = disk.rotation.z;
    scene.add(outerRing);

    /* ═══════════════════════════════════════════════════════
       5. SHADOW CONE — dark shape cast "above" the disk
          Fakes the shadow the black hole casts on its own disk
    ═══════════════════════════════════════════════════════ */
    const shadowGeo = new THREE.ConeGeometry(0.72, 2.0, 128, 1, true);
    const shadowMat = new THREE.MeshBasicMaterial({
        color: 0x000000,
        transparent: true,
        opacity: 0.85,
        side: THREE.DoubleSide,
        depthWrite: false,
    });
    const shadowCone = new THREE.Mesh(shadowGeo, shadowMat);
    shadowCone.rotation.x = disk.rotation.x - Math.PI * 0.5;
    shadowCone.position.y = 0.0;
    scene.add(shadowCone);

    /* ═══════════════════════════════════════════════════════
       6. SPARSE STAR FIELD — distant, very faint
    ═══════════════════════════════════════════════════════ */
    const starCount = 1600;
    const starPos   = new Float32Array(starCount * 3);
    for (let i = 0; i < starCount; i++) {
        const theta = Math.random() * Math.PI * 2;
        const phi   = Math.acos(2 * Math.random() - 1);
        const r     = 8 + Math.random() * 20;
        starPos[i*3]   = r * Math.sin(phi) * Math.cos(theta);
        starPos[i*3+1] = r * Math.sin(phi) * Math.sin(theta);
        starPos[i*3+2] = r * Math.cos(phi);
    }
    const starGeo = new THREE.BufferGeometry();
    starGeo.setAttribute('position', new THREE.BufferAttribute(starPos, 3));
    const starMat = new THREE.PointsMaterial({
        color: 0xffffff, size: 0.03,
        transparent: true, opacity: 0.5,
        sizeAttenuation: true,
        blending: THREE.AdditiveBlending,
    });
    scene.add(new THREE.Points(starGeo, starMat));

    /* ═══════════════════════════════════════════════════════
       7. MOUSE PARALLAX
    ═══════════════════════════════════════════════════════ */
    let mx = 0, my = 0;
    document.addEventListener('mousemove', e => {
        mx = (e.clientX / window.innerWidth  - 0.5) * 2;
        my = (e.clientY / window.innerHeight - 0.5) * 2;
    });

    /* ═══════════════════════════════════════════════════════
       8. RENDER LOOP
    ═══════════════════════════════════════════════════════ */
    let t = 0;
    function animate() {
        requestAnimationFrame(animate);
        t += 0.005;

        // Update time uniforms
        photonMat.uniforms.uTime.value    = t;
        lensA.mat.uniforms.uTime.value    = t;
        lensB.mat.uniforms.uTime.value    = t;
        diskMat.uniforms.uTime.value      = t;
        outerMat.uniforms.uTime.value     = t;

        // Slow disk rotation
        disk.rotation.z      += 0.0006;
        outerRing.rotation.z += 0.0003;
        shadowCone.rotation.z = disk.rotation.z;

        // Gentle camera parallax
        camera.position.x += (mx * 0.3  - camera.position.x) * 0.025;
        camera.position.y += (1.8 - my * 0.2 - camera.position.y) * 0.025;
        camera.lookAt(0, 0, 0);

        renderer.render(scene, camera);
    }
    animate();
})();
} catch(e) { console.error('Three.js scene error:', e); }
});
</script>

<!-- ══ SCRIPTS ════════════════════════════════════════════════════════ -->
<script>
    // ── Navbar scroll effect ──────────────────────────────────────────
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 40);
    });

    // ── Active nav link on scroll ─────────────────────────────────────
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-links a');

    function setActiveLink() {
        const scrollY = window.scrollY + 120;
        sections.forEach(section => {
            if (scrollY >= section.offsetTop && scrollY < section.offsetTop + section.offsetHeight) {
                navLinks.forEach(a => a.classList.remove('active'));
                const match = document.querySelector(`.nav-links a[href="#${section.id}"]`);
                if (match) match.classList.add('active');
            }
        });
    }
    window.addEventListener('scroll', setActiveLink);

    // ── Mobile menu ───────────────────────────────────────────────────
    document.getElementById('navToggle').addEventListener('click', () => {
        document.getElementById('navMobile').classList.add('open');
    });
    document.getElementById('navClose').addEventListener('click', closeMobile);
    function closeMobile() {
        document.getElementById('navMobile').classList.remove('open');
    }

    // ── Fade-in on scroll ─────────────────────────────────────────────
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Animate skill bars when they appear
                entry.target.querySelectorAll('.skill-bar-fill').forEach(bar => {
                    bar.style.width = bar.dataset.width + '%';
                });
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // ── Skills filter ─────────────────────────────────────────────────
    document.querySelectorAll('.skills-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.skills-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const filter = tab.dataset.filter;
            document.querySelectorAll('.skill-item').forEach(item => {
                const show = filter === 'all' || item.dataset.cat === filter;
                item.style.display = show ? 'flex' : 'none';
            });
        });
    });

    // ── Contact form ──────────────────────────────────────────────────
    function handleSubmit(e) {
        e.preventDefault();
        const btn = e.target.querySelector('button[type="submit"]');
        btn.innerHTML = '<i class="fa-solid fa-check"></i> Sent!';
        btn.style.background = '#2a9d5c';
        setTimeout(() => {
            btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send Message';
            btn.style.background = '';
            e.target.reset();
        }, 3000);
    }
</script>

</body>
</html>
