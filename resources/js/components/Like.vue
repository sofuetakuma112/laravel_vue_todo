<template>
  <div>
    <button v-if="!liked" type="submit" class="btn btn-primary" @click="like(postId)">いいね{{likeCount}}</button>
    <button v-else type="submit" class="btn btn-primary" @click="unlike(postId)">いいね{{likeCount}}</button>
  </div>
</template>

<script>
export default {
  props: ["postId", "userId", 'defaultLiked', 'defaultCount'],
  data() {
    return {
      liked: false,
      likeCount: 0
    }
  },
  created() {
    // 現在ログインしているアカウントで既にいいねを押しているか
    this.liked = this.defaultLiked
    // 現在見ている記事のトータルのいいね数
    this.likeCount = this.defaultCount
  },
  methods: {
    like(postId) {
      // ${}はテンプレートリテラル
      let url = `/api/posts/${postId}/like`;

      axios
        .post(url, {
          user_id: this.userId,
        })
        .then((response) => {
          this.liked = true
          // いいねボタンを押した後の最新のいいね数を取得
          this.likeCount = response.data.likeCount
        })
        .catch((error) => {
          alert(error);
        });
    },
    unlike(postId) {
      // ${}はテンプレートリテラル
      let url = `/api/posts/${postId}/unlike`;

      axios
        .post(url, {
          user_id: this.userId,
        })
        .then((response) => {
          this.liked = false
          this.likeCount = response.data.likeCount
        })
        .catch((error) => {
          alert(error);
        });
    },
  },
};
</script>
