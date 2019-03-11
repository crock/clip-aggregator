<template>
    <div class="row justify-content-center">
        <div class="col" :key="obj.id" v-for="obj in clips">
            <div class="card">
                <a :href="'/clip/' + obj.twitch_clip_id"><img class="card-img-top" :src="obj.thumbnail_url" :alt="obj.title"></a>
                <div class="card-body">
                    <h5 class="card-title">{{ obj.title }}</h5>
					<div v-if="users" class="creator">Clipped by <a :href="channel(obj.creator_id)">{{ obj.creator_name }}</a></div>
                </div>

                <span class="view-count">{{ obj.view_count }}</span>
				<span class="clip-date">{{ date(obj.clip_created_date) }}</span>
                <span v-if="users" class="avatar" :style="'background-image: url(' + avatar(obj.broadcaster_id) + ')'"></span>
				<span class="broadcaster">{{ obj.broadcaster_name }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
		props: {
			query: {
				type: String,
				default: ''
			}
		},
        data() {
            return {
				clips: null,
				users: null,
				paging: {
					currentPage: 1,
					total: 0,
					prevPageUrl: null,
					nextPageUrl: null,
					perPage: 15,
					lastPage: null
				}
            }
        },
        methods: {
            async getClips() {
				try {
					const response = await window.axios.get(`/api/search/results?q=${this.query}`)
					this.clips = response.data.data
					this.paging.currentPage = response.data.current_page
					this.paging.total = response.data.total
					this.paging.prevPageUrl = response.data.prev_page_url
					this.paging.nextPageUrl = response.data.next_page_url
					this.paging.firstPageUrl = response.data.first_page_url
					this.paging.perPage = response.data.per_page
					this.paging.lastPage = response.data.last_page

					this.getUsers()
				} catch (e) {
					console.error(e);
				}
			},
			async getUsers() {
				try {
					const response = await window.axios.get('/api/users/twitch' + this.idqs);
					this.users = response.data.data
				} catch (e) {
					console.error(e);
				}
			},
			avatar(id) {
				return this.userInfo[id][1]
			},
			channel(id) {
				return `https://www.twitch.tv/${this.userInfo[id][0]}`
			},
			date(createdDate) {
				return window.moment.utc(createdDate).fromNow()
			}
		},
		computed: {
			idqs: function () {
				let idList = []
				this.clips.forEach(function (clip) {
					idList.push(clip.broadcaster_id)
					idList.push(clip.creator_id)
				})
				return `?id=${idList.join()}`
			},
			userInfo: function () {

				return this.users.reduce(function(r, a) {
					r[a.id] = r[a.id] || [];
					r[a.id].push(a.login, a.profile_image_url)
					return r;
				}, {})

			}
		},
        created() {
			this.getClips()
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
