import axios from 'axios'

// state
export const state = {
  typeJugadas: {},
  loading: false
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_JUGADAS(state, jugadas) {
    state.typeJugadas = jugadas
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/jugadas-type', payload)
        commit('FETCH_JUGADAS', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/jugadas-type', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/jugadas-type/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
  async search({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/jugadas-type/${payload.params.search}`)
      return data
    } catch (e) {
      console.log(e);
    }
  },
}