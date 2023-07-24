<script setup>
 import { reactive } from "vue"
 import { tasks } from '/data.js'
</script>

<template>

<header class="bg-slate-200 rounded-lg m-2 py-2 px-4 flex justify-between">

  <div class="flex gap-4 items-center">
    <a href="#"><img class="w-16" src="../img/logo.png" alt=""></a>
    <a href="#">
      <h3 class="text-3xl font-bold">
        FreeLance
      </h3>
    </a>
    <a target="_blank" href="https://telegram.org/">
      <img class="w-10" src="../img/telegram-alt-svgrepo-com.png" alt="">
    </a>
    <a href="https://vk.com">
      <img class="w-10" src="../img/vk-svgrepo-com.png" alt="">
    </a>
  </div>


  <div class="flex gap-8 self-center">

    <input class="text-field__input h-11 self-center" type="text" id="Task" placeholder="Название заказа" autocomplete="off">

    <router-link :to="{ name: 'Customer'}">
      <button class="bg-zinc-900 text-slate-100 text-xl p-2 rounded-lg hover:scale-105 transition duration-500 w-44"> 
        Заказчик
      </button>
    </router-link>

    <router-link :to="{ name: 'Executor'}">
      <button class="bg-zinc-900 text-xl text-slate-100 py-2 px-3 rounded-lg hover:scale-105 transition duration-500 w-44">
        Исполнитель
      </button>
    </router-link>
    
  </div>

</header>




<div class="grid grid-cols-2" v-if="$route.name !== 'Executor' && $route.name !== 'Customer'">
  <div class="bg-slate-200 m-2 p-4 rounded-lg h-fit overflow-hidden" v-for="task in tasks" :key="task.id">
    <div style="grid-template-columns: 80% 20%; height: 130px;" class="grid">
      <div>
        <p class="text-xl overflow-ellipsis whitespace-nowrap overflow-hidden w-full"> {{ task.task }} </p>
        <p class="scroll-bar m-auto text-base h-24 mt-2 overflow-y-auto overflow-ellipsis"> {{ task.description }} </p>
      </div>

      <div class="self-center m-auto h-full">
        <p class="m-auto text-center text-lg overflow-hidden whitespace-nowrap overflow-ellipsis w-40"> {{ task.sphere }} </p>
        <p class="w-max m-auto mt-2 text-xl"> {{ task.budget }} руб. </p>
        <button class="bg-zinc-700 self-center m-auto flex mt-2 text-slate-100 py-2 px-3 rounded-lg hover:scale-105 transition duration-500">
          Откликнуться
        </button>
      </div>
    </div>
  </div>
</div>

<router-view></router-view>
</template>

<script>

</script>