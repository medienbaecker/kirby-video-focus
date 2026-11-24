<template>
	<div class="k-video-file-preview k-video-focus-file-preview">
		<k-file-preview-frame :options="options">
			<div class="k-video-focus-stage">
				<video ref="video" :src="url" controls preload="metadata" />
				<button v-if="hasFocus" :disabled="!isFocusable" class="k-video-focus-thumb"
					:style="{ left: focus.x + '%', top: focus.y + '%' }" :title="$t('file.focus.title')"
					@pointerdown="startDrag" @pointermove="drag" @pointerup="endDrag" @pointercancel="endDrag"
					@keydown="onKeys" />
			</div>
		</k-file-preview-frame>

		<k-file-preview-details :details="details">
			<div class="k-image-file-preview-focus">
				<dt>{{ $t("file.focus.title") }}</dt>
				<dd>
					<k-button v-if="isFocusable" :icon="hasFocus ? 'cancel-small' : 'preview'"
						:title="hasFocus ? $t('file.focus.reset') : undefined" size="xs" variant="filled"
						@click="hasFocus ? setFocus(undefined) : setFocus({ x: 50, y: 50 })">
						<template v-if="hasFocus">{{ focus.x }}% {{ focus.y }}%</template>
						<template v-else>{{ $t("file.focus.placeholder") }}</template>
					</k-button>
					<template v-else-if="hasFocus">{{ focus.x }}% {{ focus.y }}%</template>
					<template v-else>–</template>
				</dd>
			</div>
		</k-file-preview-details>
	</div>
</template>

<script>
export default {
	props: {
		content: { default: () => ({}), type: Object },
		details: Array,
		focusable: Boolean,
		isLocked: Boolean,
		url: String
	},
	emits: ["input"],
	data() {
		return {
			dragging: false
		};
	},
	computed: {
		focus() {
			const focus = this.content.focus;
			if (!focus) return;
			const [x, y] = focus.replaceAll("%", "").split(" ");
			return { x: parseFloat(x), y: parseFloat(y) };
		},
		hasFocus() {
			return Boolean(this.focus);
		},
		isFocusable() {
			return this.focusable === true && this.isLocked !== true;
		},
		options() {
			return [
				{
					icon: "download",
					text: this.$t("download"),
					link: this.url,
					download: true
				}
			];
		}
	},
	methods: {
		startDrag(event) {
			event.target.setPointerCapture(event.pointerId);
			this.dragging = true;
		},
		drag(event) {
			if (this.dragging === false) return;
			const rect = this.$refs.video.getBoundingClientRect();
			this.setFocus({
				x: ((event.clientX - rect.left) / rect.width) * 100,
				y: ((event.clientY - rect.top) / rect.height) * 100
			});
		},
		endDrag() {
			this.dragging = false;
		},
		onKeys(event) {
			const focus = this.focus;
			if (!focus) return;
			const step = event.shiftKey ? 10 : 1;
			if (event.key === "ArrowUp") this.setFocus({ x: focus.x, y: focus.y - step });
			else if (event.key === "ArrowDown") this.setFocus({ x: focus.x, y: focus.y + step });
			else if (event.key === "ArrowLeft") this.setFocus({ x: focus.x - step, y: focus.y });
			else if (event.key === "ArrowRight") this.setFocus({ x: focus.x + step, y: focus.y });
			else return;
			event.preventDefault();
		},
		setFocus(focus) {
			if (this.isFocusable === false) return;
			if (!focus) {
				this.$emit("input", { focus: null });
				return;
			}
			const x = Math.min(Math.max(focus.x, 0), 100);
			const y = Math.min(Math.max(focus.y, 0), 100);
			this.$emit("input", { focus: `${x.toFixed(1)}% ${y.toFixed(1)}%` });
		}
	}
};
</script>

<style>
.k-video-focus-stage {
	position: relative;
	display: inline-flex;
}

.k-video-focus-stage video {
	display: block;
}

.k-video-focus-thumb {
	position: absolute;
	width: 1.25rem;
	height: 1.25rem;
	transform: translate(-50%, -50%);
	border-radius: 50%;
	background: hsl(216 60% 60% / 0.75);
	cursor: grab;
	touch-action: none;
}

.k-video-focus-thumb:disabled {
	pointer-events: none;
}

.k-video-focus-thumb:active {
	cursor: grabbing;
}

.k-video-focus-thumb::after {
	--size: 0.4rem;
	--pos: calc(50% - (var(--size) / 2));
	position: absolute;
	top: var(--pos);
	inset-inline-start: var(--pos);
	width: var(--size);
	height: var(--size);
	content: "";
	background: white;
	border-radius: 50%;
}
</style>
