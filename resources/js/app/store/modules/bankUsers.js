import axios from 'axios'

// state
export const state = {
  payment: {},
  loading: true
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_PAYMENT(state, payment){
    state.payment = payment
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/setting-bank', payload)
        commit('FETCH_PAYMENT', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/payment-methods', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/payment-methods/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
  async upload({ commit }, payload) {
    try {
      return await axios.post('/api/payment-methods/upload', payload)
    } catch (e) {
      console.log(e)
    }
  },
}
