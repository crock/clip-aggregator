<template>
  <div class="max-w-3xl mx-auto">
    <div class="mb-4">
      <h2 class="text-black">
        Comments
      </h2>
    </div>
    <div
      v-show="user != null"
      class="bg-white rounded shadow-sm p-8 mb-4"
    >
      <textarea
        v-model="data.body"
        placeholder="Add a comment"
        class="bg-grey-lighter rounded leading-normal resize-none w-full py-2 px-3"
        :class="[state === 'editing' ? 'h-24' : 'h-10']"
        @focus="startEditing"
      />
      <div
        v-show="state === 'editing'"
        class="mt-3"
      >
        <button
          class="border border-blue bg-blue text-white hover:bg-blue-dark py-2 px-4 rounded tracking-wide mr-1"
          @click="saveComment"
        >
          Save
        </button>
        <button
          class="border border-grey-darker text-grey-darker hover:bg-grey-dark hover:text-white py-2 px-4 rounded tracking-wide ml-1"
          @click="stopEditing"
        >
          Cancel
        </button>
      </div>
    </div>
    <div
      class="bg-white rounded shadow-sm p-8"
      :class="{ invisible: !hasComments }"
    >
      <comment
        v-for="comment in comments"
        :key="comment.id"
        :user="user"
        :comment="comment"
        @comment-updated="updateComment($event)"
        @comment-deleted="deleteComment($event)"
      />
    </div>
  </div>
</template>

<script>
import comment from './CommentItem'

export default {
	components: {
		comment
	},
	props: {
		user: {
			default: null,
			required: false,
			type: Object
		},
		clip: {
			default: null,
			required: false,
			type: Object
		}
	},
	data: function() {
		return {
			state: 'default',
			data: {
				body: '',
				user_id: this.user.id,
				clip_id: this.clip.id
			},
			comments: []
		}
	},
	computed: {
		hasComments() {
			return this.comments.length > 0
		}
	},
	created() {
		this.fetchComments()
	},
	methods: {
		startEditing() {
			this.state = 'editing'
		},
		stopEditing() {
			this.state = 'default'
			this.data.body = ''
		},
		updateComment($event) {
			const t = this

			window.axios.put(`/comments/${$event.id}`, $event).then(({ data }) => {
				t.comments[t.commentIndex($event.id)].body = data.body
			})
		},
		deleteComment($event) {
			const t = this

			window.axios.delete(`/comments/${$event.id}`, $event).then(() => {
				t.comments.splice(t.commentIndex($event.id), 1)
			})
		},
		saveComment() {
			const t = this

			window.axios.post('/comments', t.data).then(({ data }) => {
				t.comments.unshift(data)

				t.stopEditing()
			})
		},
		fetchComments() {
			const t = this

			window.axios.get(`/comments/${t.clip.id}`).then(({ data }) => {
				t.comments = data
			})
		},
		commentIndex(commentId) {
			return this.comments.findIndex(element => {
				return element.id === commentId
			})
		}
	}
}
</script>
