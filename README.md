# Kirby Video Focus

Adds a focus point picker to video files in the [Kirby](https://getkirby.com/) Panel, writing the same `focus` field that images already use.

![A video in the Kirby Panel file view with the focus thumb placed over the player and the resulting value in the details column](.github/file-view.png)

## Setting the focus point

Drag the point over the video, or focus it and use the arrow keys: one step moves it by 1%, with Shift by 10%. In the details, "Set focal point" places it in the centre, and clicking the value resets it.

To turn the picker off for a file template, set `focus: false` in its blueprint, as you would for images:

```yaml
title: Background video
focus: false
```

## Using the focus point

The value lands in the `focus` field, so `$file->focus()` returns it just like for an image:

```php
<video
	src="<?= $file->url() ?>"
	style="object-fit: cover; object-position: <?= $file->focus() ?>"
	autoplay muted loop playsinline
></video>
```

## Video thumbnails

Files sections, files fields and the file picker show the first frame of a video where Kirby would show the video icon, in cards and lists alike.

## Requirements

- Kirby 6+
- PHP 8.3+

## Installation

```bash
composer require medienbaecker/kirby-video-focus
```

> [!TIP]
> If you don't use Composer, you can download this repository and copy it to `site/plugins/kirby-video-focus`.

## License

MIT
