<?php $canonicalUrl = url(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="YURIAN // DIGITAL HQ — Arshad Yurian Mwangi. Building systems for what comes next.">
<meta name="theme-color" content="#0d0d0b">
<link rel="canonical" href="<?= e($canonicalUrl) ?>">
<meta property="og:type" content="website"><meta property="og:site_name" content="YURIAN // DIGITAL HQ"><meta property="og:title" content="<?= e($pageTitle ?? 'YURIAN // DIGITAL HQ') ?>"><meta property="og:description" content="Software engineer, AI builder, technology entrepreneur, and creator."><meta property="og:url" content="<?= e($canonicalUrl) ?>"><meta property="og:image" content="<?= e(url('/assets/images/yurian-signal.jpg')) ?>"><meta property="og:image:alt" content="A warm celestial signal in the Yurian Universe">
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="<?= e($pageTitle ?? 'YURIAN // DIGITAL HQ') ?>"><meta name="twitter:description" content="Building systems for what comes next."><meta name="twitter:image" content="<?= e(url('/assets/images/yurian-signal.jpg')) ?>">
<script type="application/ld+json"><?= json_encode(['@context'=>'https://schema.org','@type'=>'Person','name'=>'Arshad Yurian Mwangi','alternateName'=>'Yurian','url'=>url('/'),'jobTitle'=>'Software Engineer, AI Builder, Technology Entrepreneur','description'=>'Building systems for what comes next.','sameAs'=>['https://github.com/yurian51']], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?></script>
<title><?= e($pageTitle ?? 'YURIAN // DIGITAL HQ') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Instrument+Serif:ital@0;1&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="/assets/css/app.css"><link rel="stylesheet" href="/assets/css/forms.css">
</head><body><div class="site-shell"><header class="navbar" id="site-nav"><a class="brand" href="/" aria-label="YURIAN Digital HQ home"><span class="brand-mark">Y</span><span>YURIAN <b>//</b> DIGITAL HQ</span></a><nav aria-label="Primary"><a href="/#identity">01 Identity</a><a href="/#build">02 Build</a><a href="/projects">03 Work</a><a href="/books">10 Books</a><a href="/blog">05 Notes</a><a href="/contact">06 Contact</a></nav><a class="nav-menu" href="/cart" aria-label="Open book cart">Cart</a></header>
