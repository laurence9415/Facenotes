<template>
  <div v-if="!edit_profile" class="row justify-content-center">
    <div class="col-md-12 text-right" v-if="user.id === active_user.id">
      <a @click="edit_profile = true" class="edit-button">Edit</a>
    </div>
    <div class="col-md-12 d-flex justify-content-center">
      <div class="text-center">
        <img
          :src="`${origin}/${active_user.profile.profile_picture}`"
          class="profile-picture"
        />
        <h1>
          <b>{{ active_user.name }}</b>
        </h1>
      </div>
    </div>
    <div class="col-md-8 d-flex">
      <table class="table">
        <tbody>
          <tr>
            <td><b>Email</b></td>
            <td>{{ active_user.email }}</td>
          </tr>
          <tr>
            <td><b>Phone Number</b></td>
            <td>{{ active_user.profile.phone_number }}</td>
          </tr>
          <tr>
            <td><b>Mobile Number</b></td>
            <td>{{ active_user.profile.mobile_number }}</td>
          </tr>
          <tr>
            <td><b>Address</b></td>
            <td>{{ active_user.profile.address }}</td>
          </tr>
          <tr>
            <td><b>City</b></td>
            <td>{{ active_user.profile.city }}</td>
          </tr>
          <tr>
            <td><b>State</b></td>
            <td>{{ active_user.profile.state }}</td>
          </tr>
          <tr>
            <td><b>Zip code</b></td>
            <td>{{ active_user.profile.zip_code }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div v-else>
    <form @submit.prevent="updateUser">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="col-md-12">
            <div class="d-flex justify-content-center">
              <img id="output" :class="{ 'profile-picture': upload_image }" />
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
              v-model="user.name"
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
              v-model="user.email"
              :class="{ 'is-invalid': error.hasOwnProperty('email') }"
            />
            <label class="text-danger" v-if="error.hasOwnProperty('email')">{{
              error.email[0]
            }}</label>
          </div>
          <div class="col-md-12 my-3">
            <div class="form-check form-switch">
              <input
                class="form-check-input"
                type="checkbox"
                id="flexSwitchCheckChecked"
                checked
                v-model="reset_password"
              />
              <label class="form-check-label" for="flexSwitchCheckChecked"
                >Would you like to reset your password?
                <b>{{ reset_password ? "Yes" : "No" }}</b></label
              >
            </div>
          </div>
          <template v-if="reset_password">
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
          </template>
          <div class="col-md-12 border-bottom mt-5">
            <h1>Profile</h1>
          </div>
          <div class="col-md-12">
            <label>Phone number</label>
            <input
              type="text"
              class="form-control"
              placeholder="Phone number"
              v-model="user.profile.phone_number"
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
              v-model="user.profile.mobile_number"
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
              v-model="user.profile.address"
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
              v-model="user.profile.city"
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
              v-model="user.profile.state"
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
              v-model="user.profile.zip_code"
              :class="{ 'is-invalid': error.hasOwnProperty('zip_code') }"
            />
            <label
              class="text-danger"
              v-if="error.hasOwnProperty('zip_code')"
              >{{ error.zip_code[0] }}</label
            >
          </div>

          <div class="col-md-12 my-3">
            <button
              class="btn btn-secondary"
              type="button"
              @click="edit_profile = false"
            >
              Cancel
            </button>
            <button class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      typeof: Object,
    },
    active_user: {
      typeof: Object,
    },
  },
  data() {
    return {
      origin: window.location.origin,
      edit_profile: false,
      upload_image: false,
      form: {},
      reset_password: false,
      error: {},
    };
  },
  mounted() {},
  methods: {
    updateUser() {
      this.form = {
        ...this.form,
        name: this.user.name,
        email: this.user.email,
        phone_number: this.user.profile.phone_number,
        mobile_number: this.user.profile.mobile_number,
        address: this.user.profile.address,
        city: this.user.profile.city,
        state: this.user.profile.state,
        zip_code: this.user.profile.zip_code,
      };

      if(!this.reset_password) {
        delete this.form.password
        delete this.form.password_confirmation
      }

      var form_data = new FormData();
      Object.keys(this.form).forEach((key) => {
        form_data.append(key, this.form[key]);
      });
      form_data.append("_method", "PATCH");

      this.$http
        .post(`${this.origin}/api/users/${this.user.id}`, form_data)
        .then((response) => {
          Swal.fire("Update user", response.data.message, "success").then(
            () => {
              window.location.reload();
            }
          );
        })
        .catch((error) => {
          Swal.fire("Update user", error.response.data.errors);
          this.error = error.response.data.errors;
        });
    },
    uploadImage(e) {
      this.form.profile_picture = e.target.files[0];
      this.upload_image = true;
      var output = document.getElementById("output");
      output.src = window.URL.createObjectURL(e.target.files[0]);
    },
  },
};
</script>

<style lang="scss" scoped>
.profile-picture {
  width: 200px;
  height: 200px;
  border-radius: 100%;
  border: 2px solid #b6babe;
}

.edit-button {
  cursor: pointer;
}
</style>