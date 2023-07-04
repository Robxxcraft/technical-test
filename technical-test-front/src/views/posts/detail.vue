<template>
    <div class="w-full bg-slate-100">
        <div class="py-6 lg:py-8 px-4 md:px-8 lg:px-12 flex justify-center">
            <div class="bg-white w-full max-w-2xl rounded-lg shadow-sm py-5 px-6">
                <div class="text-lg text-purple-600 text-center font-bold mb-3">{{post.title}}</div>
                <div class="flex items-center justify-between">
                    <div class="">
                        
                    <div class="text-gray-00 font-medium text-purple-600">{{post.author}}</div>
                    <div class="text-gray-400 text-sm font-medium">{{post.created_at}}</div>
                    </div>
                    <div class="font-medium bg-purple-500 text-white px-3 py-0.5 rounded-lg">{{post.category}}</div>
                </div>
                <div class="mt-3 bg-gray-100 text-gray-700 p-3 rounded-lg">
                    {{ post.content }}
                </div>
                
                <div class="mt-6 flex justify-end">                    
                    <router-link to="/posts" class="text-gray-500 tracking-wide bg-gray-200 py-2 px-3 rounded text-sm font-bold shadow-sm transition border-3 border-gray-500 hover:bg-gray-500 hover:text-white" type="submit">Back</router-link>
                </div>
            </div>
        </div>
    </div>
</template>
    
    
<script>
import { onMounted, ref } from 'vue'
import api from '../../axios'
import { useRoute } from 'vue-router';
export default {
    setup() {
        const post = ref({})
        const route = useRoute()

        onMounted(()=>{
            api.get(`/api/posts/show/${route.params.slug}`).then(res=>{
                post.value = res.data.data
            })
        })

        return { post }
    }
};
</script>