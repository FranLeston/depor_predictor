import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";


Vue.use(Vuex);

export default new Vuex.Store({
    plugins: [createPersistedState({
        storage: window.sessionStorage,
    })],

    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: {},
        currentFixtures: {},
    },
    mutations: {
        auth_request (state) {
            state.status = 'loading';
        },
        auth_success (state, payload) {
            console.log('this is the user: ', payload.user);
            state.status = 'success';
            state.token = payload.token;
            state.user = payload.user;
        },
        auth_error (state) {
            state.status = 'error';
        },
        logout (state) {
            state.status = '';
            state.token = '';
            state.user = {};
        },
        setCurrentFixtures (state, fixtures) {
            state.currentFixtures = fixtures;
        }
    },
    actions: {
        login ({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request');
                axios({ url: 'http://localhost:8000/api/v1/auth/login', data: user, method: 'POST' })
                    .then(resp => {
                        const token = resp.data.accessToken;
                        const user = resp.data.user;
                        const payload = {
                            token,
                            user
                        };
                        localStorage.setItem('token', token);
                        // Add the following line:
                        axios.defaults.headers.common['Authorization'] = "Bearer " + token;
                        commit('auth_success', payload);
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error');
                        localStorage.removeItem('token');
                        reject(err);
                    });
            });
        },
        register ({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request');
                axios({ url: 'http://localhost:8000/api/v1/auth/register', data: user, method: 'POST' })
                    .then(resp => {
                        // Add the following line:
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error', err);
                        localStorage.removeItem('token');
                        reject(err);
                    });
            });
        },
        logout ({ commit }) {
            return new Promise((resolve, reject) => {
                axios({ url: 'http://localhost:8000/api/v1/auth/logout', data: {}, method: 'POST' })
                    .then(resp => {
                        console.log(resp);
                        commit('logout');
                        localStorage.removeItem('token');
                        sessionStorage.clear();
                        delete axios.defaults.headers.common['Authorization'];
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error');
                        reject(err);
                    });
            });
        },
        getCurrentFixtures ({ commit }) {
            return new Promise((resolve, reject) => {
                axios({
                    url: 'http://localhost:8000/api/v1/fixtures?status=NotStarted', data: {}, method: 'GET'
                })
                    .then(resp => {
                        console.log(resp.data.fixtures);
                        const fixtures = resp.data.fixtures;
                        commit('setCurrentFixtures', resp.data.fixtures);
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error');
                        reject(err);
                    });
            });
        },
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
        currentFixtures: state => state.currentFixtures,
        currentUser: state => state.user
    }
});
