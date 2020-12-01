<template>
  <div class="flex flex-col items-center py-4">
    <new-post></new-post>
    <post></post>
  </div>
</template>

<script>
import newPost from '../components/newPost';
import Post from '../components/Post';
export default {

    components: {
        newPost,
        Post

    }
}
</script>
<style>
</style>