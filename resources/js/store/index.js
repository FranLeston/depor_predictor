import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
import data from './constants';


Vue.use(Vuex);

export default new Vuex.Store({
    plugins: [createPersistedState({
        storage: window.localStorage,
    })],

    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: {},
        currentFixtures: {},
        currentRound: '',
        predictions: {},
        selectedPredictions: {},
        allRounds: {},
        rankings: {},
        userPoints: {},
        league_id: data.LEAGUE_ID

    },
    mutations: {
        auth_request (state) {
            state.status = 'loading';
        },
        auth_success (state, payload) {
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
        },
        setCurrentRound (state, round) {
            state.currentRound = round;
        },
        setCurrentUser (state, user) {
            state.user = user;
        },
        setAllRounds (state, rounds) {
            state.allRounds = rounds;
        },
        setPredictions (state, predictions) {
            state.predictions = predictions;
        },
        setSelectedPredictions (state, selectedPredictions) {
            state.predictions = selectedPredictions;
        },
        setRankings (state, rankings) {
            state.rankings = rankings;
        },
        setUserPoints (state, user) {
            state.userPoints = user;
        },

    },
    actions: {
        login ({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request');
                axios({ url: '/api/v1/auth/login', data: user, method: 'POST' })
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
                axios({ url: '/api/v1/auth/register', data: user, method: 'POST' })
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
                axios({ url: '/api/v1/auth/logout', data: {}, method: 'POST' })
                    .then(resp => {
                        commit('logout');
                        localStorage.removeItem('token');
                        localStorage.clear();
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
                    url: `/api/v1/fixtures?league_id=${data.LEAGUE_ID}&is_current=1&status=Not%20Started`, data: {}, method: 'GET'
                })
                    .then(resp => {
                        const fixtures = resp.data.fixtures;
                        commit('setCurrentFixtures', fixtures);
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error');
                        reject(err);
                    });
            });
        },
        getCurrentRound ({ commit }) {
            return new Promise((resolve, reject) => {
                axios({
                    url: `/api/v1/rounds?league_id=${data.LEAGUE_ID}&is_current=1`, data: {}, method: 'GET'
                })
                    .then(resp => {
                        let rounds = resp.data.rounds;
                        rounds.forEach(round => {
                            let roundName = round.round.split("_");
                            round.round = roundName[1];
                        });
                        commit('setCurrentRound', rounds);
                        resolve(resp);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        getAllRounds ({ commit }) {
            return new Promise((resolve, reject) => {
                axios({
                    url: `/api/v1/rounds?league_id=${data.LEAGUE_ID}`, data: {}, method: 'GET'
                })
                    .then(resp => {
                        let rounds = resp.data.rounds;
                        rounds.forEach(round => {
                            let roundName = round.round.split("_");
                            round.round = roundName[1];
                        });
                        commit('setAllRounds', rounds);
                        resolve(resp);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        getRankings ({ commit }) {
            return new Promise((resolve, reject) => {
                axios({
                    url: `/api/v1/users?league_id=${data.LEAGUE_ID}`, data: {}, method: 'GET'
                })
                    .then(resp => {
                        let rankings = resp.data.users;

                        commit('setRankings', rankings);
                        resolve(resp);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        getUserRanking ({ commit }, user_id) {
            return new Promise((resolve, reject) => {
                axios({
                    url: `/api/v1/users/${user_id}?league_id=${data.LEAGUE_ID}`, data: {}, method: 'GET'
                })
                    .then(resp => {
                        let userRanking = resp.data.user;

                        commit('setUserPoints', userRanking);
                        resolve(resp);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        getCurrentUser ({ commit }, user_id) {
            return new Promise((resolve, reject) => {
                axios({
                    url: `/api/v1/users/user/${user_id}`, data: {}, method: 'GET'
                })
                    .then(resp => {
                        let user = resp.data.user;
                        commit('setCurrentUser', user);
                        resolve(resp);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        getPredictions ({ commit }) {
            return new Promise((resolve, reject) => {
                axios({
                    url: `/api/v1/predictions?league_id=${data.LEAGUE_ID}&is_current=1`, data: {}, method: 'GET'
                })
                    .then(resp => {
                        let fixtures = resp.data.predictions;
                        fixtures.forEach(fixture => {
                            if (!fixture.predictions.length) {
                                let predictions = [
                                    {
                                        home_team_prediction: null,
                                        away_team_prediction: null,
                                        fixture_id: fixture.fixture_id
                                    }
                                ];
                                fixture.predictions = predictions;
                            }
                        });
                        commit('setPredictions', fixtures);
                        resolve(fixtures);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        getSelectedPredictions ({ commit }, selectedRound) {
            return new Promise((resolve, reject) => {
                axios({
                    url: `/api/v1/predictions?league_id=${data.LEAGUE_ID}&round=${selectedRound}`, data: {}, method: 'GET'
                })
                    .then(resp => {
                        let fixtures = resp.data.predictions;
                        fixtures.forEach(fixture => {
                            if (!fixture.predictions.length) {
                                let predictions = [
                                    {
                                        home_team_prediction: null,
                                        away_team_prediction: null,
                                        fixture_id: fixture.fixture_id
                                    }
                                ];
                                fixture.predictions = predictions;
                            }
                        });
                        commit('setSelectedPredictions', fixtures);
                        resolve(fixtures);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        savePrediction ({ commit }, data) {
            return new Promise((resolve, reject) => {
                axios({
                    url: '/api/v1/predictions', ...data, method: 'POST'
                })
                    .then(resp => {
                        console.log('this is the saved prediction', resp);

                        //commit('setPredictions', fixtures);
                        resolve(resp);
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        // updateProfile ({ commit }, data) {
        //     return new Promise((resolve, reject) => {
        //         axios({
        //             url: `/api/v1/users/profile/1`, ...data, method: 'POST'
        //         })
        //             .then(resp => {
        //                 console.log('this is the profile resp', resp);

        //                 //commit('setPredictions', fixtures);
        //                 resolve(resp);
        //             })
        //             .catch(err => {
        //                 reject(err);
        //             });
        //     });
        // },
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
        currentFixtures: state => state.currentFixtures,
        currentRound: state => state.currentRound,
        currentUser: state => state.user,
        predictions: state => state.predictions,
        selectedPredictions: state => state.selectedPredictions,
        allRounds: state => state.allRounds,
        rankings: state => state.rankings,
        userPoints: state => state.userPoints
    }
});
