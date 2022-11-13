<template>
    <div class="flex flex-row">
        <div class="flex flex-col items-center justify-center h-screen w-2/12 border-2 bg-[#1e2761] text-white justify-evenly">
            <router-link to="/" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Home</router-link>
            <router-link to="/login"  v-if="loggedIn === false" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Log In</router-link>
            <router-link to="/register" v-if="loggedIn === false" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Register</router-link>
            <button v-if="loggedIn === true" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]" @click="logOut">Log Out</button>
            <router-link to="/cart" v-if="loggedIn === true" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Cart</router-link>
            <router-link to="/buy-courses" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Buy Courses</router-link>
            <router-link to="/add-course" v-if="loggedIn === true" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Add Courses</router-link>
            <router-link to="/bought-courses" v-if="loggedIn === true" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Courses you own</router-link>
            <router-link to="/courses-created-by-you" v-if="loggedIn === true" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Courses you created!</router-link>
            <router-link to="/" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Teachers</router-link>
            <router-link to="/" class="border-2 rounded-md py-1 px-6 hover:bg-[#6883bc]">Learn</router-link>
        </div>
        <router-view @changeNavbarAndToken="changeNavbarAndGetNewToken" :token="token"></router-view>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                loggedIn: false,
                token: ''
            }
        },
        created(){
            console.log(this.token)
            this.getToken()
        }, 
        methods: {
            getToken(){
                axios.get('api/get-token')
                .then(res => {
                    this.token = res.data.token
                    if(this.token) this.loggedIn = true;
                    console.log(this.token)
                })
                .catch(err => console.log(err))
            },  
            changeNavbarAndGetNewToken(){
                this.loggedIn = !this.loggedIn
                console.log("TRYING TO CHANGE TOKEN TOO")
                this.getToken()
            },
            logOut(){
                console.log('Bearer ' + this.token)
                axios.post('api/logout', {}, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(res => {
                    this.loggedIn = false
                    console.log(res)
                    this.token = ''
                })
                .catch(err => console.log(err))
            }
        }
    }
</script>