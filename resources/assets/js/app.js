/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('featured-clip', require('./components/FeaturedClip.vue'))
Vue.component('comments-manager', require('./components/CommentsManager.vue'))
Vue.component('search', require('./components/Search.vue'))
Vue.component('search-results', require('./components/SearchResults.vue'))
Vue.component('front-page', require('./components/FrontPage.vue'))
//Vue.component('thumb-ratings', require('./components/ThumbRatings.vue'))

const app = new Vue({
	el: '#app',
	data: {
		errors: [],
		url: null
	},
	methods: {
		checkForm: function(e) {
			this.errors = []

			if (!this.url) {
				this.errors.push('A valid url is required.')
			} else if (!this.validClipUrl(this.url)) {
				this.errors.push('This is not a valid Twitch clip url.')
			}

			if (!this.errors.length) {
				return true
			}

			e.preventDefault()
		},
		validClipUrl: function(url) {
			var re1 = /^https?:\/\/www\.twitch\.tv\/[a-zA-Z0-9_]+\/clip\/([a-zA-Z0-9]+)/
			var re2 = /^https?:\/\/clips\.twitch\.tv\/([a-zA-Z0-9]+)/

			return re1.test(url) || re2.test(url)
		}
	}
})

module.exports = app
