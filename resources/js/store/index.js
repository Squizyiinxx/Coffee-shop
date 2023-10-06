import { createStore } from "vuex"; 
import { getData, getMenu } from "../fetchData";

export default createStore({
    state: {
        listPesanan: null,
        menuList: null,
    },
    getters: {
        getListPesanan: (state) => state.listPesanan,
        getMenuList: (state) => state.menuList,
    },
    mutations: {
        SET_DATA(state, data) {
            state.listPesanan = data;
        },
        SET_MENU(state, menuData) {
            state.menuList = menuData;
        },
    },
    actions: {
        async fetchPesananList({ commit }) {
            commit("SET_DATA", await getData());
        },
        async fetchMenuList({ commit }) {
           commit("SET_MENU", await getMenu());
        },
    },
    
});