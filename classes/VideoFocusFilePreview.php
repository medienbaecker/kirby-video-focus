<?php

namespace Medienbaecker\VideoFocus;

use Kirby\Cms\File;
use Kirby\Panel\Ui\FilePreviews\VideoFilePreview;

class VideoFocusFilePreview extends VideoFilePreview
{
	public function __construct(
		public File $file,
		public string $component = 'k-video-focus-file-preview'
	) {}

	public static function accepts(File $file): bool
	{
		return $file->type() === 'video';
	}

	public function props(): array
	{
		return [
			...parent::props(),
			'focusable' => $this->focusable(),
		];
	}

	protected function focusable(): bool
	{
		if ($this->file->blueprint()->focus() === false) {
			return false;
		}

		if ($this->file->panel()->options()['update'] === false) {
			return false;
		}

		$kirby = $this->file->kirby();

		return $kirby->multilang() === false
			|| $kirby->languages()->count() === 0
			|| $kirby->language()->isDefault() === true;
	}
}
