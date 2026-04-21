<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>PsyCheck | Assessment Start</title>

	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		body { font-family: 'Instrument Sans', sans-serif; }
	</style>
</head>
<body class="min-h-screen bg-[#f8ebf1] bg-[radial-gradient(circle_at_50%_-20%,#b23673_0,#e39fb8_34%,#f8ebf1_82%)] text-slate-800 antialiased">
	@php
		$track = request('track', 'mind');
		$titleMap = [
			'body' => 'Body Assessment',
			'mind' => 'Mind Assessment',
			'analysis' => 'Analysis Assessment',
		];
		$trackTitle = $titleMap[$track] ?? 'Mind Assessment';
	@endphp

	<div class="mx-auto max-w-4xl px-4 py-8 sm:px-8">
		<a href="{{ route('dashboard') }}#assessment-menus" class="inline-flex items-center rounded-full bg-white/80 px-4 py-2 text-sm font-semibold text-fuchsia-700 ring-1 ring-fuchsia-100">Back to dashboard</a>

		<section class="mt-6 rounded-[32px] bg-white p-8 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
			<p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Assessment</p>
			<h1 class="mt-3 text-4xl font-black text-slate-900">{{ $trackTitle }}</h1>
			<p class="mt-4 text-base leading-7 text-slate-600">This track is ready. You can continue by connecting this page to your question flow next.</p>

			<div class="mt-8 rounded-2xl bg-fuchsia-50 px-5 py-4 text-sm font-semibold text-fuchsia-700 ring-1 ring-fuchsia-100">
				Selected track: {{ ucfirst($track) }}
			</div>
		</section>
	</div>
</body>
</html>
