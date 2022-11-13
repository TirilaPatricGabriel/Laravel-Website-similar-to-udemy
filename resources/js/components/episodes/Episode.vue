<template>
    <div class="w-screen flex items-center justify-center bg-[#408ec6] text-white">
        <div class="flex flex-row items-center justify-evenly pt-10 border-2 w-8/12 h-96 rounded-md bg-[#6883bc] border-2" v-for="episode in episode" :key="episode.id">
            <video width="440" height="220" controls>
                <source :src='"/storage/videos/" + episode.video'>
            </video>
            <div class="flex flex-col items-center">
                <h2 class="text-xl font-bold">{{episode.title}}</h2>
                <p>{{episode.description}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                episode_id: null,
                episode: [],
            }
        },
        created(){
            this.episode_id = this.$route.params.id;
            this.fetchEpisode();
        },
        methods: {
            fetchEpisode(){
                let url = window.location.origin
                url += `/api/episodes/${this.episode_id}`
                axios.get(url)
                .then(res => {
                    this.episode = res.data.episode
                    console.log(res.data);    
                })
                .catch(err => console.log(err))
            }
        }
    }
</script>