<template>
  <div>
    <h1>Login</h1>
    <form @submit.prevent="login">
      <div>
        <label for="email">Email:</label>
        <input id="email" type="email" v-model="form.email" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input id="password" type="password" v-model="form.password" required />
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
    };
  },
  methods: {
    login() {
      axios.post('/login', this.form)
        .then(response => {
          const token = response.data.access_token;
          localStorage.setItem('auth_token', token);
          axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
          this.$router.push({ name: 'Profile' });
        })
        .catch(error => {
          console.error('Login failed:', error);
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
