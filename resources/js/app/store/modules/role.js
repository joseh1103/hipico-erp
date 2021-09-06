import axios from 'axios'

// state
export const state = {
  roles: {},
  loading: true
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_ROLES(state, roles){
    state.roles = roles
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/roles', payload)
        commit('FETCH_ROLES', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/roles', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/roles/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
  async search({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/roles/${payload.params.search}`)
      return data
    } catch (e) {
      console.log(e);
    }
  },
}
