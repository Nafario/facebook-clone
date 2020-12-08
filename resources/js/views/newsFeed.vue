<template>
  <div class="flex flex-col items-center py-4">
    <new-post></new-post>

    <div v-if="newsStatus.postsStatus === 'loding'">Loading posts........</div>
    <post
      v-else
      v-for="(post, postKey) in posts.data"
      :key="postKey"
      :post="post"
    ></post>
  </div>
</template>

<script>
import axios from 'axios'
import newPost from '../components/newPost'
import Post from '../components/post'
import { mapGetters } from 'vuex'
export default {

  components: {
    newPost,
    Post,
  },
  computed: {
    ...mapGetters({
      posts: 'posts',
      newsStatus: 'newsStatus'
    })
  },
  mounted() {
    this.$store.dispatch('fetchNewsPosts')
  },
}
</script>
<style></style>
