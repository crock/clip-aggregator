<template>
    <div class="row justify-content-center">
        <div class="col" v-bind:key="obj.id" v-for="obj in fclips">
            <div class="card">
                <a :href="'/clip/' + obj.id"><img class="card-img-top" :src="obj.thumbnail_url" :alt="obj.title"></a>
                <div class="card-body">
                    <h5 class="card-title">{{ obj.broadcaster_name }}</h5>
                    <p class="card-text">{{ obj.title }}</p>
					<p class="card-text">{{ obj.created_at }}</p>
                </div>

                <span class="view-count">{{ obj.view_count }}</span>
                <span class="avatar" style="'background: url(http://placehold.it/250x250) no-repeat center center'"></span>
                <!-- <span class="duration">{{ obj.duration }}s</span> -->

                <div class="card-footer">
                    <!-- <a v-if="obj.vod != null" :href="obj.vod != null ? obj.vod.url : '#!'" class="card-link">VOD</a> -->
                    <a :href="'https://twitch.tv/' + obj.broadcaster_name" class="card-link">Channel</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
		props: {
			game: {
				type: String,
				default: 'fortnite'
			}
		},
        data() {
            return {
				fclips: []
            }
        },
        methods: {
            getTopClips: function () {
                let clips = []
                window.axios.get('/api/clips/top' + `?game=${this.game}`)
                    .then(function (response) {
                        console.log(response)
                        response.data.data.forEach(function (clip) {
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
