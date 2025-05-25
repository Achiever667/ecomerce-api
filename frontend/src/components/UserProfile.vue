<template>
  <div>
    <h2>User Profile</h2>
    <form @submit.prevent="updateProfile">
      <div>
        <label>Name:</label>
        <input v-model="name" type="text" required />
      </div>
      <div>
        <label>Email:</label>
        <input v-model="email" type="email" required />
      </div>
      <button type="submit">Update Profile</button>
    </form>
    <p v-if="message" style="color:green">{{ message }}</p>
    <p v-if="error" style="color:red">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      message: '',
      error: '',
    };
  },
  async created() {
    await this.fetchProfile();
  },
  methods: {
    async fetchProfile() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get('/api/profile', {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.name = response.data.name;
        this.email = response.data.email;
      } catch (err) {
        this.error = 'Failed to load profile.';
      }
    },
    async updateProfile() {
      this.error = '';
      this.message = '';
      try {
        const token = localStorage.getItem('token');
        await axios.put('/api/profile', {
          name: this.name,
          email: this.email,
        }, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.message = 'Profile updated successfully.';
      } catch (err) {
        this.error = 'Failed to update profile.';
      }
    },
  },
};
</script>
