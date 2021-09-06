import axios from 'axios'

export default {


  async searchGeneral({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/busqueda`, payload)
      return data
    } catch (e) {
      console.log(e);
    }
  },

  async storeRoles({ commit }, payload) {
    try {
      return await axios.post('/api/roles', payload)
    } catch (e) {
      console.log(e)
    }
  },





  async deleteRole({ commit }, payload) {
    try {
      return await axios.delete(`/api/roles/${payload.id}`)
    } catch (e) {
      console.log(e)
    }
  },

  async fetchClientes({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/clients', payload)
      commit('updateAllClients', data)
      return data
    } catch (e) {
      console.log(e)
    }
  },



  async searchClient({ commit }, payload) {
    try {
      const { data } = await axios.get(`/api/clients/${payload.params.search}`)
      return data
    } catch (e) {
      console.log(e);
    }
  },


  async fetchRoles({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/roles', payload)
      commit('updateAllRoles', data)
      return data
    } catch (e) {
      console.log(e)
    }
  },

  async fetchPayments({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/paymentMethods', payload)
      commit('updateAllPayments', data)
      return data
    } catch (e) {
      console.log(e)
    }
  },

  /* orders purcharses */
  async generatePedido({ commit }, payload) {
    try {
      return await axios.post('/api/orders-purchases', payload)
    } catch (e) {
      console.log(e)
    }
  },
  async searchOrdersPurchases({ commit }, payload) {
    try {
      console.log(payload)
      const { data } = await axios.get(`/api/orders-purchases/${payload.params.id}`)
      commit('ordersPurchases', data)
      return data
    } catch (e) {
      console.log(e)
    }
  },
  async fetchOrdersPurchases({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/orders-purchases', payload)
      commit('ordersAll', data)
      return data
    } catch (e) {
      console.log(e)
    }
  },
  async fetchPdf({ commit }, payload) {
    try {
      //console.log(payload.params.id)
      const data = await axios({ 
        url: `/api/order-pdf/${payload.params.id}/false`,
         method: 'GET', responseType: 'blob', // important
        });
        return data
    } catch (e) {
      console.log(e)
    }
  },
  async printpdf({ commit }, payload) {
    try {
      //console.log(payload.params.id)
      const data = await axios({ 
        url: `/api/order-pdf/${payload.params.id}/1`,
         method: 'GET', responseType: 'blob', // important
        });
        return data
    } catch (e) {
      console.log(e)
    }
  },
  async updateOrdersPurchases({ commit }, payload) {
    try {
      const { data } = await axios.put(`/api/orders-purchases/${payload.params.id}`, payload)
      return data
    } catch (e) {
      console.log(e)
    }
  },

  async sendWhatsapp({ commit }, payload) {
    try {
      const { data } = await axios.post(`/api/orders-purchases/ws`, payload)
      return data
    } catch (e) {
      console.log(e)
    }
  },
  async sendMail({ commit }, payload) {
    try {
      const { data } = await axios.post(`/api/orders-purchases/mail`, payload)
      return data
    } catch (e) {
      console.log(e)
    }
  },
}