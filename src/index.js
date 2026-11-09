import VideoFocusFilePreview from "./VideoFocusFilePreview.vue"
import VideoItemImage from "./VideoItemImage.vue"

panel.plugin("medienbaecker/video-focus", {
  components: {
    "k-item-image": VideoItemImage,
    "k-video-focus-file-preview": VideoFocusFilePreview,
  },
})
