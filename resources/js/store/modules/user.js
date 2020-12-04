import Axios from 'axios'

const state = {
    user: {data:[]},
    userStatus: null
}

const mutations = {
    setAuthUser(state, user){
        state.user = user
    }
}

const actions = {
    fetchAuthUser({commit, state}) {
        Axios.get('/api/auth-user')
        .then((res) => {
          commit('setAuthUser', res.data)
        })
        .catch((err) => {
          console.log(err);
        })
        .finally(() => {

        })
    }
}

const getters = {
    authUser: (state) => {
       return state.user
    }
}

export default {
    state, mutations,actions,getters
}