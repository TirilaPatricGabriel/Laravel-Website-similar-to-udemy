<template>
    <div class="w-screen flex items-center justify-center bg-[#408ec6] text-white">
        <div class="flex flex-col pt-10 border-2 w-11/12 h-full rounded-md bg-[#6883bc] border-2">
            <div id="course-inf" class="mx-auto px-32 py-16 flex flex-col items-center">
                <form @submit.prevent="editCourse" class="flex flex-col items-center" enctype="multipart/form-data">    
                    <input class="text-xl font-bold mb-4 bg-[#6883bc] border-2 rounded-md" :placeholder="course.title" v-model="edit_course.title">
                    <img :src="'/storage/thumbnails/courses/' + course.thumbnail" class="w-96 h-48 rounded-md">
                    <input type="file" @change="addImageToFields($event)">
                    <textarea name="" id="" cols="30" rows="4" class="w-96 mt-4 bg-[#6883bc] border-2 rounded-md" :placeholder="course.description" v-model="edit_course.description"></textarea>
                    <input type="number" :placeholder="course.price" min="0" v-model="edit_course.price" step="0.01"> $
                    <div class="flex flex-row justify-evenly">
                        <button type="submit" class="py-1 px-6 border-2 border-green-800 bg-green-200 rounded-md text-black hover:text-white hover:bg-green-800">EDIT</button>
                    </div>
                </form>
            </div>

            <form @submit.prevent="addEditEpisode" class="text-black w-8/12 mx-auto flex flex-col items-center justify-center border-2 rounded-md mt-8 py-48" enctype="multipart/form-data" id="add-episode-form">

                <label for="title">Title:</label>
                <input type="text" name="title" id="title" placeholder="Title" v-model="fields.title">

                <label for="description">Description:</label>
                <textarea name="description" id="description" cols="40" rows="4" form="add-episode-form" v-model="fields.description" placeholder="Here you can add a description/insights of this episode!"/>
                
                <div id="video-div">
                    <label for="video">Video:</label>
                    <input type="file" name="video" id="video" @change="buildPath($event)">
                </div>

                <button type="submit" id="addFormButton">Add Episode</button>
            </form>
            
            <ul class="flex flex-col justify-evenly">
                <li v-for="episode in episodes" :key="episode.id" class="flex flex-row m-4 mt-8 rounded-md">
                    <div class="flex flex-row items-center border-2 mx-auto w-9/12">

                        <video width='240' height= '140' controls>
                            <source :src='"/storage/videos/" + episode.video'>
                        </video>
                        <div class="ml-8">
                            <router-link :to="'/episodes/' + episode.id" class="text-xl font-bold">{{ episode.title }}</router-link>
                            <p>{{ episode.description }}</p>
                        </div>
                        <div class="ml-8">
                            <button @click="editEpisode(episode.id, episode.title, episode.description)" class="py-1 px-6 border-2 border-green-800 bg-green-200 rounded-md text-black hover:bg-green-800 hover:text-white">EDIT</button>
                            <button @click="deleteEpisode(episode.id)" class="py-1 px-6 border-2 border-red-800 bg-red-200 rounded-md ml-4 text-black hover:bg-red-800 hover:text-white">DELETE</button>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                course: {},
                episodes: [],
                fields: {
                    'title': '',
                    'description': '',
                    'video': null
                },
                episode_id: -1,
                edit_course: {
                    'title': '',
                    'description': '',
                    'thumbnail': null
                }              
            }
        },
        props: [
            'token'
        ],
        created(){
            this.fetchCourse(this.$route.params.id)
        },
        methods: {
            fetchCourse(id){
                let url = window.location.origin
                url += `/api/courses/${id}`
                axios.get(url)
                .then(res => {
                    console.log(res)
                    this.course = res.data.course
                    this.episodes = res.data.episodes.data
                    this.edit_course.title = res.data.course.title
                    this.edit_course.description = res.data.course.description
                    this.edit_course.price = res.data.course.price
                })
                .catch(err => console.log(err))
            },
            buildPath(e){
                var files = e.target.files || e.dataTransfer.files;
                console.log(files)
                if(files.length){
                    this.fields.video = files[0]
                }
            },
            addImageToFields(e){
                var files = e.target.files || e.dataTransfer.files;
                console.log(files)
                if(files.length){
                    this.edit_course.thumbnail = files[0]
                }
            },
            editCourse(){
                console.log(this.edit_course.thumbnail)
                let url = window.location.origin
                url += `/api/courses/${this.course.id}`
                
                axios.put(url, {
                    'title': this.edit_course.title,
                    'thumbnail': this.edit_course.thumbnail,
                    'description': this.edit_course.description,
                    'price': this.edit_course.price
                }, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(res => console.log(res))
                .catch(err => console.log(err))
            },
            addEditEpisode(){
                let url = window.location.origin

                let formData = new FormData();
                formData.append('title', this.fields.title)
                formData.append('description', this.fields.description)

                if(this.episode_id === -1){
                    formData.append('video', this.fields.video)
                    url += `/api/episodes/${this.course.id}`
                    axios.post(url, formData, {
                        headers: {
                            'Authorization': 'Bearer ' + this.token 
                        }
                    })
                    .then(res => {
                        console.log(res)
                        this.fetchCourse(this.$route.params.id);
                    })
                    .catch(err => console.log(err))
                }
                else{
                    url += `/api/episodes/${this.episode_id}`
                    axios.put(url, this.fields, {
                        headers: {
                            'Authorization': 'Bearer ' + this.token
                        }
                    })
                    .then(res => {
                        console.log(res)
                        this.episode_id = -1
                        this.fields.title =  ''
                        this.fields.description = ''

                        const videoDiv = document.querySelector('#video-div');
                        videoDiv.style.display = "block";

                        const button = document.querySelector('#addFormButton')
                        button.innerText = 'Add Post'
                        this.fetchCourse(this.$route.params.id)
                    })
                    .catch(err => console.log(err))
                }
            },
            deleteEpisode(id){
                let url = window.location.origin
                url += `/api/episodes/${id}`
                axios.delete(url, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(res => {
                    console.log(res)
                    this.fetchCourse(this.$route.params.id);
                })
                .catch(err => console.log(err))
            },
            editEpisode(id, title, description){
                this.episode_id = id
                this.fields.title =  title
                this.fields.description = description
                
                const button = document.querySelector('#addFormButton')
                button.innerText = 'Edit Post'

                const videoDiv = document.querySelector('#video-div');
                videoDiv.style.display = "none";
            }
        }
    }
</script>