<template>
    <div class="w-full bg-slate-100">
        <Transition name="slideY">
        <Toast v-if="toast" type="error">
            <template #text>
            {{toastContent}}
            </template>
        </Toast>
        </Transition>
        <div class="py-6 lg:py-8 px-4 md:px-8 lg:px-12 flex justify-center">
            <div class="bg-white w-full max-w-2xl rounded-lg shadow-sm py-5">
                <div class="text-xl text-purple-600 text-center font-bold mb-2">Edit post - {{ title }}</div>
                <form class="w-full mx-auto md:px-8 py-4" @submit.prevent="updatePost">
                    <div class="flex max-w-lg mx-auto flex-wrap px-0 md:px-8 flex-col">
                        <div class="relative pb-5 flex-2">
                            <label class="tracking-wide text-gray-800 ml-2 font-medium">
                                Title
                            </label>
                            <input @focus="clearErrors('title')" class="focus:outline-offset-2 outline-purple-400 mt-2 w-full bg-gray-50 text-gray-700 border border-gray-300 rounded-lg py-3 px-4 mb-3" v-model="form.title" placeholder="Enter title" type="text">
                            <div v-if="errors.title" class="bottom-0 absolute p-1 text-red-500 text-sm italic">{{errors.title[0]}}</div>
                        </div>
                        <div class="relative pb-5 flex-2">
                            <label class="tracking-wide text-gray-800 ml-2 font-medium">
                                Category
                            </label>
                            <input @focus="clearErrors('category')" class="focus:outline-offset-2 outline-purple-400 mt-2 w-full bg-gray-50 text-gray-700 border border-gray-300 rounded-lg py-3 px-4 mb-3" v-model="form.category" placeholder="Enter category" type="text">
                            <div v-if="errors.category" class="bottom-0 absolute p-1 text-red-500 text-sm italic">{{errors.category[0]}}</div>
                        </div>
                        <div class="relative pb-5 flex-2">
                            <label class="tracking-wide text-gray-800 ml-2 font-medium">
                                Content
                            </label>
                            <textarea @focus="clearErrors('content')" class="focus:outline-offset-2 outline-purple-400 mt-2 w-full bg-gray-50 text-gray-700 border border-gray-300 rounded-lg py-3 px-4 mb-3" v-model="form.content" placeholder="Enter content"></textarea>
                            <div v-if="errors.content" class="bottom-0 absolute p-1 text-red-500 text-sm italic">{{errors.content[0]}}</div>
                        </div>
                        <div class="relative pb-5 flex-2">
                            <label class="tracking-wide text-gray-800 ml-2 font-medium">
                                Author
                            </label>
                            <input @focus="clearErrors('author')" class="focus:outline-offset-2 outline-purple-400 mt-2 w-full bg-gray-50 text-gray-700 border border-gray-300 rounded-lg py-3 px-4 mb-3" v-model="form.author" placeholder="Enter author" type="text">
                            <div v-if="errors.author" class="bottom-0 absolute p-1 text-red-500 text-sm italic">{{errors.author[0]}}</div>
                        </div>
                        <div class="mt-3 flex items-start justify-end text-right">
                            <router-link to="/posts" class="text-gray-500 tracking-wide bg-gray-200 py-2 px-3 rounded text-sm font-bold shadow-sm transition border-3 border-gray-500 hover:bg-gray-500 hover:text-white mr-3" type="submit">Back</router-link>
                            <button class="text-white tracking-wide bg-purple-500 py-2 px-3 rounded text-sm font-bold shadow-sm transition focus:outline-none hover:bg-purple-600" type="submit">
                                <template v-if="loading">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: 0; display: block; shape-rendering: auto;" width="20" height="20" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                        <circle cx="50" cy="50" fill="none" stroke="#ffffff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                                            <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                                        </circle>
                                    </svg>
                                </template>
                                <template v-else>
                                    Create
                                </template>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
    
    
<script>
import { onMounted, reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../../axios'
import Toast from '../../components/toast.vue'
import toastStore from '../../store/toast'
export default {
    components: {
        Toast
    },
    setup() {
        const toast = ref(false)
        const toastContent = ref('')
        const loading = ref(false)
        const title = ref('')
        const id = ref(null)
        const form = reactive({
            title: '',
            category: '',
            content: '',
            author: '',
        });
        const errors = ref({})
        const route = useRoute()
        const router = useRouter()

        onMounted(()=>{
            api.get(`/api/posts/show/${route.params.slug}`).then(res=>{
                id.value = res.data.data.id
                title.value = res.data.data.title
                form.title = res.data.data.title
                form.category = res.data.data.category
                form.content = res.data.data.content
                form.author = res.data.data.author
            })
        })

        const updatePost = () => {
            loading.value = true
            api.post(`/api/posts/${id.value}`, form).then(res=>{
                loading.value = false
                toastStore.mutations.setToast(res.data.success)
                router.push('/posts');
            }).catch(err => {
                loading.value = false
                toast.value = true
                toastContent.value = 'Some error occured'
                const removeToast = () => {
                    toastContent.value = ''
                    toast.value = false
                }
                setTimeout(removeToast, 3000)
                window.scrollTo(0,0)
                
                if (err.response.status === 422) {
                    errors.value = err.response.data.errors
                }
            })
        }

        const clearErrors = (column)=>{
            errors.value[column] = ''
        }

        return { loading, toast, toastContent, updatePost, errors, title, form, clearErrors }
    }
};
</script>