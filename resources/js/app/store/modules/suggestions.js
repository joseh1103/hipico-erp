import axios from 'axios'

// state
export const state = {
  suggestions: {},
  loading: true
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_SUGGESTIONS(state, suggestions){
    state.suggestions = suggestions
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/suggestions', payload)
        commit('FETCH_SUGGESTIONS', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/suggestions', payload)
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
  }
}
