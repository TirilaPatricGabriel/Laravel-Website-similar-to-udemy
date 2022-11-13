<template>
    <div class="bg-[#408ec6] w-full flex flex-col items-center justify-center">
        
        <div class="w-11/12 h-full rounded-md bg-[#6883bc] flex flex-col items-center">
            <ul class="w-9/12">
                <li v-for="course in courses" :key="course.id" class="flex flex-row items-center border-2 rounded-md border-white mt-4">
                    <img class="w-64 h-32 rounded-md" :src="'/storage/thumbnails/courses/' + course.thumbnail">
                    <div class="flex flex-col ml-4">
                        <h2 class="text-xl font-bold">{{course.title}}</h2>
                        <p>{{course.description}}</p>
                        <p>{{course.price}}$</p>
                    </div>
                    <button @click="removeItemFromCart(course.id, course.price)" class="py-1 px-6 bg-red-200 border-2 border-red-800 text-black rounded-md hover:bg-red-800 hover:text-white ml-4">REMOVE</button>
                
                    <div class="flex flex-row ml-4">
                        <h1 class="text-xl font-bold text-white">{{cart_price}}$</h1>
                        <button @click="buyCourse(course.id, course.price)" class="py-1 px-6 border-2 border-blue-800 bg-blue-200 text-black rounded-md hover:bg-blue-800 hover:text-white">BUY</button>
                    </div>
                </li>
            </ul>
        </div>

        <div v-if="errors.length>0" class="w-11/12 h-full rounded-md bg-[#6883bc] flex flex-col items-center">
            <h1 v-for="error in errors" :key="error" class="text-2xl py-2 px-12 font-bold border-2 border-red-800 bg-red-200 rounded-md mt-8">{{error}}</h1>
        </div>

    </div>
</template> 

<script>
    export default{
        data(){
            return {
                courses: [],
                cart_price: 0,
                errors: []
            }
        },
        props: [
            'token'
        ],
        created(){
            this.fetchCartCourses();
        },
        methods: {
            fetchCartCourses(){
                let url = window.location.origin
                url += '/api/cart'
                axios.get(url, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(res => {
                    console.log(res);
                    if(res.data.error) this.errors.push(res.data.error);
                    this.courses = res.data.courses.data;
                    this.cart_price = res.data.cart_price;
                })
                .catch(err => {
                    console.log(err);
                    if(err.response.data.message) this.errors.push(err.response.data.message);
                })
            },
            removeItemFromCart(course_id){
                let url = window.location.origin
                url += `/api/cart/${course_id}`
                axios.delete(url, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(res => {
                    console.log(res)
                    this.fetchCartCourses();
                })
                .catch(err => {
                    console.log(err);
                    if(err.response.data.message) this.errors.push(err.response.data.message);  
                })
            },
            buyCourse(id){
                let url = window.location.origin
                url += `/api/cart/buy/${id}`
                axios.put(url, {}, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(res => {
                    this.fetchCartCourses();
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