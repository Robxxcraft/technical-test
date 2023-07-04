<template>
    <div class="max-h-screen w-16">
      <div class="navbar bg-white fixed z-10 h-screen flex flex-col items-center">
        <a href="/" class="pt-8 mb-12 text-purple-500 z-20">
          <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.5 9c1 1.06 1.5 2.394 1.5 4 0 3.466-3.7 4.276-5.5 9-.667-.575-1-1.408-1-2.5 0-3.482 5-5.29 5-10.5zm-4-4c1.2 1.238 1.8 2.572 1.8 4 0 4.951-6.045 5.692-4.8 13C9.833 20.84 9 19.173 9 17c0-3.325 5.5-6 5.5-12zM10 1c1.333 1.667 2 3.167 2 4.5 0 6.25-8.5 8.222-4 16.5-2.616-.58-4.5-3-4.5-6C3.5 9.5 10 8.5 10 1z"/></svg>
        </a>
        <router-link to="/" :class=" `px-6 py-1 relative ${route.path == '/' ? 'text-purple-500' : 'text-gray-500'}`">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19 21.0001H5C4.44772 21.0001 4 20.5524 4 20.0001V11.0001L1 11.0001L11.3273 1.61162C11.7087 1.26488 12.2913 1.26488 12.6727 1.61162L23 11.0001L20 11.0001V20.0001C20 20.5524 19.5523 21.0001 19 21.0001ZM6 19.0001H18V9.15757L12 3.70302L6 9.15757V19.0001Z"></path></svg>
          <div v-if="route.path == '/'" class="absolute right-0 top-0 w-1 h-full rounded-l bg-purple-500"></div>
        </router-link>
        <router-link to="/posts" :class="`mt-7 px-6 py-1 relative ${route.path.includes('posts') ? 'text-purple-500' : 'text-gray-500'}`" fill="currentColor">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M19 22H5a3 3 0 0 1-3-3V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v12h4v4a3 3 0 0 1-3 3zm-1-5v2a1 1 0 0 0 2 0v-2h-2zm-2 3V4H4v15a1 1 0 0 0 1 1h11zM6 7h8v2H6V7zm0 4h8v2H6v-2zm0 4h5v2H6v-2z"/></svg>
          <div v-if="route.path.includes('posts')" class="absolute right-0 top-0 w-1 h-full rounded-l bg-purple-500"></div>
        </router-link>
      </div>
    </div>
</template>

<script>
import { useRoute } from 'vue-router'
export default {
  setup() {
    const route = useRoute()
    return { route }
  },
}
</script>