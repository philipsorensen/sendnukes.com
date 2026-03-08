<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/deploy', function () {
    return view('deploy');
})->name('deploy');

Route::post('/launch', function (Request $request) {
    $request->validate([
        'lat'       => 'required|numeric|between:-90,90',
        'lng'       => 'required|numeric|between:-180,180',
        'nuke_type' => 'required|string|in:tactical-tickle,ex-terminator,corporate-restructuring,birthday-surprise,monday-obliterator,thermonuclear-hug',
        'message'   => 'nullable|string|max:200',
    ]);

    session([
        'launch' => [
            'lat'       => $request->lat,
            'lng'       => $request->lng,
            'nuke_type' => $request->nuke_type,
            'message'   => $request->message,
        ],
    ]);

    return redirect()->route('launch.animation');
})->name('launch');

Route::get('/launch', function () {
    $launchData = session('launch', []);
    return view('launch', compact('launchData'));
})->name('launch.animation');

Route::get('/confirmation', function () {
    $launchData = session('launch', []);

    $nukeNames = [
        'tactical-tickle'           => 'The Tactical Tickle',
        'ex-terminator'             => 'The Ex Terminator',
        'corporate-restructuring'   => 'The Corporate Restructuring',
        'birthday-surprise'         => 'The Birthday Surprise',
        'monday-obliterator'        => 'The Monday Obliterator',
        'thermonuclear-hug'         => 'The Thermonuclear Hug',
    ];

    $craterSizes = [
        'tactical-tickle'           => '0.8',
        'ex-terminator'             => '3.2',
        'corporate-restructuring'   => '7.1',
        'birthday-surprise'         => '14.0',
        'monday-obliterator'        => '28.5',
        'thermonuclear-hug'         => '110.0',
    ];

    $nukeType        = $launchData['nuke_type'] ?? 'tactical-tickle';
    $nukeDisplayName = $nukeNames[$nukeType]    ?? 'Unknown Payload';
    $craterSize      = $craterSizes[$nukeType]  ?? '2.1';

    // Base casualty estimates (±20% random variance for replayability)
    $baseCasualties = [
        'tactical-tickle'           => 2_400,
        'ex-terminator'             => 48_000,
        'corporate-restructuring'   => 140_000,
        'birthday-surprise'         => 420_000,
        'monday-obliterator'        => 980_000,
        'thermonuclear-hug'         => 4_800_000,
    ];
    $base       = $baseCasualties[$nukeType] ?? 10_000;
    $variance   = (int) ($base * (mt_rand(-20, 20) / 100));
    $casualties = number_format($base + $variance);

    $slogans = [
        '"Because flowers don\'t leave a crater."',
        '"Send warmth. Send radiation."',
        '"Hugs are temporary. Fallout is forever."',
        '"Nothing says \'I care\' like a small tactical nuke."',
        '"Give the gift that really makes an impact."',
    ];

    $slogan          = $slogans[array_rand($slogans)];

    return view('confirmation', compact('launchData', 'nukeDisplayName', 'craterSize', 'slogan', 'casualties'));
})->name('confirmation');