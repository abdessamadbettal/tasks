import {createRouter, createWebHistory} from "vue-router";
import Tasks from "../views/Tasks.vue";
const routes = [
    {
        path: "/tasks",
        name: "Tasks",
        component: Tasks
    },
];

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router;
