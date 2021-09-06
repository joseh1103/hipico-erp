export default{
    updateAllClients(state, clients){
        state.clients = clients
        state.loading =false
    },

    updateAllServices(state, services){
        state.services = services
        state.loading =false
    },

    updateAllInventory(state, stocks){
        state.stocks = stocks
        state.loading =false
    },

    updateAllBranches(state, branches){
        state.branches = branches
        state.loading =false
    },
    
    updateAllProviders(state, providers){
        state.providers = providers
        state.loading =false
    },
    updateAllLines(state, lines){
        state.lines = lines
        state.loading =false
    },

    updateAllBrands(state, brands){
        state.brands = brands
        state.loading =false
    },

    updateAllRoles(state, roles){
        state.roles = roles
        state.loading =false
    },
    
    updateAllPayments(state, payments){
        state.payments = payments
        state.loading =false
    },

    ordersPurchases(state, ordersPurchases){
        state.ordersPurchases = ordersPurchases
        state.loading =false
    },
    ordersAll(state, orders){
        state.orders = orders
        state.loading =false
    }


}