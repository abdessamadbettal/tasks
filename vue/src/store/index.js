import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: {},
            access_token: sessionStorage.getItem("access_token"),
        },
        tasks: {
            loading: false,
            links: [],
            data: []
          },
        currentTask: {
            data: {},
            loading: false,
        },
        progressTypes: ["todo", "doing", "done"],
        notification: {
            show: false,
            type: "success",
            message: "",
        },
    },
    getters: {},
    actions: {
        register({ commit }, user) {
            return axiosClient.post("/auth/register", user).then(({ data }) => {
                commit("setUser", data.user);
                commit("setToken", data.access_token);
                return data;
            });
        },
        login({ commit }, user) {
            return axiosClient.post("/auth/login", user).then(({ data }) => {
                console.log(data);
                commit("setUser", data.user);
                commit("setToken", data.access_token);
                return data;
            });
        },
        logout({ commit }) {
            return axiosClient.post("/auth/logout").then((response) => {
                commit("logout");
                return response;
            });
        },
        getUser({ commit }) {
            return axiosClient.get("/auth/user").then((res) => {
                commit("setUser", res.data);
            });
        },
        createTask({ commit }, task) {
            return axiosClient.post("/tasks", task).then(({ data }) => {
                commit("notify", {
                    message: "Task created successfully",
                    type: "success",
                });
                return data;
            });
        },
        getTasks({ commit }) {
            commit("setLoadingTasks", true);
            return axiosClient.get("/tasks").then(({ data }) => {
                commit("setTasks", data);
                commit("setLoadingTasks", false);
                return data;
            });
        },
        updateTask({ commit }, { id, task }) {
            return axiosClient.put(`/tasks/${id}`, task).then(({ data }) => {
                console.log(data.data);
                commit("updateTask", data.data);
                commit("notify", {
                    message: "Task updated successfully",
                    type: "success",
                });
                return data;
            });
        },
        deleteTask({ commit }, id) {
            return axiosClient.delete(`/tasks/${id}`).then(({ data }) => {
                commit("deleteTask", id);
                commit("notify", {
                    message: "Task deleted successfully",
                    type: "success",
                });
                return data;
            });
        },

    },
    mutations: {
        logout: (state) => {
            state.user.access_token = null;
            state.user.data = {};
            sessionStorage.removeItem("access_token");
        },

        setUser: (state, user) => {
            state.user.data = user;
        },
        setToken: (state, access_token) => {
            state.user.access_token = access_token;
            sessionStorage.setItem("access_token", access_token);
        },
        dashboardLoading: (state, loading) => {
            state.dashboard.loading = loading;
        },
        setDashboardData: (state, data) => {
            state.dashboard.data = data;
        },
        setTasks: (state, tasks) => {
            state.tasks.data = tasks.data;
        },
        updateTask: (state, task) => {
            state.tasks.data = state.tasks.data.map((t) => {
                if (t.id === task.id) {
                    return task;
                }
                return t;
            });
        },
        deleteTask: (state, id) => {
            state.tasks.data = state.tasks.data.filter((t) => t.id !== id);
        },
        setLoadingTasks: (state, loading) => {
            state.tasks.loading = loading;
        },
        notify: (state, { message, type }) => {
            state.notification.show = true;
            state.notification.type = type;
            state.notification.message = message;
            setTimeout(() => {
                state.notification.show = false;
            }, 3000);
        },
    },
    modules: {},
});

export default store;
