<template>
  <div class="flex flex-col items-center w-full">
    <div>
      <div class="w-full h-64 overflow-hidden">
        <img
          src="https://static.photocdn.pt/images/articles/2018/02/28/articles/2017_8/iStock-841311310-min.jpg"
          alt="profile banner"
          class="w-full object-cover object-center"
        />
      </div>
      <div class="flex flex-col items-center -mt-40">
        <div class="w-48 overflow-hidden">
          <img
            class="object-cover rounded-full w-full border-4 border-gray-100 shadow-sm"
            src="../../../../public/imgs/profile.jpg"
            alt="profile"
          />
        </div>
        <div>
          <p class="text-4xl font-bold text-center">
            {{ user.data.attributes.name }}
          </p>
        </div>
      </div>
    </div>
    <div
      class="w-2/3 flex justify-between bg-white rounded shadow py-3 px-4 mt-2"
    >
      <div></div>
      <div class="">
        <!-- jjjjjjjjjjjjjjjjjjjjjjjjj -->
        <button
          v-if="friendButtonText && friendButtonText !== 'Accept'"
          @click="$store.dispatch('sendFriendRequest', $route.params.id)"
          class="py-2 text-lg font-medium px-4 bg-blue-500 text-white rounded flex items-center justify-center focus:outline-none"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            class="fill-current w-5 h-5 mr-2 -mt-1"
          >
            <path
              d="M2 6H0v2h2v2h2V8h2V6H4V4H2v2zm7 0a3 3 0 0 1 6 0v2a3 3 0 0 1-6 0V6zm11 9.14A15.93 15.93 0 0 0 12 13c-2.91 0-5.65.78-8 2.14V18h16v-2.86z"
            />
          </svg>
          {{ friendButtonText }}
        </button>
        <div class="flex items-center">
          <!-- acceptFriendRequest -->
          <button
            v-if="friendButtonText && friendButtonText === 'Accept'"
            @click="$store.dispatch('acceptFriendRequest', $route.params.id)"
            class="py-1 text-lg font-medium px-4 bg-blue-500 text-white rounded flex items-center justify-center focus:outline-none"
          >
            Accept
          </button>
          <!-- ignoreFriendRequest -->
          <button
            v-if="friendButtonText && friendButtonText === 'Accept'"
            @click="$store.dispatch('ignoreFriendRequest', $route.params.id)"
            class="py-1 text-lg font-medium px-4 text-black ml-2 bg-gray-300 rounded flex items-center justify-center focus:outline-none"
          >
            Ignore
          </button>
        </div>
      </div>
    </div>
    <div v-if="!posts">No posts yet!</div>
    <post
      v-else
      v-for="post in posts.data"
      :key="post.data.post_id"
      :post="post"
    ></post>
  </div>
</template>

<script>
import Post from '../../components/post';
import { mapGetters } from 'vuex';
import Axios from 'axios'
export default {
    name:'show',
    components: {
        Post
    },

    mounted() {
        this.$store.dispatch('fetchUser', this.$route.params.id)
        this.$store.dispatch('fetchUserPosts', this.$route.params.id)
  },
  computed: {
    ...mapGetters({
      user: 'user',
      posts: 'posts',
      friendButtonText: 'friendButtonText'
    })
  }
}
</script>

<style>
</style>