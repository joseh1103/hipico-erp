import axios from 'axios'

// state
export const state = {
  ponles: {},
  loading: true
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_PONLES(state, ponles){
    state.ponles = ponles
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/tab-ponles', payload)
        commit('FETCH_PONLES', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/tab-ponles', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/tab-ponles/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
  async search({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/tab-ponles/${payload.params.search}`)
      return data
    } catch (e) {
      console.log(e);
    }
  },
}
