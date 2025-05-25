<template>
  <div>
    <h2>User Login</h2>
    <form @submit.prevent="login">
      <div>
        <label>Email:</label>
        <input v-model="email" type="email" required />
      </div>
      <div>
        <label>Password:</label>
        <input v-model="password" type="password" required />
      </div>
      <button type="submit">Login</button>
    </form>
    <p v-if="error" style="color:red">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      error: '',
    };
  },
  methods: {
    async login() {
      this.error = '';
      try {
        const response = await axios.post('/api/login', {
          email: this.email,
          password: this.password,
        });
        localStorage.setItem('token', response.data.access_token);
        this.$router.push('/profile');
      } catch (err) {
        this.error = err.response?.data?.message || 'Login failed.';
      }
    },
  },
};
</script>
