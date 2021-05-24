<template>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form @submit.prevent="register">
        <div class="row">
          <div class="col-md-12">
            <div class="d-flex justify-content-center">
              <img id="output" :class="{ 'profile-style': uploaded_image }" />
            </div>
            <br />
            <label>Profile Picture</label>
            <input
              id="bill-image"
              type="file"
              accept="image/*"
              class="form-control input-image-style"
              placeholder="Bill reading image"
              @change="uploadImage($event)"
              :class="{ 'is-invalid': error.hasOwnProperty('profile_picture') }"
            />
            <label
              class="text-danger"
              v-if="error.hasOwnProperty('profile_picture')"
              >{{ error.profile_picture[0] }}</label
            >
          </div>
          <div class="col-md-12">
            <label>Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Name"
              v-model="form.name"
              :class="{ 'is-invalid': error.hasOwnProperty('name') }"
            />
            <label class="text-danger" v-if="error.hasOwnProperty('name')">{{
              error.name[0]
            }}</label>
          </div>
          <div class="col-md-12">
            <label>Email address</label>
            <input
              type="email"
              class="form-control"
              placeholder="Email address"
              v-model="form.email"
              :class="{ 'is-invalid': error.hasOwnProperty('email') }"
            />
            <label class="text-danger" v-if="error.hasOwnProperty('email')">{{
              error.email[0]
            }}</label>
          </div>
          <div class="col-md-12">
            <label>Password</label>
            <input
              type="password"
              class="form-control"
              placeholder="Password"
              v-model="form.password"
              :class="{ 'is-invalid': error.hasOwnProperty('password') }"
            />
            <label
              class="text-danger"
              v-if="error.hasOwnProperty('password')"
              >{{ error.password[0] }}</label
            >
          </div>
          <div class="col-md-12">
            <label>Confirm Password</label>
            <input
              type="password"
              class="form-control"
              placeholder="Confirm Password"
              v-model="form.password_confirmation"
            />
          </div>
          <div class="col-md-12 border-bottom mt-5">
            <h1>Profile</h1>
          </div>
          <div class="col-md-12">
            <label>Phone number</label>
            <input
              type="text"
              class="form-control"
              placeholder="Phone number"
              v-model="form.phone_number"
              :class="{ 'is-invalid': error.hasOwnProperty('phone_number') }"
            />
            <label
              class="text-danger"
              v-if="error.hasOwnProperty('phone_number')"
              >{{ error.phone_number[0] }}</label
            >
          </div>
          <div class="col-md-12">
            <label>Mobile Number</label>
            <input
              type="text"
              class="form-control"
              placeholder="Mobile Number"
              v-model="form.mobile_number"
              :class="{ 'is-invalid': error.hasOwnProperty('mobile_number') }"
            />
            <label
              class="text-danger"
              v-if="error.hasOwnProperty('mobile_number')"
              >{{ error.mobile_number[0] }}</label
            >
          </div>
          <div class="col-md-12">
            <label>Address</label>
            <textarea
              class="form-control"
              placeholder="Address"
              id=""
              cols="30"
              rows="10"
              v-model="form.address"
              :class="{ 'is-invalid': error.hasOwnProperty('address') }"
            ></textarea>
            <label class="text-danger" v-if="error.hasOwnProperty('address')">{{
              error.address[0]
            }}</label>
          </div>
          <div class="col-md-12">
            <label>City</label>
            <input
              type="text"
              class="form-control"
              placeholder="City"
              v-model="form.city"
              :class="{ 'is-invalid': error.hasOwnProperty('city') }"
            />
            <label class="text-danger" v-if="error.hasOwnProperty('city')">{{
              error.city[0]
            }}</label>
          </div>
          <div class="col-md-12">
            <label>State</label>
            <input
              type="text"
              class="form-control"
              placeholder="State"
              v-model="form.state"
              :class="{ 'is-invalid': error.hasOwnProperty('state') }"
            />
            <label class="text-danger" v-if="error.hasOwnProperty('state')">{{
              error.state[0]
            }}</label>
          </div>
          <div class="col-md-12">
            <label>Zip Code</label>
            <input
              type="text"
              class="form-control"
              placeholder="Zip Code"
              v-model="form.zip_code"
              :class="{ 'is-invalid': error.hasOwnProperty('zip_code') }"
            />
            <label
              class="text-danger"
              v-if="error.hasOwnProperty('zip_code')"
              >{{ error.zip_code[0] }}</label
            >
          </div>

          <div class="col-md-12 my-3">
            <button class="btn btn-primary">Register</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {},
      uploaded_image: false,
      error: {},
    };
  },
  methods: {
    register() {
      var data = new FormData();
      Object.keys(this.form).forEach((key) => {
        data.append(key, this.form[key]);
      });
      this.$http
        .post(`api/users`, data)
        .then((response) => {
          Swal.fire("Success", response.data.message, "success").then(() => {
            window.location.href = "/login";
          });
          this.form = {};
          this.error = {};
          this.uploaded_image = false;
          document.getElementById("output").removeAttribute("src");
        })
        .catch((error) => {
          Swal.fire("Error", error.response.data.message, "error");
          this.error = error.response.data.errors;
        });
    },
    uploadImage(e) {
      this.form.profile_picture = e.target.files[0];
      this.uploaded_image = true;
      var output = document.getElementById("output");
      output.src = window.URL.createObjectURL(e.target.files[0]);
    },
  },
};
</script>

<style lang="scss" scoped>
.profile-style {
  width: 200px;
  height: 200px;
  border-radius: 100%;
  border: 2px solid #b6babe;
}
</style>