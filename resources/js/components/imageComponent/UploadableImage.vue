<template>
  <img
    :src="userImage.data.attributes.path"
    :class="classes"
    :alt="altText"
    ref="userImage"
  />
</template>

<script>
import Dropzone from 'dropzone';
import { mapGetters } from 'vuex';

export default {
  props: [
    'userImage',
    'imageWidth',
    'imageHeight',
    'location',
    'classes',
    'altText'
  ],
  data() {
    return {
      dropzon: null,
    }
  },
  mounted () {
    if (this.authUser.data.user_id.toString() === this.$route.params.id) {
        this.dropzone = new Dropzone(this.$refs.userImage, this.settings);
    }
  },
  computed: {
    ...mapGetters({
          authUser: 'authUser',
      }),
    settings() {
      return {
        paramName: 'image',
        url: '/api/user-images',
        acceptedFiles: 'image/*',
        params: {
            'width': this.imageWidth,
            'height': this.imageHeight,
            'location': this.location,
        },
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
        },
        success: (e,res) => {
          this.$store.dispatch('fetchAuthUser');
          this.$store.dispatch('fetchUser', this.$route.params.id);
          this.$store.dispatch('fetchUserPosts', this.$route.params.id);
        }
      }
    } 

  },
}
</script>

<style>
</style>