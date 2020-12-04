const state = {
    title: 'Welcome'
}

const mutations = {
    setTitle(state, title) {
        state.title = title + ' | Facebook'
        document.title = state.title
    }
}

const actions = {
    setPageTitle({commit}, title){
        commit('setTitle', title)
    }
}

const getters = {
    pageTitle: state => {
        return state.title
    }
}

export default {
    state, mutations,actions,getters
}