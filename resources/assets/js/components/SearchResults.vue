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

<style lang="scss" scoped>
.card {
	position: relative;
	width: inherit;
	height: 300px;
	margin: 0 auto;
	border-radius: 25px;
	box-shadow: 3px 3px 6px 0px #ececec;
	border: none;

	.card-img-top {
		background: #399ACC;
		width: 100%;
		height: 170px;
		border-top-left-radius: 25px;
		border-top-right-radius: 25px;
	}

	.card-body {
		.card-title {
			font-size: 16px;
			font-weight: bold;
			margin-top: 25px;
			margin-bottom: 0;
		}

		.creator {
			font-size: 14px;
			font-weight: 300;
			font-style: italic;
			color: #929292;
			margin-bottom: 15px;

			a {
				color: #399ACC;

				&:hover {
					text-decoration: none;
				}
			}
		}
	}

	.view-count {
		max-width: 80px;
		padding: 5px;
		border-radius: 10px;
		background-color: #ce4d4d;
		position: absolute;
		top: 10px;
		left: 10px;
		color: white;
		text-align: center;
		font-size: 12px;
		pointer-events: none;
	}

	.clip-date {
		max-width: 150px;
		padding: 5px;
		border-radius: 10px;
		background-color: rgba(0, 0, 0, 0.5);
		position: absolute;
		top: 10px;
		right: 10px;
		color: white;
		text-align: center;
		font-size: 12px;
		pointer-events: none;
	}

	.avatar {
		background: #399ACC;
		background-repeat: no-repeat;
		background-position: center center;
		background-size: contain;
		width: 75px;
		height: 75px;
		border-radius: 50%;
		border: 3px solid white;
		position: absolute;
		top: 131px;
		left: 15px;
		//transform: translateX(-50%);
		pointer-events: none;
	}

	.duration {
		width: 100px;
		padding: 5px;
		background-color: rgba(0, 0, 0, 0.5);
		position: absolute;
		bottom: 257px;
		right: 0;
		color: white;
		text-align: center;
		font-size: 12px;
		pointer-events: none;
	}

	.broadcaster {
		position: absolute;
		top: 140px;
		left: 100px;
		color: white;
		font-weight: bold;
		font-size: 18px;
		pointer-events: none;
	}
}

</style>
