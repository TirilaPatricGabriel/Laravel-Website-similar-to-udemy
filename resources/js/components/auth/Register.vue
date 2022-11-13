<template>
    <div class="w-screen flex items-center justify-center bg-[#408ec6] text-white">
        <form @submit.prevent="register" class="flex flex-col items-center justify-center border-2 px-64 py-40 rounded-md bg-[#6883bc]">
            
            <label for="name" class="text-xl font-bold">Name:</label>
            <input type="text" name="name" id="name" v-model="fields.name"                 
                class="
                    form-control
                    block
                    w-96
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    mt-2
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            ">

            <label for="email" class="text-xl font-bold mt-4">Email:</label>
            <input type="email" name="email" id="email" v-model="fields.email"                 
                class="
                    form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    mt-2
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            ">

            <label for="password" class="text-xl font-bold mt-4">Password:</label>
            <input type="password" name="password" id="password" v-model="fields.password"                 
                class="
                    form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    mt-2
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            ">

            <label for="password_confirmation" class="text-xl font-bold mt-4">Password Confirmation:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" v-model="fields.password_confirmation" 
                class="
                    form-control
                    block
                    w-full
                    px-3
                    py-1.5
                    text-base
                    font-normal
                    text-gray-700
                    bg-white bg-clip-padding
                    border border-solid border-gray-300
                    rounded
                    transition
                    ease-in-out
                    mt-2
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            ">

            <button type="submit" class="border-2 rounded-md py-1 px-6 mt-6 hover:bg-[#1e2761]">Register</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

    export default{
        data(){
            return {
                fields: {
                    'name': '',
                    'email': '',
                    'password': '',
                    'password-confirmation': ''
                }
            }
        },
        methods: {
            register(){
                axios.post('api/register', this.fields)
                .then(res => {
                    console.log(res)
                    this.fields.name = ''
                    this.fields.email = ''
                    this.fields.password = ''
                    this.fields.password_confirmation = ''    
                    this.$emit('changeNavbarAndToken');
                })
                .catch(err => {
                    console.log(err)
                })
            }
        }
    }
</script>