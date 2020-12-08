<template>
  <div
    class="bg-white rounded shadow-sm w-2/3 px-3 py-2 flex items-center justify-between"
  >
    <div>
      <img
        class="w-10 h-10 object-cover rounded-full"
        src="../../../public/imgs/profile.jpg"
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
        @click="$store.dispatch('postMessage')"
        class="py-1 font-semibold mr-4 px-2 rounded bg-blue-500 text-white focus:outline-none"
      >
        Post
      </button>
    </transition>
    <div>
      <button class="p-3 bg-gray-200 rounded-full">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          class="fill-current w-5 h-5"
        >
          <path
            d="M21.8 4H2.2c-.2 0-.3.2-.3.3v15.3c0 .3.1.4.3.4h19.6c.2 0 .3-.1.3-.3V4.3c0-.1-.1-.3-.3-.3zm-1.6 13.4l-4.4-4.6c0-.1-.1-.1-.2 0l-3.1 2.7-3.9-4.8h-.1s-.1 0-.1.1L3.8 17V6h16.4v11.4zm-4.9-6.8c.9 0 1.6-.7 1.6-1.6 0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6.1.9.8 1.6 1.6 1.6z"
          />
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
import _ from 'lodash'
export default {
  computed: {
    postMessage: {
      get() {
          return this.$store.getters.postMessage;
      },
      set: _.debounce(function (postMessage) {
            this.$store.commit('updateMessage', postMessage);
        }, 500),
     },
  }
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