import axios from 'axios'

// state
export const state = {
  hipodromos: {},
  loading: false
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_HIPODROMOS(state, hipodromos){
    state.hipodromos = hipodromos
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/hipodromos', payload)
        commit('FETCH_HIPODROMOS', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      return await axios.post('/api/hipodromos', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async upload({ commit }, payload) {
    try {
      return await axios.post('/api/hipodromos/upload', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/hipodromos/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
  async search({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/hipodromos/${payload.params.search}`)
      return data
    } catch (e) {
      console.log(e);
    }
  },
}