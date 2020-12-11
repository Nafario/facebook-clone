<template>
  <div class="w-2/3">
    <div
      class="bg-white rounded shadow-sm w-full px-3 py-2 flex items-center justify-between"
    >
      <div>
        <img
          class="w-10 h-10 object-cover rounded-full"
          :src="authUser.data.attributes.profile_image.data.attributes.path"
          alt="profile"
        />
      </div>
      <div class="flex-1 mx-4">
        <input
          v-model="postMessage"
          class="bg-gray-100 w-full focus:outline-none rounded-lg focus:shadow pl-3 text-base h-9 placeholder-gray-500"
          type="text"
          name="body"
          id="body"
          placeholder="What's on your mind"
        />
      </div>
      <transition name="fade">
        <button
          v-if="postMessage"
          @click="postHandler"
          class="py-1 font-semibold mr-4 px-2 rounded bg-blue-500 text-white focus:outline-none"
        >
          Post
        </button>
      </transition>
      <div>
        <button
          ref="postImage"
          class="p-3 bg-gray-200 rounded-full dz-clickable focus:outline-none hover:bg-gray-300"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="fill-current w-5 h-5 dz-clickable"
          >
            <path
              d="M21.8 4H2.2c-.2 0-.3.2-.3.3v15.3c0 .3.1.4.3.4h19.6c.2 0 .3-.1.3-.3V4.3c0-.1-.1-.3-.3-.3zm-1.6 13.4l-4.4-4.6c0-.1-.1-.1-.2 0l-3.1 2.7-3.9-4.8h-.1s-.1 0-.1.1L3.8 17V6h16.4v11.4zm-4.9-6.8c.9 0 1.6-.7 1.6-1.6 0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6.1.9.8 1.6 1.6 1.6z"
            />
          </svg>
        </button>
      </div>
    </div>
    <div class="bg-white">
      <div class="dropzone-previews">
        <div id="dz-template" class="hidden">
          <div class="dz-preview dz-file-preview mt-4 p-4">
            <div class="dz-details">
              <img data-dz-thumbnail class="w-32 h-32" />

              <button
                data-dz-remove
                class="text-xs px-3 py-1 border border-red-400 mt-2"
              >
                REMOVE
              </button>
            </div>
            <div class="dz-progress">
              <span class="dz-upload" data-dz-upload></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from 'lodash'
import { mapGetters } from 'vuex';
import Dropzone from 'dropzone';
export default {
  data() {
    return {
      dropzone: null
    }
  },
  mounted () {
    this.dropzone = new Dropzone(this.$refs.postImage, this.settings);
  },
  computed: {
    ...mapGetters([
      'authUser'
    ]),
    postMessage: {
      get() {
          return this.$store.getters.postMessage;
      },
      set: _.debounce(function (postMessage) {
            this.$store.commit('updateMessage', postMessage);
        }, 500),
     },
     settings(){
       return {
          paramName: 'image',
          url: '/api/posts',
          acceptedFiles: 'image/*',
          autoProcessQueue: false,
          maxFiles: 1,
          previewsContainer: '.dropzone-previews',
          previewTemplate: document.querySelector('#dz-template').innerHTML,
          sending:(file, xhr, formData) => {
            formData.append('body', this.$store.getters.postMessage)
          },
          params: {
              'width': 700,
              'height': 1000,
          },
          clickable: '.dz-clickable',
          headers: {
              'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
          },
          success: (e,res) => {
            this.dropzone.removeAllFiles();
            this.$store.commit('pushPost', res);
        },
        maxfilesexceeded: file => {
          this.dropzone.removeAllFiles();
          this.dropzone.addFile(file);
          }
       }
     } 
  },
  methods: {
    postHandler() {
      if (this.dropzone.getAcceptedFiles().length) {
        this.dropzone.processQueue()
      }
      else{
        this.$store.dispatch('postMessage')
      }
      this.$store.commit('updateMessage', '');

    }
  },
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  transition: linear;
  opacity: 0;
}
</style>