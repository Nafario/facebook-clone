<template>
  <div class="bg-white rounded shadow w-2/3 mt-6 overflow-hidden">
    <div class="flex flex-col p-4">
      <div class="flex items-center">
        <div>
          <img
            class="w-10 h-10 object-cover rounded-full"
            :src="
              post.data.attributes.posted_by.data.attributes.profile_image.data
                .attributes.path
            "
            alt="profile"
          />
        </div>
        <div class="ml-4">
          <div class="text-sm font-bold">
            {{ post.data.attributes.posted_by.data.attributes.name }}
          </div>
          <div class="text-xs text-gray-500">
            {{ post.data.attributes.posted_at }}
          </div>
        </div>
      </div>
      <div class="my-4">
        <p>{{ post.data.attributes.body }}</p>
      </div>
    </div>
    <!-- post image -->
    <div v-if="post.data.attributes.image.length" class="w-full">
      <img class="w-full" :src="post.data.attributes.image" alt="post images" />
    </div>
    <!-- like and comment count -->
    <div
      class="flex justify-between px-4 my-4"
      :class="[
        post.data.attributes.likes.user_likes_post
          ? 'text-blue-500'
          : 'text-black',
      ]"
    >
      <like-comp class="flex items-center"
        >{{ post.data.attributes.likes.like_count }} likes</like-comp
      >
      <comment-comp class="flex items-center text-gray-700"
        >{{
          post.data.attributes.comments.comment_count
        }}
        comments</comment-comp
      >
    </div>
    <!-- like and comment -->
    <div class="flex justify-around m-4 text-gray-700">
      <button
        class="w-full h-full hover:bg-gray-200 py-2 rounded-sm focus:outline-none"
        :class="[
          post.data.attributes.likes.user_likes_post
            ? 'text-blue-500'
            : 'text-black',
        ]"
        @click="
          $store.dispatch('likePost', {
            postId: post.data.post_id,
            postKey: $vnode.key,
          })
        "
      >
        <like-comp class="flex justify-center items-center">Like</like-comp>
      </button>
      <button
        class="w-full h-full py-2 hover:bg-gray-200 rounded focus:outline-none"
        @click="comments = !comments"
      >
        <comment-comp class="flex justify-center items-center"
          >Comment
        </comment-comp>
      </button>
    </div>
    <div v-if="comments" class="pt-4">
      <hr />
      <div
        class="flex my-4 items-center px-4"
        v-for="(comment, i) in post.data.attributes.comments.data"
        :key="i"
      >
        <div class="">
          <img
            :src="
              comment.data.attributes.commented_by.data.attributes.profile_image
                .data.attributes.path
            "
            alt="profile image for user"
            class="object-cover rounded-full w-10 -mt-4"
          />
        </div>
        <div class="ml-2 flex-1">
          <div class="bg-gray-100 rounded-lg p-2 text-sm">
            <a
              class="font-bold text-blue-500"
              :href="
                '/users/' + comment.data.attributes.commented_by.data.user_id
              "
            >
              {{ comment.data.attributes.commented_by.data.attributes.name }}
            </a>
            <p class="inline">
              {{ comment.data.attributes.body }}
            </p>
          </div>
          <div class="text-xs pl-1 text-gray-500">
            <p>{{ comment.data.attributes.commented_at }}</p>
          </div>
        </div>
      </div>
      <div class="flex items-center px-3 py-2 border-t">
        <input
          v-model="commentBody"
          class="bg-gray-100 w-full focus:outline-none rounded-md pl-3 text-base h-9 placeholder-gray-500"
          type="text"
          name="body"
          id="body"
          placeholder="Write a comment !"
        />
        <button
          class="py-1 font-semibold ml-4 px-2 rounded bg-gray-100 text-gray-500 focus:outline-none"
          @click="
            $store.dispatch('commentPost', {
              body: commentBody,
              postId: post.data.post_id,
              postKey: $vnode.key,
            });
            commentBody = '';
          "
        >
          Post
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import likeComp from './posts/like';
import commentComp from './posts/comment';
export default {
  components: {
    likeComp,
    commentComp
  },
  data() {
    return {
      comments: false,
      commentBody: ''
    }
  },
  props: ['post']
  

}
</script>

<style>
</style>