import axios from 'axios'

// state
export const state = {
  polla: {},
  loading: true
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_POLLAS(state, polla){
    state.polla = polla
    state.loading = false
  },
  LOADING(state, subasta) {
    state.loading = true
  },
}

// actions
export const actions = {

  async storePremio({ commit }, payload) {
    try {
      return await axios.post('/api/pollas-premio', payload)
    } catch (e) {
      console.log(e)
    }
  },

  async fetch({ commit }, payload) {
    try {
        commit('LOADING')
        const { data } = await axios.get('/api/pollas', payload)
        commit('FETCH_POLLAS', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/pollas', payload)
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