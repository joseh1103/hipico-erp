import axios from 'axios'

// state
export const state = {
  jornadas: {},
  loading: false,
  jornada: {}
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_JORNADAS(state, jornadas){
    state.jornadas = jornadas
    state.loading = false
  },
  FETCH_JORNADA(state, jornada){
    state.jornada = jornada
    state.loading = false
  },
}

// actions
export const actions = {
  async storeNotifications({ commit }, payload) {
    try {
      return await axios.post('/api/jornadas-notifications', payload)
    } catch (e) {
      console.log(e)
    }
  },

  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/jornadas', payload)
        commit('FETCH_JORNADAS', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/jornadas', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async upload({ commit }, payload) {
    try {
      return await axios.post('/api/jornadas/upload', payload)
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
      const { data } = await axios.get(`/api/jornadas/${payload.params.id}`)
      commit('FETCH_JORNADA', data)
      return data
    } catch (e) {
      console.log(e);
    }
  },
}