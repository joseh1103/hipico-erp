import axios from 'axios'

// state
export const state = {
  dashboard: {},
  users: {},
  loading: true
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_DASHBOARD(state, dashboard){
    state.dashboard = dashboard
    state.loading = false
  },
  FETCH_USERS(state, users){
    state.users = users
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/dashboard', payload)
        commit('FETCH_DASHBOARD', data)
      } catch (e) {
        console.log(e)
    }
  },
  async fetchUsers({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/auth/callback', payload)
        commit('FETCH_USERS', data)
      } catch (e) {
        console.log(e)
    }
  }
}
