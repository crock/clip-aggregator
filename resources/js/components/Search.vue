<template>
  <div class="search-bar">
    <input
      v-model="keywords"
      class="text-center"
      type="text"
      placeholder="Search for clips..."
      aria-label="Search"
      @keyup="doSearch"
    >
    <ul
      v-if="results.length > 0 && keywords.length > 0"
      class="list-reset"
    >
      <li
        v-for="result in results"
        :key="result.id"
      >
        <a
          class="block hover:bg-grey-lighter hover:no-underline cursor-pointer p-2"
          :href="'/clip/' + result.twitch_clip_id"
        >
          <!-- eslint-disable-next-line -->
					<div class="text-black font-bold text-lg" v-html="highlight(result.title)"></div>
          <div
            class="text-grey-darker font-light text-sm"
            v-text="result.broadcaster_name"
          />
        </a>
      </li>
      <li>
        <a
          :href="searchUrl"
          class="block hover:bg-grey-lighter text-blue hover:text-blue-dark hover:no-underline cursor-pointer p-2"
        >Show All Results...</a>
      </li>
    </ul>
  </div>
</template>

<script>

export default {
	data() {
		return {
			keywords: null,
			results: []
		}
	},
	computed: {
		searchUrl() {
			return '/search?q=' + this.keywords
		}
	},

	watch: {
		keywords() {
			this.fetch()
		}
	},
	methods: {
		fetch() {
			window.axios.get('/api/search', { params: { q: this.keywords } })
				.then(response => this.results = response.data)
				.catch(function (error) {
					console.error(error)
				})
		},
		highlight(text) {
			return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>')
		},
		doSearch(e) {
			if (e.keyCode === 13) {
				window.location = this.searchUrl
			}
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


