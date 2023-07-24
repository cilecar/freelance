import { createRouter, createWebHashHistory } from 'vue-router'
import Executor from '/src/pages/ExecutorPage.vue'
import Customer from '/src/pages/CustomerPage.vue'

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    {
      path: '/Executor', 
      name: 'Executor',
      component: Executor
    },
    {
      path: '/Customer',
      name: 'Customer',
      component: Customer
    }
  ]
})

export default router
