import axios from 'axios'

// state
export const state = {
  posos: {},
  loading: true
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_POSOS(state, posos){
    state.posos = posos
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/poso', payload)
        commit('FETCH_POSOS', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/poso', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/poso/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
  async search({ commit }, id) {
    try {
      const { data } = await axios.get(`/api/poso-datos-retiro/${id}`)
      return data
    } catch (e) {
      console.log(e);
    }
  },
  async upload({ commit }, payload) {
    try {
      return await axios.post('/api/poso/upload', payload)
    } catch (e) {
      console.log(e)
    }
  },
}
