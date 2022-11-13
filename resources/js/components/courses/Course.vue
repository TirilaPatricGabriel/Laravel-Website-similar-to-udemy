<template>
    <div class="w-screen flex items-center justify-center bg-[#408ec6] text-white">
        <div class="flex flex-col pt-10 border-2 w-11/12 h-full rounded-md bg-[#6883bc] border-2">

            <div class="course border-2 rounded-md border-white flex flex-col justify-evenly">
                <h1 class="text-2xl font-bold">{{course.title}}</h1>
                <p>{{course.description}}</p>
                <p>{{course.price}}</p>$
                <button class="w-32 border-2 rounded-md border-blue-800 bg-blue-200 text-black py-1 px-6 hover:bg-blue-800 hover:text-white">BUY</button>
            </div>

            <ul class="flex flex-col justify-evenly">
                <li v-for="episode in episodes" :key="episode.id" class="flex flex-row m-4 mt-8 rounded-md">
                    <div class="flex flex-row items-center border-2 mx-auto w-9/12">

                        <video width='240' height= '140' controls>
                            <source :src='"/storage/videos/" + episode.video'>
                        </video>
                        <div class="ml-8">
                            <router-link :to="'/episodes/' + episode.id" class="text-xl font-bold">{{ episode.title }}</router-link> <!-- NU STIU DACA MERGE -->
                            <p>{{ episode.description }}</p>
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
                episodes: []
            }
        },
        props: [
            'token'
        ],
        created(){
            this.fetchCourse()
        },
        methods:{
            fetchCourse(){
                let url = window.location.origin;
                url += `/api/courses/${this.$route.params.id}`;

                axios.get(url)
                .then(res => {
                    console.log(res.data);
                    this.course = res.data.course;
                    this.episodes = res.data.episodes.data;
                })
                .catch(err => console.log(err))
            }
        }
    }
</script>