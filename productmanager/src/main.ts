import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Cookies from 'js-cookie';

//createApp(App).use(store).use(router).mount('#app')

const app = createApp(App)

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const token = Cookies.get(process.env.VUE_APP_TOKEN_API);
    if (token) {
      next();
    } else {
      next('/');
    }
  } else {
    next();
  }
});

app.use(router)
app.mount('#app')