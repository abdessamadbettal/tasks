import { createStore } from "vuex";

const store = createStore({
  state: {
    user: {
      data: {},
      token: sessionStorage.getItem("access_token"),
    },
    tasks: [],
    currentTask: {
      data: {},
      loading: false,
    },
    progressTypes: ["todo", "doing", "done"],
  },
  getters: {},
  actions: {},
  mutations: {},
  modules: {},
});

export default store;
