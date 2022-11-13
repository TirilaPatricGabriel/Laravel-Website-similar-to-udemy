<template>
    <div class="bg-[#408ec6] w-full flex flex-col items-center justify-center">
        
        <div v-if="!error" class="w-11/12 h-full rounded-md bg-[#6883bc]">
            <ul>
                <li v-for="course in courses" :key="course.id" class="flex flex-row items-center border-2 rounded-md border-white mt-4">
                    <img class="w-64 h-32 rounded-md" :src="'/storage/thumbnails/courses/' + course.thumbnail">
                    <div class="flex flex-col ml-4">
                        <router-link :to="'/course/' + course.id" class="text-xl font-bold">{{course.title}}</router-link>
                        <p>{{course.description}}</p>
                        <p>{{course.price}}$</p>
                    </div>
                </li>
            </ul>
        </div>

        <div v-if="error" class="w-11/12 h-full rounded-md bg-[#6883bc] flex flex-col items-center justify-center">
            <h1 class="text-2xl py-2 px-12 font-bold border-2 border-red-800 bg-red-200 rounded-md">{{error}}</h1>
        </div>
    </div>
</template> 

<script>
    export default {
        data(){
            return {
                courses: [],
                error: ""
            }
        },
        props: [
            'token'
        ],
        created(){
            this.fetchBoughtCourses();
        },
        methods: {
            fetchBoughtCourses(){
                let url = window.location.origin
                url += '/api/bought-courses'
                axios.get(url, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(res => {
                    console.log(res);
                    if(res.data.error) this.error = res.data.error;
                    else { this.courses = res.data.courses.data; }
                })
                .catch(err => console.log(err))
            }
        }
    }
</script>