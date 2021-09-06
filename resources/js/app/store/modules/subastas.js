import axios from 'axios'

// state
export const state = {
  subasta: {},
  loading: true
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_SUBASTAS(state, subasta){
    state.subasta = subasta
    state.loading = false
  },
  FETCH_SUBASTA(state, subasta){
    state.subasta = subasta
    state.loading = false
  },
  LOADING(state, subasta) {
    state.loading = true
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        commit('LOADING')
        const { data } = await axios.get('/api/subasta', payload)
        commit('FETCH_SUBASTAS', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/subasta', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/jornadas/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
  async search({ commit }, payload) {
    try {
      console.log('i', payload.params.id)
      const { data } = await axios.get(`/api/subasta/${payload.params.id}`, payload)
      commit('FETCH_SUBASTA', data)
      return data
    } catch (e) {
      console.log(e);
    }
  },
}