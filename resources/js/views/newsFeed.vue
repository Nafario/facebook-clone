<template>
  <div class="flex flex-col items-center py-4">
    <new-post></new-post>
    <post
      v-for="post in posts.data"
      :key="post.data.post_id"
      :post="post"
    ></post>
  </div>
</template>

<script>
import axios from 'axios'
import newPost from '../components/newPost'
import Post from '../components/post'
export default {
  data() {
    return {
      posts: [],
      loading: true
    }
  },
  components: {
    newPost,
    Post,
  },
  mounted() {
    axios
      .get('/api/posts')
      .then((res) => {
        this.posts = res.data
      })
      .catch((err) => {
        console.log('unable to fetch posts')
      })
  },
}
</script>
<style></style>
