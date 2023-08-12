import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
  state: {
    user: {
      data: {},
      access_token: sessionStorage.getItem("access_token"),
    },
    tasks: [],
    currentTask: {
      data: {},
      loading: false,
    },
    progressTypes: ["todo", "doing", "done"],
    notification: {
        show: false,
        type: 'success',
        message: ''
      }
  },
  getters: {},
  actions: {
    register({commit}, user) {
        return axiosClient.post('/auth/register', user)
          .then(({data}) => {
            commit('setUser', data.user);
            commit('setToken', data.access_token)
            return data;
          })
      },
      login({commit}, user) {
        return axiosClient.post('/auth/login', user)
          .then(({data}) => {
            console.log(data);
            commit('setUser', data.user);
            commit('setToken', data.access_token)
            return data;
          })
      },
      logout({commit}) {
        return axiosClient.post('/auth/logout')
          .then(response => {
            commit('logout')
            return response;
          })
      },
      getUser({commit}) {
        return axiosClient.get('/auth/user')
        .then(res => {
          console.log(res);
          commit('setUser', res.data)
        })
      },
  },
  mutations: {
    logout: (state) => {
        state.user.access_token = null;
        state.user.data = {};
        sessionStorage.removeItem("access_token");
      },

      setUser: (state, user) => {
        // console.log(user);
        state.user.data = user;
      },
      setToken: (state, access_token) => {
        state.user.access_token = access_token;
        sessionStorage.setItem('access_token', access_token);
      },
      dashboardLoading: (state, loading) => {
        state.dashboard.loading = loading;
      },
      setDashboardData: (state, data) => {
        state.dashboard.data = data
      },
      notify: (state, {message, type}) => {
        state.notification.show = true;
        state.notification.type = type;
        state.notification.message = message;
        setTimeout(() => {
          state.notification.show = false;
        }, 3000)
      },
  },
  modules: {},
});

export default store;
