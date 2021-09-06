import axios from 'axios'

// state
export const state = {
  currency: {},
  loading: true
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_CURRENCY(state, currency){
    state.currency = currency
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/currency', payload)
        commit('FETCH_CURRENCY', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/currency', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/currency/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
}
