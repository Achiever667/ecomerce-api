<template>
  <div>
    <h2>User Registration</h2>
    <form @submit.prevent="register">
      <div>
        <label>Name:</label>
        <input v-model="name" type="text" required />
      </div>
      <div>
        <label>Email:</label>
        <input v-model="email" type="email" required />
      </div>
      <div>
        <label>Password:</label>
        <input v-model="password" type="password" required />
      </div>
      <div>
        <label>Confirm Password:</label>
        <input v-model="password_confirmation" type="password" required />
      </div>
      <button type="submit">Register</button>
    </form>
    <p v-if="error" style="color:red">{{ error }}</p>
    <p v-if="success" style="color:green">{{ success }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      error: '',
      success: '',
    };
  },
  methods: {
    async register() {
      this.error = '';
      this.success = '';
      try {
        const response = await axios.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        });
        this.success = 'Registration successful! Please login.';
        this.name = '';
        this.email = '';
        this.password = '';
        this.password_confirmation = '';
      } catch (err) {
        this.error = err.response?.data?.message || 'Registration failed.';
      }
    },
  },
};
</script>
