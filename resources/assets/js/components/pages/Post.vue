<template>
  <div class="page-container single-post-page-container" v-if="post">
    <h2>{{ post.title }}</h2>
    <div class="description-container">
      <div class="image">
        <img src="/images/header.jpg" alt="image">
      </div>
      <div class="description">
        <p><strong>info1:</strong> info 1</p>
        <p><strong>info2:</strong> info 2</p>
        <p><strong>info3:</strong> info 3</p>
        <p><strong>Description:</strong> {{ post.body }}</p>
      </div>
    </div>
    <bookmark :id="post.id"></bookmark>
  </div>
  <div class="page-not-found" v-else>
    <cat></cat>
    <p>Post not found</p>  
  </div>
</template>

<script>
module.exports = {
  data () {
    return {
      post: {}
    }
  },
  components: {
    cat: require('../blocks/Cat.vue'),
    bookmark: require('../blocks/Bookmark.vue')
  },
  computed: {
    resource () {
      return this.$resource('https://jsonplaceholder.typicode.com/posts{/id}');
    }
  },
  methods: {
    getSinglePost (postId) {
      this.resource.get({ id: postId }).then((responce) => {
          this.post = responce.data;
      }, (responce) => {
        let status = responce.status;
        if (404 == status) {
          this.post = null;
        }
      });
    }
  },
  created () {
    this.getSinglePost(this.$route.params.id);
  }
}
</script>