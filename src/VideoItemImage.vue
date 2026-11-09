<template>
	<k-frame
		v-if="video"
		v-bind="attrs"
		element="figure"
		:class="['k-item-image', 'k-video-item-image', $attrs.class]"
		:style="$attrs.style"
	>
		<video :src="video" muted playsinline preload="metadata" />
	</k-frame>
	<component
		:is="component"
		v-else
		v-bind="attrs"
		:class="['k-item-image', $attrs.class]"
		:style="$attrs.style"
	/>
</template>

<script>
/**
 * Shows the first frame of a video file where Kirby would show the video
 * icon. Items hand their image component only the image settings, so the
 * file's mime type and URL come from the item around it.
 */
export default {
	extends: "k-item-image",
	computed: {
		video() {
			const { mime, url } = this.$parent?.$attrs ?? {};

			if (this.image?.src || mime?.startsWith("video/") !== true) {
				return null;
			}

			return url + "#t=0.001";
		}
	}
};
</script>

<style>
.k-video-item-image video {
	width: 100%;
	height: 100%;
	object-fit: contain;
}

.k-video-item-image[data-cover="true"] video {
	object-fit: cover;
}
</style>
