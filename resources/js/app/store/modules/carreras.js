import axios from 'axios'

// state
export const state = {
  carreras: {},
  loading: false
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_CARRERAS(state, carreras){
    state.carreras = carreras
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/carreras', payload)
        commit('FETCH_CARRERAS', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/carreras', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/carreras/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
  async search({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/carreras/${payload.params.search}`)
      return data
    } catch (e) {
      console.log(e);
    }
  },
}