<template>
    <div class="main bg-slate-100">
      <Transition name="slideY">
          <Toast v-if="toast" type="success">
              <template #text>
              {{toastContent}}
              </template>
          </Toast>
      </Transition>
      <div class="py-8 px-12">
        <div class="text-xl text-purple-600 font-bold mb-2">Manage Posts</div>
        <div class="flex flex-wrap lg:flex-wrap-no items-end justify-between mt-4 mb-6">
        <div class="mb-4 lg:mb-0 mr-4">
          <router-link to="/posts/create">
            <div class="cursor-pointer text-purple-500 hover:text-purple-600 hover:underline flex items-end gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
              create new post
            </div>
          </router-link>
        </div>
        <div class="rounded w-full md:w-auto shadow-xs flex">
          <input type="text" v-model="search" class="w-full md:w-60 lg:w-auto rounded-l p-3 focus:outline-none text-gray-800 tracking-wide" placeholder="Search" @keyup.enter="searching" />
          <button class="bg-purple-500 hover:bg-purple-600 py-2 px-4 focus:outline-none text-white rounded-r" @click="searching">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </button>
        </div>
      </div>
        <div class="overflow-hidden rounded shadow-sm hidden md:block">
        <table class="shadow shadow-gray-100 w-full">
            <thead>
              <tr class="text-white bg-purple-500 text-sm text-left">
                <th class="p-3 font-semibold tracking-wide w-12">#</th>
                <th class="p-3 font-semibold tracking-wide w-48">Title</th>
                <th class="p-3 font-semibold tracking-wide w-48">Slug</th>
                <th class="p-3 font-semibold tracking-wide w-60">Category</th>
                <th class="p-3 font-semibold tracking-wide w-80">Content</th>
                <th class="p-3 font-semibold tracking-wide w-48">Author</th>
                <th class="p-3 font-semibold tracking-wide w-48">Created At</th>
                <th class="p-3 font-semibold tracking-wide w-24">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                <template v-if="!sloading">
                  <tr class="row" v-for="(post, index) in posts" :key="index">
                    <td class="p-3 text-sm text-purple-500 hover:text-purple-600 font-bold"><router-link :to=" `/posts/edit/${post.slug}`" class="hover:underline" to="/">{{post.id}}</router-link></td>
                    <td class="p-3 text-sm text-gray-800 font-medium">
                      <div>{{post.title}}</div>
                      <router-link :to="`/posts/details/${post.slug}`" class="text-blue-400 hover:underline">details &gt;</router-link>
                    </td>
                    <td class="p-3 text-sm text-gray-500 font-medium">{{post.slug}}</td>
                    <td class="p-3 text-sm text-gray-800">
                      <div class="inline-block bg-purple-500 px-2 py-0.5 text-sm font-medium text-white rounded-lg">
                        {{post.category}}
                      </div>
                    </td>
                    <td class="p-3 text-sm text-gray-700">{{post.content}}</td>
                    <td class="p-3 text-sm text-gray-800">{{post.author}}</td>
                    <td class="p-3 text-sm text-gray-600 font-medium">{{post.created_at}}</td>
                    <td class="p-3 text-sm">
                      <router-link :to=" `${loading ? '/posts/' : '/posts/edit/'+post.slug}`" class="inline-block text-purple-500 font-bold focus:outline-none hover:text-purple-600 mr-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg></router-link>
                      <button @click.prevent="deletePost(post.id)" :disabled="loading" class="text-red-500 font-bold focus:outline-none hover:text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg></button>
                    </td>
                </tr>
                </template>
                <template v-else>
                  <tr class="text-left animate-pulse row" v-for="i in 4" :key="i">
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                    <td class="px-4 py-3">
                      <div class="w-full rounded h-4 bg-gray-200"></div>
                    </td>
                  </tr>
                </template>
            </tbody>
        </table>
        </div>
        
        <template v-if="posts.length > 0 && !sloading">
          <div class="pt-6 pb-12 flex items-center justify-end space-x-2 text-purple-500 font-semibold">
            <button class="h-8 w-8 hover:text-purple-800 focus:outline-none" v-if="currentPage > 1" @click="getPosts(currentPage - 1)">
              <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            </button>
            <template v-if="currentPage > 2">
              <button :class="`${currentPage == 1 ? 'bg-purple-500 text-white' : 'hover:bg-purple-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-purple-500 py-1 px-3 rounded`" @click="getPosts(1)">1</button>
            </template>
            <template v-if="currentPage > 3">
              <button class="shadow-sm focus:outline-none border-2 border-purple-500 py-1 px-3 rounded" disabled>...</button>
            </template>
            <template v-for="(page, index) in pagination" :key="index">
              <button :class="`${page === currentPage ? 'bg-purple-500 text-white' : 'hover:bg-purple-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-purple-500 py-1 px-3 rounded`" @click="getPosts(page)">{{page}}</button>
            </template>
            <template v-if="nextLink && currentPage < lastPage-2">
              <button class="shadow-sm focus:outline-none border-2 border-purple-500 py-1 px-3 rounded" disabled>...</button>
            </template>
            <template v-if="nextLink && currentPage < lastPage-1">
              <button :class="`${currentPage == lastPage ? 'bg-purple-500 text-white' : 'hover:bg-purple-500 hover:text-white'} shadow-sm hover:shadow focus:outline-none border-2 border-purple-500 py-1 px-3 rounded`" @click="getPosts(lastPage)">{{lastPage}}</button>
            </template>
            <button class="h-8 w-8 hover:text-purple-800 focus:outline-none" v-if="nextLink" @click="getPosts(currentPage + 1)">
              <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            </button>
          </div>
        </template>
      </div>
    </div>
</template>

<script>
import { computed, onMounted, ref } from 'vue'
import Toast from '../../components/toast.vue'
import toastStore from '../../store/toast'
import api from '../../axios'
export default {
    components: {
      Toast,
    },
    setup() {
      const toast = ref(false)
      const toastContent = ref('')
      const posts = ref([])
      const currentPage = ref(1)
      const search = ref('')
      const nextLink = ref(null)
      const lastPage = ref(null)
      const loading = ref(false)
      const sloading = ref(false)
      const getPosts = (page) => {
        sloading.value = true
        currentPage.value = page
        api.get(`/api/posts?page=${page}&search=${search.value}`).then(res => {
          posts.value = res.data.data
          nextLink.value = res.data.links.next
          lastPage.value = res.data.meta.last_page
          scrollTo(0,0)
          sloading.value = false
        })
      }
      onMounted(() => {
        if (toastStore.state.toast) {
          toast.value = true
          toastContent.value = toastStore.state.toast
          setTimeout(removeToast, 2000)
        }
        getPosts(currentPage.value)
      })

      const removeToast = () => {
        toastStore.mutations.setToast('')
        toast.value = false
      }

    const searching = () => {
      currentPage.value = 1
      getPosts(currentPage.value)
    }

    const deletePost = (id)=>{
      loading.value = true
      api.delete(`/api/posts/${id}`).then(res=>{
        loading.value = false
        let index = posts.value.findIndex(i => i.id == id)
        posts.value.splice(index, 1)
        toast.value = true
        toastContent.value = res.data.success
        setTimeout(removeToast, 3000)
      })
    }

    const pagination = computed(() => {
      let arr = []
      let endLength = currentPage.value+1
      if (!nextLink.value) {
        endLength = currentPage.value
      }
      for(let pageLength = currentPage.value-1; pageLength <= endLength; pageLength++){
        if (pageLength < 1) {
          continue
        }
        arr.push(pageLength)
      }
      return arr
    })

    return { toast, toastContent, currentPage, pagination, search, searching, nextLink, lastPage, loading, sloading, posts, getPosts, deletePost }
  },
}
</script>