<template>
	<div class="search-bar">
		<input class="text-center" v-model="keywords" type="text" placeholder="Search for clips..." aria-label="Search">
        <ul class="list-reset" v-if="results.length > 0 && keywords.length > 0">
            <li v-for="result in results" :key="result.id">
				<a class="block hover:bg-grey-lighter hover:no-underline cursor-pointer p-2" :href="'/clip/' + result.twitch_clip_id">
					<!-- eslint-disable-next-line -->
					<div class="text-black font-bold text-lg" v-html="highlight(result.title)"></div>
					<div class="text-grey-darker font-light text-sm" v-text="result.broadcaster_name"></div>
				</a>
			</li>
			<li>
				<a :href="'/search?q=' + keywords" class="block hover:bg-grey-lighter text-blue hover:text-blue-dark hover:no-underline cursor-pointer p-2">Show All Results...</a>
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

<style>
::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  text-align: center;
}
::-moz-placeholder { /* Firefox 19+ */
  text-align: center;
}
:-ms-input-placeholder { /* IE 10+ */
  text-align: center;
}
:-moz-placeholder { /* Firefox 18- */
  text-align: center;
}
</style>


