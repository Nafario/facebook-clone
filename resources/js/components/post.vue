<template>
  <div class="bg-white rounded shadow w-2/3 mt-4 overflow-hidden">
    <div class="flex flex-col p-4">
      <div class="flex items-center">
        <div>
          <img
            class="w-10 h-10 object-cover rounded-full"
            src="../../../public/imgs/profile.jpg"
            alt="profile"
          />
        </div>
        <div class="ml-4">
          <div class="text-sm font-bold">Name User</div>
          <div class="text-xs text-gray-500">12 mins</div>
        </div>
      </div>
      <div class="my-4">
        <p>Not having fun at all.</p>
      </div>
    </div>
    <!-- post image -->
    <div class="w-full">
      <img
        class="w-full"
        src="https://static.photocdn.pt/images/articles/2019/02/07/Simple_Landscape_Photography_Tips_With_Tons_of_Impact.jpg"
        alt="post images"
      />
    </div>
    <!-- like and comment count -->
    <div class="flex justify-between px-4 my-4">
      <like-comp class="flex items-center text-blue-500"
        >jane and 60 others</like-comp
      >
      <comment-comp class="flex items-center">124 comments</comment-comp>
    </div>
    <!-- like and comment -->
    <div class="flex justify-around m-4 text-gray-700">
      <button class="w-full h-full hover:bg-gray-200 py-2 rounded-sm">
        <like-comp class="flex justify-center items-center">Like</like-comp>
      </button>
      <button class="w-full h-full py-2 hover:bg-gray-200 rounded">
        <comment-comp class="flex justify-center items-center"
          >Comment
        </comment-comp>
      </button>
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
  }
}
</script>

<style>
</style>