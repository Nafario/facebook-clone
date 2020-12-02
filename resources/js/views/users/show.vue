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
        <div v-if="user.data">
          <p class="text-4xl font-bold text-center">
            {{ user.data.attributes.name }}
          </p>
        </div>
      </div>
    </div>
    <post
      v-for="post in posts.data"
      :key="post.data.post_id"
      :post="post"
    ></post>
  </div>
</template>

<script>
import Post from '../../components/post';
import Axios from 'axios'
export default {
    name:'show',
    components: {
        Post
    },
    data() {
        return {
            user: {},
            posts:[],
            userLoading: true
        }
    },
    mounted() {
        Axios.get('/api/users/' + this.$route.params.id)
            .then(res => {
                this.user = res.data
            })
            .catch(err => {
                console.log('unable to fetch user');
            })
            .finally(() => {
                this.userLoading = false
            })
            Axios.get('/api/users/' + this.$route.params.id + '/posts')
                .then((res) => {
                    this.posts = res.data
                })
                .catch((err) => {
                    console.log('unable to fetch posts')
                })
                .finally(() => {
                    this.loading = false
                })
    },
}
</script>

<style>
</style>