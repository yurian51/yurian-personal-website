<?php $canonicalUrl = url(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="YURIAN // DIGITAL HQ — Arshad Yurian Mwangi. Software engineer, AI builder, technology entrepreneur, and creator building digital systems and products.">
<meta name="theme-color" content="#f5f1e8">
<meta name="color-scheme" content="light dark">
<link rel="manifest" href="/manifest.webmanifest">
<link rel="icon" href="/assets/icons/icon.svg" type="image/svg+xml">
<link rel="canonical" href="<?= e($canonicalUrl) ?>">
<meta property="og:type" content="website"><meta property="og:site_name" content="YURIAN // DIGITAL HQ"><meta property="og:title" content="<?= e($pageTitle ?? 'YURIAN // DIGITAL HQ') ?>"><meta property="og:description" content="Software engineer, AI builder, technology entrepreneur, and creator building digital systems and products."><meta property="og:url" content="<?= e($canonicalUrl) ?>"><meta property="og:image" content="<?= e(url('/assets/images/yurian-signal.jpg')) ?>"><meta property="og:image:alt" content="Yurian Digital HQ signal artwork">
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="<?= e($pageTitle ?? 'YURIAN // DIGITAL HQ') ?>"><meta name="twitter:description" content="Building digital systems, products, and intelligent tools."><meta name="twitter:image" content="<?= e(url('/assets/images/yurian-signal.jpg')) ?>">
<script type="application/ld+json"><?= json_encode(['@context'=>'https://schema.org','@type'=>'Person','name'=>'Arshad Yurian Mwangi','alternateName'=>'Yurian','url'=>url('/'),'jobTitle'=>'Software Engineer, AI Builder, Technology Entrepreneur','description'=>'Building digital systems, products, and intelligent tools.','sameAs'=>['https://github.com/yurian51'],'knowsAbout'=>['Software Engineering','Artificial Intelligence','Web Development','Digital Products','Systems Architecture']], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?></script>
<title><?= e($pageTitle ?? 'YURIAN // DIGITAL HQ') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Instrument+Serif:ital@0;1&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="/assets/css/app.css"><link rel="stylesheet" href="/assets/css/forms.css"><link rel="stylesheet" href="/assets/css/light-theme.css"><link rel="stylesheet" href="/assets/css/hybrid-hq.css"><link rel="stylesheet" href="/assets/css/realistic-editorial.css"><link rel="stylesheet" href="/assets/css/personal-platform.css">
</head><body><div class="site-shell"><header class="navbar" id="site-nav"><a class="brand" href="/" aria-label="YURIAN Digital HQ home"><span class="brand-mark" aria-hidden="true">Y</span><span>YURIAN <b>//</b> DIGITAL HQ</span></a><nav aria-label="Primary"><a href="/#identity">01 Identity</a><a href="/#build">02 Build</a><a href="/projects">03 Work</a><a href="/engineering">04 Engineering</a><a href="/case-studies">05 Cases</a><a href="/cv">06 CV</a><a href="/hire">07 Work</a><a href="/blog">08 Notes</a><a href="/contact">09 Contact</a></nav><a class="nav-menu" href="/cart" aria-label="Open book cart">Cart</a></header>
<script src="/assets/js/hq.js" defer></script><script src="/assets/js/hybrid-hq.js" defer></script><script src="/assets/js/pwa.js" defer></script><script src="/assets/js/personal-platform.js" defer></script>
