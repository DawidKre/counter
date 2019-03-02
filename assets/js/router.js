import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);
console.log(process.env.BASE_URL+'/app');
export default new Router({
  mode: "history",
  base: '/app',
  routes: [
    {
      path: "/",
      name: "home",
      component: () =>
        import(/* webpackChunkName: "home" */ "./views/Home")
    },
    {
      path: "/about",
      name: "about",
      component: () =>
        import(/* webpackChunkName: "about" */ "./views/About.vue")
    },
    {
      path: "/export",
      name: "Export",
      component: () =>
        import(/* webpackChunkName: "export" */ "./views/Export.vue")
    },
    {
      path: "/templates",
      name: "Templates",
      component: () =>
        import(/* webpackChunkName: "export" */ "./views/Templates.vue")
    }
  ]
});
