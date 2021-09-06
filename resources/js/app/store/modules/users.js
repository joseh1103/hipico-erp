import axios from 'axios'

// state
export const state = {
  users: {},
  user: {},
  loading: true,
  usersSaldo: {},
  balance: {},
  userPuntos: {}
}
// getters
export const getters = {
}
// mutations
export const mutations = {
  FETCH_USERS(state, users){
    state.users = users
    state.loading = false
  },
  NEW_USER(state, user){
    state.user = user
    state.loading = false
  },
  FETCH_USERS_SUBASTA(state, users){
    state.usersSaldo = users
    state.loading = false
  },
  BALANCE_USER(state, balance){
    state.balance = balance
    state.loading = false
  },
  FETCH_USERS_POLLA(state, users){
    state.userPuntos = users
    state.loading = false
  },
}

// actions
export const actions = {
  async fetch({ commit }, payload) {
    try {
        const { data } = await axios.get('/api/users', payload)
        commit('FETCH_USERS', data)
      } catch (e) {
        console.log(e)
    }
  },
  async store({ commit }, payload) {
    try {
      const { data } =  await axios.post('/api/users', payload)
      commit('NEW_USER', data)
    } catch (e) {
      console.log(e)
    }
  },
  async delete({ commit }, payload) {
    try {
      return await axios.delete(`/api/users/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },
  async search({ commit }, payload) {
    try {
      console.log('e', payload);
      const { data } = await axios.get(`/api/users-search`, payload)
      commit('FETCH_USERS', data)
      return data;
    } catch (e) {
      console.log(e);
    }
  },
  async saldos({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/users-saldos`, payload)
      commit('FETCH_USERS_SUBASTA', data)
      return data;
    } catch (e) {
      console.log(e);
    }
  },

  async puntosPolla({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/users-puntos`, payload)
      commit('FETCH_USERS_POLLA', data)
      return data;
    } catch (e) {
      console.log(e);
    }
  },


  async detail({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/user-detail/`, payload)
      commit('BALANCE_USER', data)
      return data;
    } catch (e) {
      console.log(e);
    }
  },
}
