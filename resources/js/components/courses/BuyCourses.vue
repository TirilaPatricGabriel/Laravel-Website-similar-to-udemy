<template>
    <div class="bg-[#408ec6] w-full flex flex-col items-center justify-center text-white">
        
        <div class="w-11/12 h-full rounded-md bg-[#6883bc] flex flex-col items-center">
            <ul class="w-9/12">
                <li v-for="course in courses" :key="course.id" class="flex flex-row items-center border-2 rounded-md border-white mt-4">
                    <img class="w-64 h-32 rounded-md" :src="'/storage/thumbnails/courses/' + course.thumbnail">
                    <div class="flex flex-col ml-4">
                        <router-link :to="'/course/' + course.id" class="text-xl font-bold">{{course.title}}</router-link>
                        <p>{{course.description}}</p>
                        <p>{{course.price}}$</p>
                    </div>
                    <button @click="addToCart(course.id)" class="py-1 px-6 border-blue-800 bg-blue-200 text-black hover:text-white hover:bg-blue-800 rounded-md ml-8">BUY</button>
                </li>
            </ul>
        </div>

        <div v-if="errors.length>0" class="w-11/12 h-full rounded-md bg-[#6883bc] flex flex-col items-center">
            <h1 v-for="error in errors" :key="error" class="text-2xl text-black py-2 px-12 font-bold border-2 border-red-800 bg-red-200 rounded-md mt-8">{{error}}</h1>
        </div>

    </div>
</template> 

<script>
    export default {
        data(){
            return{
                courses: [],
                errors: []
            }
        },
        props: [
            'token',
        ],
        created(){
            this.fetchCourses()
        },
        methods: {
            fetchCourses(){
                let url = window.location.origin
                url += '/api/courses'
                axios.get(url)
                .then(res => {
                    console.log(res.data)
                    this.courses = res.data.courses.data
                })
                .catch(err => console.log(err))
            },
            addToCart(id){
                let url = window.location.origin
                url += `/api/cart/${id}`
                axios.put(url, {}, {
                    headers: {
                        'Authorization': 'Bearer ' + this.$props.token
                    }
                })
                .then(res => {
                    if(res.data.error) this.errors.push(res.data.error);
                    console.log(res)
                })
                .catch(err => {
                    console.log(err);
                    if(err.response.data.message) this.errors.push(err.response.data.message);    
                })
            }
        }
    }
</script>