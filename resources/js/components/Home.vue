<template>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="card shadow p-3 mb-2 bg-body rounded">
            <div class="card-body d-flex">
              <img
                :src="user.profile.profile_picture"
                class="user-profile mr-2"
              />
              <button
                type="button"
                class="btn btn-block text-left post-button"
                data-bs-toggle="modal"
                data-bs-target="#postModal"
              >
                What's on your mind, {{ user.first_name }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <template>
        <div
          class="modal fade"
          id="postModal"
          tabindex="-1"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
          ref="modal"
        >
          <div
            class="modal-dialog modal-dialog-centered modal-fullscreen-md-down"
          >
            <form @submit.prevent="submitPost">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    Create Post
                  </h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <label>Title</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Title"
                        v-model="post_form.title"
                        :class="{ 'is-invalid': error.hasOwnProperty('title') }"
                      />
                      <label
                        class="text-danger"
                        v-if="error.hasOwnProperty('title')"
                        >{{ error.title[0] }}</label
                      >
                    </div>
                    <div class="col-md-12">
                      <label>Text</label>
                      <textarea
                        class="form-control"
                        cols="30"
                        rows="5"
                        :placeholder="`What's on your mind, ${user.first_name}?`"
                        v-model="post_form.text"
                        :class="{ 'is-invalid': error.hasOwnProperty('text') }"
                      ></textarea>
                      <label
                        class="text-danger"
                        v-if="error.hasOwnProperty('text')"
                        >{{ error.title[0] }}</label
                      >
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-block">
                    Post
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </template>

      <div class="row">
        <div class="col-md-12 my-2" v-for="post in posts" :key="post.id">
          <div class="card shadow p-3 mb-1 bg-body rounded">
            <div class="card-body d-flex align-items-start">
              <img
                :src="post.user.profile.profile_picture"
                class="post-profile mr-2"
              />
              <div class="w-100">
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="d-flex align-items-center">
                      <a
                        :href="`users/${post.user.id}/profile`"
                        class="text-black"
                        ><h6 class="m-0">
                          <b>{{ post.user.name }}</b>
                        </h6></a
                      >
                    </div>
                    <label class="created-at">
                      {{ moment(post.created_at).fromNow() }}
                    </label>
                  </div>
                  <template v-if="user.id === post.user.id">
                    <div>
                      <div class="dropdown">
                        <a
                          class="btn dropdown-toggle btn-sm post-button"
                          href="#"
                          role="button"
                          id="dropdownMenuLink"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                        </a>

                        <ul
                          class="dropdown-menu"
                          aria-labelledby="dropdownMenuLink"
                        >
                          <li>
                            <a class="dropdown-item" @click="selectPost(post)"
                              >Edit Post</a
                            >
                          </li>
                          <li>
                            <a class="dropdown-item" @click="deletePost(post)"
                              >Delete Post</a
                            >
                          </li>
                        </ul>
                      </div>
                    </div>
                  </template>
                </div>

                <!-- Edit Post -->
                <div
                  v-if="
                    selected_post.hasOwnProperty('id') &&
                    selected_post.id === post.id
                  "
                >
                  <form @submit.prevent="editPost(post)">
                    <div class="row">
                      <div class="col-md-12">
                        <label>Title</label>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Title"
                          v-model="selected_post.title"
                          :class="{
                            'is-invalid': post_error.hasOwnProperty('title'),
                          }"
                        />
                        <label
                          class="text-danger"
                          v-if="post_error.hasOwnProperty('title')"
                          >{{ post_error.title[0] }}</label
                        >
                      </div>
                      <div class="col-md-12">
                        <label>Text</label>
                        <textarea
                          class="form-control"
                          cols="30"
                          rows="5"
                          :placeholder="`What's on your mind, ${user.first_name}?`"
                          v-model="selected_post.text"
                          :class="{
                            'is-invalid': post_error.hasOwnProperty('text'),
                          }"
                        ></textarea>
                        <label
                          class="text-danger"
                          v-if="post_error.hasOwnProperty('text')"
                          >{{ post_error.text[0] }}</label
                        >
                      </div>
                      <div class="col-md-12 mt-3">
                        <button class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- Edit Post -->

                <!-- POST -->
                <template v-else>
                  <h6 class="m-0">{{ post.title }}</h6>
                  <hr class="my-1" />
                  <p>{{ post.text }}</p>
                </template>
                <!-- POST -->

                <div class="d-flex justify-content-end">
                  <label>{{ post.comments.length }} Comments</label>
                </div>
                <hr />
                <div
                  v-for="comment in post.comments"
                  :key="comment.id"
                  class="mx-5 px-3 py-2 d-flex align-items-start"
                >
                  <img
                    :src="comment.user.profile.profile_picture"
                    class="post-profile mr-2"
                  />
                  <div class="comment-section px-3 py-1 w-100">
                    <div class="d-flex justify-content-between">
                      <div>
                        <div class="d-flex align-items-center">
                          <a
                            :href="`users/${comment.user.id}/profile`"
                            class="text-black"
                          >
                            <h6 class="m-0">
                              <b>{{ comment.user.name }}</b>
                            </h6>
                          </a>
                        </div>
                        <label class="created-at">
                          {{ moment(comment.created_at).fromNow() }}
                        </label>
                      </div>
                      <div v-if="user.id === comment.user.id">
                        <div class="dropdown">
                          <a
                            class="btn dropdown-toggle btn-sm post-button"
                            href="#"
                            role="button"
                            id="dropdownMenuLink"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                          >
                          </a>

                          <ul
                            class="dropdown-menu"
                            aria-labelledby="dropdownMenuLink"
                          >
                            <li>
                              <a
                                class="dropdown-item"
                                @click="selectComment(comment)"
                                >Edit Comment</a
                              >
                            </li>
                            <li>
                              <a
                                class="dropdown-item"
                                @click="deleteComment(comment)"
                                >Delete Comment</a
                              >
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <form
                      v-if="
                        selected_comment.hasOwnProperty('id') &&
                        selected_comment.id === comment.id
                      "
                      @submit.prevent="editComment"
                    >
                      <div class="input-group mb-3">
                        <input
                          type="text"
                          class="form-control custom-input"
                          placeholder="Write a comment..."
                          v-model="selected_comment.text"
                        />
                        <button
                          class="btn btn-primary btn-sm custom-input"
                          type="submit"
                        >
                          Submit
                        </button>
                        <button
                          class="btn btn-secondary btn-sm custom-input"
                          type="button"
                          @click="selected_comment = {}"
                        >
                          Cancel
                        </button>
                      </div>
                    </form>
                    <label v-else>{{ comment.text }}</label>
                  </div>
                </div>
                <form
                  @submit.prevent="submitComment(post, comment_form[post.id])"
                >
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      class="form-control custom-input"
                      placeholder="Write a comment..."
                      v-model="comment_form[post.id]"
                    />

                    <button
                      class="btn btn-primary btn-sm custom-input"
                      type="submit"
                    >
                      Submit
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      typeof: Object,
      require: true,
    },
  },
  data() {
    return {
      posts: [],
      selected_post: {},
      post_form: {},
      comment_form: [],
      selected_comment: {},
      error: {},
      post_error: {},
      comment_error: {},
      edit_comment_error: {},
    };
  },
  mounted() {
    this.getPosts();
  },
  methods: {
    getPosts() {
      this.$http.get(`api/users-post`).then((response) => {
        this.posts = response.data;
      });
    },
    submitPost() {
      this.$http
        .post(`api/users/${this.user.id}/posts`, this.post_form)
        .then((response) => {
          this.getPosts();
          Swal.fire("Success", response.data.message, "success");
          this.post_form = {};
          this.error = {};
          $("#postModal").modal("hide");
        })
        .catch((error) => {
          Swal.fire("Post error", error.response.data.message, "error");
          this.error = error.response.data.errors;
        });
    },

    selectPost(post) {
      this.post_error = {};
      this.selected_post = JSON.parse(JSON.stringify(post));
    },

    editPost(post) {
      this.$http
        .put(`api/posts/${post.id}`, this.selected_post)
        .then((response) => {
          Swal.fire("Edit post", response.data.message, "success");
          this.getPosts();
          this.selected_post = {};
          this.post_error = {};
        })
        .catch((error) => {
          Swal.fire("Post error", error.response.data.message, "error");
          this.post_error = error.response.data.errors;
        });
    },

    deletePost(comment) {
      Swal.fire({
        text: "Are you sure you want to delete this post?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$http.delete(`api/posts/${comment.id}`).then((response) => {
            Swal.fire("Delete post", response.data.message, "success");
            this.getPosts();
          });
        }
      });
    },
    submitComment(post, comment) {
      var form = {};
      form.text = comment;
      this.$http
        .post(`api/users/${this.user.id}/posts/${post.id}/comments`, form)
        .then((response) => {
          Swal.fire("Store Comment", response.data.message, "success");
          this.comment_form = [];
          this.getPosts();
        })
        .catch((error) => {
          Swal.fire("Store Comment", error.response.data.message, "error");
          this.comment_error = error.response.data.errors;
          console.log(this.comment_error);
        });
    },

    selectComment(comment) {
      this.selected_comment = JSON.parse(JSON.stringify(comment));
    },

    editComment() {
      if (this.selected_comment.text === "") {
        return this.deleteComment(this.selected_comment);
      } else {
        this.$http
          .put(
            `api/comments/${this.selected_comment.id}`,
            this.selected_comment
          )
          .then((response) => {
            Swal.fire("Edit Comment", response.data.message, "success");
            this.getPosts();
            this.selected_comment = {};
          });
      }
    },
    deleteComment(comment) {
      Swal.fire({
        text: "Are you sure you want to delete this comment?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$http.delete(`api/comments/${comment.id}`).then((response) => {
            Swal.fire("Delete Comment", response.data.message, "success");
            this.getPosts();
          });
        }
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.user-profile {
  width: 40px;
  height: 40px;
  border-radius: 100%;
  border: 1px solid #b6babe;
}

.post-button {
  background: #f0f2f5;
  border-radius: 20px;
}

.post-profile {
  width: 30px;
  height: 30px;
  border-radius: 100%;
  border: 1px solid #b6babe;
}

.dropdown-item {
  cursor: pointer;
}

.created-at {
  font-size: 14px;
}

.card {
  border-radius: 10px;
}

.comment-section {
  background: #f0f2f5;
  border-radius: 20px;
}

.text-black {
  color: black;
}

.btn-close {
  background-color: #e4e6eb;
  opacity: 1;
  border-radius: 20px;
}

.custom-input {
  border-radius: 20px !important;
}
</style>