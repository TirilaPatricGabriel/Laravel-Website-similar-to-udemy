<template>
    <div v-if="!error" class="w-screen flex items-center justify-center bg-[#408ec6] text-white">
        <div class="flex flex-col items-center border-2 w-11/12 h-full rounded-md bg-[#6883bc] border-2">
            <ul class="flex flex-col justify-evenly">
                <li v-for="course in courses" :key="course.id" class="flex flex-row border-2 m-4">
                    <img class="w-32 h-16" :src="'storage/thumbnails/courses/' + course.thumbnail">
                    <div class="ml-4">
                        <router-link :to='"/courses-created-by-you/courses/" + course.id'>{{ course.title }}</router-link>
                        <p>{{ course.description }}</p>
                        <p>{{ course.price }}$</p>
                    </div>
                    <button @click="deleteCourse(course.id)" class="border-2 rounded-md border-red-800 bg-red-200 px-6 text-black hover:bg-red-800 hover:text-white">Delete</button>
                </li>
            </ul>
        </div>
    </div>

    <div v-if="errors.length>0" class="w-11/12 h-full rounded-md bg-[#6883bc] flex flex-col items-center">
        <h1 v-for="error in errors" :key="error" class="text-2xl text-black py-2 px-12 font-bold border-2 border-red-800 bg-red-200 rounded-md mt-8">{{error}}</h1>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                courses: [],
                errors: []               
            }
        },
        props: [
            'token'
        ],
        created(){
            this.fetchCourses();
        },
        methods: {
            fetchCourses(){
                let url = window.location.origin
                url += '/api/your-courses'
                axios.get(url, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(res => {
                    console.log(res);
                    if(res.data.error) this.errors.push(res.data.error);
                    else { this.courses = res.data.courses.data; }
                })
                .catch(err => {
                    console.log(err);
                    if(err.response.data.message) this.errors.push(err.response.data.message);
                })
            },
            deleteCourse(id){
                let url = window.location.origin
                url += `/api/courses/${id}`
                axios.delete(url, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                }).
                then(res => {
                    this.fetchCourses()
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