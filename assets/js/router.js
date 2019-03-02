import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);
export default new Router({
  mode: "history",
  base: '/app/',
  routes: [
    {
      path: "/",
      name: "CreateCounter",
      component: () =>
        import(/* webpackChunkName: "CreateCounter" */ "./views/CreateCounter")
    },
    {
      path: "/counters",
      name: "counters",
      component: () =>
        import(/* webpackChunkName: "counters" */ "./views/Counters")
    },
    {
      path: "/templates",
      name: "Templates",
      component: () =>
        import(/* webpackChunkName: "export" */ "./views/Templates.vue")
    }
  ]
});
