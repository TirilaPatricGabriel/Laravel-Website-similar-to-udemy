<template>
    <div class="w-screen flex items-center justify-center bg-[#408ec6] text-white">
        <form @submit.prevent="addCourse" enctype="multipart/form-data" class="flex flex-col items-center justify-center border-2 px-64 py-40 rounded-md bg-[#6883bc]" id="add-course-form">
            <label for="title" class="text-xl font-bold mt-4">Title:</label>
            <input type="text" name="title" id="title" placeholder="Title" v-model="fields.title"              
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

            <label for="thumbnail_path" class="text-xl font-bold mt-4">Thumbnail:</label>
            <input type="file" name="thumbnail_path" id="thumbnail_path" @change="buildPath($event)"
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

            <label for="description" class="text-xl font-bold mt-4">Description:</label>
            <textarea rows="4" cols="50" name="description" id="description" form="add-course-form" placeholder="Here you can add the description of your course!" v-model="fields.description"
                class="
                    text-black 
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
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
            />

            <label for="price" class="text-xl font-bold mt-4">Price:</label>
            <input type="number" name="price" id="price" v-model="fields.price" placeholder="0" min="0" step="0.01"
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

            <button type="submit" class="border-2 rounded-md py-1 px-6 mt-6 hover:bg-[#1e2761]">Add Course</button>
        </form>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                fields: {
                    'title': '',
                    'thumbnail': null,
                    'description': '',
                    'price': 0
                },
            }
        },
        props: [
            'token'
        ],
        methods: {
            addCourse(){
                let url = window.location.origin
                url += '/api/courses'
                console.log(this.fields.thumbnail);

                var fileData = new FormData();
                fileData.append("title", this.fields.title);
                fileData.append("thumbnail", this.fields.thumbnail);
                fileData.append("description", this.fields.description);
                fileData.append("price", this.fields.price);
                console.log(fileData);
                axios.post(url, fileData, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(res => console.log(res))
                .catch(err => console.log(err))
            },
            buildPath(e){
                var files = e.target.files || e.dataTransfer.files;
                console.log(files)
                if(files.length){
                    this.fields.thumbnail = files[0]
                }
            }
        }
    }
</script>