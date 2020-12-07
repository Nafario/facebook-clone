const state = {
  user: { data: [] },
  userStatus: null,
  posts: null,
  postsStatus: null,
}

const getters = {
  user: (state) => {
    return state.user
  },
  posts: (state) => {
    return state.posts
  },
  status: (state) => {
    return {
      user: state.userStatus,
      posts: state.postsStatus,
    }
  },
  friendship: (state) => {
    return state.user.data.attributes.friendship
  },
  friendButtonText: (state, getters, rootState) => {
    if (rootState.User.user.data.user_id === state.user.data.user_id) {
      return ''
    } else if (getters.friendship === null) {
      return 'Add Friend'
    } else if (
      getters.friendship.data.attributes.confirmed_at === null &&
      getters.friendship.data.attributes.friend_id !==
        rootState.User.user.data.user_id
    ) {
      return 'Pending Friend Request'
    } else if (getters.friendship.data.attributes.confirmed_at !== null) {
      return ''
    }

    return 'Accept'
  },
}

const actions = {
  fetchUser({ commit }, userId) {
    commit('setUserStatus', 'loading')

    axios
      .get('/api/users/' + userId)
      .then((res) => {
        commit('setUser', res.data)
        commit('setUserStatus', 'success')
      })
      .catch((error) => {
        commit('setUserStatus', 'error')
        console.log(error)
      })
  },
  fetchUserPosts({ commit }, userId) {
    commit('setPostsStatus', 'loading')

    axios
      .get('/api/users/' + userId + '/posts')
      .then((res) => {
        commit('setPosts', res.data)
        commit('setPostsStatus', 'success')
      })
      .catch((error) => {
        commit('setPostsStatus', 'error')
        console.log(error)
      })
  },
  sendFriendRequest({ commit, getters }, friendId) {
    if (getters.friendButtonText !== 'Add Friend') {
      return
    }

    axios
      .post('/api/friend-request', { friend_id: friendId })
      .then((res) => {
        commit('setUserFriendship', res.data)
      })
      .catch((error) => {
        console.log(error)
      })
  },
  acceptFriendRequest({ commit }, userId) {
    axios
      .post('/api/friend-request-response', { user_id: userId, status: 1 })
      .then((res) => {
        commit('setUserFriendship', res.data)
      })
      .catch((error) => {
        console.log(error)
      })
  },
  ignoreFriendRequest({ commit }, userId) {
    axios
      .delete('/api/friend-request-response/delete', {
        data: { user_id: userId },
      })
      .then((res) => {
        commit('setUserFriendship', null)
      })
      .catch((error) => {
        console.log(error)
      })
  },
}

const mutations = {
  setUser(state, user) {
    state.user = user
  },
  setUserFriendship(state, friendship) {
    state.user.data.attributes.friendship = friendship
  },
  setUserStatus(state, status) {
    state.userStatus = status
  },
  setPosts(state, posts) {
    state.posts = posts
  },
  setPostsStatus(state, status) {
    state.postsStatus = status
  },
}

export default {
  state,
  getters,
  actions,
  mutations,
}
