<template>
	<div class="search-bar">
		<input v-model="keywords" type="text" placeholder="Search for clips..." aria-label="Search">
        <ul class="list-reset" v-if="results.length > 0">
            <li v-for="result in results" :key="result.id">
				<a class="block hover:bg-grey-lighter hover:no-underline cursor-pointer p-2" :href="'/clip/' + result.twitch_clip_id">
					<!-- eslint-disable-next-line -->
					<div class="text-black font-bold text-lg" v-html="highlight(result.title)"></div>
					<div class="text-grey-darker font-light text-sm" v-text="result.broadcaster_name"></div>
				</a>
			</li>
        </ul>
    </div>
</template>

<script>
const _ = require('lodash');

export default {
	data() {
        return {
            keywords: null,
            results: []
        };
    },

    watch: {
        keywords() {
            this.fetch();
        }
    },

    methods: {
        fetch() {
            window.axios.get('/api/search', { params: { q: this.keywords } })
                .then(response => this.results = response.data)
                .catch(function (error) {
					console.error(error)
				});
		},
		highlight(text) {
			return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>');
		},
		doSearch() {
			_.debounce(function () {
				this.fetch()
			}, 300)
		}
    }
}
</script>

<style lang="scss" scoped>

</style>

