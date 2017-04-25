import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export let store = new Vuex.Store({
    state: {
        user: null
    },
    actions: {
        addUser ({commit}, user) {
            commit('ADD_USER', user)
        },
        removeUser ({commit}) {
            commit('REMOVE_USER')
        }
    },
    mutations: {
        ADD_USER (state, user) {
            state.user = user
        },
        REMOVE_USER (state) {
            state.user = null
        }
    },
    getters: {
        user (state) {
            return state.user
        }
    }
});