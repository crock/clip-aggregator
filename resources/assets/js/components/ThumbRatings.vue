<template>
  <div class="rating-group">
    <button type="submit" :class="likeClasses" @click="toggleLike">
      <svg width="145" height="90" xmlns="http://www.w3.org/2000/svg">
        <g fill-rule="nonzero" fill="none">
          <path
            d="M45 90C20.147 90 0 69.853 0 45S20.147 0 45 0h100v90H45z"
            fill="#9269B6"
            id="thumbs-up"
          ></path>
          <g fill="#FFF">
            <path
              d="M79 59h6V41h-6zM110.082 43.5c0-1.65-1.294-3-2.875-3h-9.07l1.365-6.855.043-.48c0-.615-.244-1.185-.632-1.59L97.389 30l-9.459 9.885A2.997 2.997 0 0 0 87.082 42v15c0 1.65 1.294 3 2.875 3h12.937c1.194 0 2.214-.75 2.645-1.83l4.342-10.575c.13-.345.201-.705.201-1.095v-2.865l-.014-.015.014-.12z"
            ></path>
          </g>
        </g>
      </svg>
    </button>

    <button type="submit" :class="dislikeClasses" @click="toggleDislike">
      <svg width="145" height="90" xmlns="http://www.w3.org/2000/svg">
        <g fill-rule="nonzero" fill="none">
          <path
            d="M100 0c24.853 0 45 20.147 45 45s-20.147 45-45 45H0V0h100z"
            fill="#9269B6"
            id="thumbs-down"
          ></path>
          <g fill="#FFF">
            <path
              d="M65 30h-6v18h6zM34 46.5c0 1.65 1.294 3 2.875 3h9.07l-1.365 6.855-.043.48c0 .615.244 1.185.632 1.59L46.693 60l9.459-9.885c.532-.54.848-1.29.848-2.115V33c0-1.65-1.294-3-2.875-3H41.187c-1.193 0-2.213.75-2.644 1.83L34.2 42.405c-.13.345-.201.705-.201 1.095v2.865l.014.015-.014.12z"
            ></path>
          </g>
        </g>
      </svg>
    </button>
  </div>
</template>

<script>
const axios = require("axios");

export default {
  props: {
    clip: {
      required: true,
      type: Object
    }
  },

  data() {
    return {
      likeCount: 33,
      disLikeCount: 7,
      isLiked: false,
      isDisliked: false
    };
  },

  computed: {
    likeClasses() {
      return ["thumbs", this.isLiked ? "liked" : ""];
    },
    dislikeClasses() {
      return ["thumbs", this.isDisliked ? "disliked" : ""];
    }
  },

  methods: {
    toggleLike() {
      if (this.isLiked) {
        axios.delete("/api/clips/" + this.clip.id + "/likes"); // create the endpoint
      } else {
        axios.post("/api/clips/" + this.clip.id + "/likes"); // create the endpoint
      }
    },
    toggleDislike() {
      if (this.isDisliked) {
        axios.delete("/api/clips/" + this.clip.id + "/dislikes"); // create the endpoint
      } else {
        axios.post("/api/clips/" + this.clip.id + "/dislikes"); // create the endpoint
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.rating-group {
  width: 295px;
  height: 92px;

  .thumbs {
    background: none;
    padding: 0;
    margin: 0;
    border: none;

    &:focus {
      outline: none;
    }

    &:hover {
      svg {
        pointer-events: visiblefill;

        #thumbs-up,
        #thumbs-down {
          fill: #6c3c76;
          cursor: pointer;
        }
      }
    }
  }

  .liked {
    svg {
      #thumbs-up {
        fill: #2c882c;
      }
    }
  }

  .disliked {
    svg {
      #thumbs-down {
        fill: #852d2d;
      }
    }
  }
}
</style>
