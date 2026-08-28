<?php

use Kirby\Cms\App as Kirby;
use Medienbaecker\VideoFocus\VideoFocusFilePreview;

load([
	'Medienbaecker\\VideoFocus\\VideoFocusFilePreview' => __DIR__ . '/classes/VideoFocusFilePreview.php',
]);

Kirby::plugin('medienbaecker/video-focus', [
	'filePreviews' => [
		VideoFocusFilePreview::class,
	],
]);
