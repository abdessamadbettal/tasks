import {createRouter, createWebHistory} from "vue-router";
import Tasks from "../views/Tasks.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import NotFound from "../views/NotFound.vue";
import AuthLayout from "../components/AuthLayout.vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import store from "../store";

const routes = [
    {
        path: "/",
        name: "Dashboard",
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: "/tasks",
                name: "Tasks",
                component: Tasks,
            },
        ]
    },
    {
        path: "/auth",
        redirect: "/login",
        name: "Auth",
        component: AuthLayout,
        meta: {isGuest: true},
        children: [
          {
            path: "/login",
            name: "Login",
            component: Login,
          },
          {
            path: "/register",
            name: "Register",
            component: Register,
          },
        ],
      },
      {
        path: '/404',
        name: 'NotFound',
        component: NotFound
      }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.access_token) {
      next({ name: "Login" });
    } else if (store.state.user.access_token && to.meta.isGuest) {
      next({ name: "Tasks" });
    } else {
      next();
    }
  });

export default router;
