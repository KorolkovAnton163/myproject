<template>
    <div class="page-container posts-page-container">
        <div class="posts-container" v-if="posts">
            <div class="post" v-for="post in posts">
                <h2>
                    <router-link class="ripple" :to="{name:'post', params: {id: post.id}}">{{ post.title }}</router-link>
                </h2>
                <div class="description-container">
                    <div class="image-block">
                        <img src="/images/header.jpg" alt="image">
                        <router-link class="read-more ripple" :to="{name:'post', params: {id: post.id}}">show</router-link>
                    </div>
                    <div class="additional-block">
                        <div class="description-block">
                            <p><strong>info1:</strong> info 1</p>
                            <p><strong>info2:</strong> info 2</p>
                            <p><strong>info3:</strong> info 3</p>
                            <p><strong>Description:</strong> {{ post.body }}</p>
                        </div>
                        <div class="action-block">
                            <bookmark :id="post.id"></bookmark>
                        </div>
                    </div>
                </div>
            </div>
            <pagination :params="params" :callback="getPosts"></pagination>
        </div>
        <div class="posts-container page-not-found" v-else>
            <cat></cat>
            <p>No results</p>
        </div>
        <filters></filters>
    </div>
</template>
<script>
  module.exports = {
      data () {
          return {
              posts: [],
              params: {
                  total: 0,
                  on_page: 10,
                  current_page: 1,
                  url_params: 'posts'
              }
          }
      },
      mounted () {
          this.$root.$on('search', (query) => {
              // console.log('search: ' + query);
          });
          this.$root.$on('filters', (tags) => {
              // console.log(tags);
          });
      },
      components: {
          cat: require('../blocks/Cat.vue'),
          pagination: require('../blocks/Pagination.vue'),
          bookmark: require('../blocks/Bookmark.vue'),
          filters: require('../blocks/Filters.vue')
      },
      computed: {
          resource () {
              return this.$resource('https://jsonplaceholder.typicode.com/posts{?_start}{&_limit}');
          }
      },
      methods: {
          getPosts () {
              let page = this.$route.query.page ? this.$route.query.page : this.params.current_page,
                  start = (page - 1) * this.params.on_page;

              this.params.current_page = parseInt(page);

              this.resource.get({ _start: start, _limit: this.params.on_page }).then((responce) => {
                  this.posts = responce.data.length ? responce.data : null;
                  this.params.total = parseInt(responce.headers.map['x-total-count'][0]);
              });
          }
      }
  }
</script>