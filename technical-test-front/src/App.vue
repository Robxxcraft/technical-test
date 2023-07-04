<template>
  <div class="flex min-h-screen">
    <!-- icon bar -->
    <Iconbar />
    
    <RouterView />
  </div>
</template>

<script>
import Iconbar from './components/iconbar.vue'
export default {
  components: {
    Iconbar
  },
  setup() {
    
  },
}
</script>