<template>
  <div>
    <h1>Register</h1>
    <form @submit.prevent="register">
      <div>
        <label for="name">Name:</label>
        <input id="name" v-model="form.name" required />
      </div>
      <div>
        <label for="email">Email:</label>
        <input id="email" type="email" v-model="form.email" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input id="password" type="password" v-model="form.password" required />
      </div>
      <div>
        <label for="password_confirmation">Confirm Password:</label>
        <input id="password_confirmation" type="password" v-model="form.password_confirmation" required />
      </div>
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Register',
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
    };
  },
  methods: {
    register() {
      axios.post('/register', this.form)
        .then(() => {
          this.$router.push({ name: 'Login' });
        })
        .catch(error => {
          console.error('Registration failed:', error);
        });
    },
  },
};
</script>

<style scoped>
form div {
  margin-bottom: 10px;
}
</style>
