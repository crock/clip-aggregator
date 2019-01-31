<template>
    <div class="row justify-content-center">
        <div class="col" v-bind:key="obj.tracking_id" v-for="obj in fclips">
            <div class="card">
                <a :href="'/e/clip/' + obj.slug"><img class="card-img-top" :src="obj.thumbnails.medium" :alt="obj.title"></a>
                <div class="card-body">
                    <h5 class="card-title">{{ obj.broadcaster.display_name }}</h5>
                    <p class="card-text">{{ obj.title }}</p>
                    <p class="card-text">{{ obj.created_at }}</p>
                </div>

                <span class="view-count">{{ obj.views }}</span>
                <span class="avatar" :style="'background: url(' + obj.broadcaster.logo +') no-repeat center center'"></span>
                <span class="duration">{{ obj.duration }}s</span>

                <div class="card-footer">
                    <a v-if="obj.vod != null" :href="obj.vod != null ? obj.vod.url : '#!'" class="card-link">VOD</a>
                    <a :href="obj.broadcaster.channel_url" class="card-link">Channel</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fclips: []
            }
        },
        methods: {
            getTopClips: function () {
                let clips = []
                window.axios.get('/api/clips/top')
                    .then(function (response) {
                        console.log(response)
                        response.data.clips.forEach(function (clip) {
                            console.log(clip.tracking_id)
                            clips.push(clip)
                        });
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                this.fclips = clips

            }
        },
        created() {
            this.getTopClips()
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
