<template>
  <div>
    <h1>User Profile</h1>
    <div v-if="loading">Loading profile...</div>
    <div v-else>
      <p><strong>Name:</strong> {{ profile.name }}</p>
      <p><strong>Email:</strong> {{ profile.email }}</p>
      <button @click="logout">Logout</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Profile',
  data() {
    return {
      profile: {},
      loading: false,
    };
  },
  methods: {
    fetchProfile() {
      this.loading = true;
      axios.get('/profile')
        .then(response => {
          this.profile = response.data;
        })
        .catch(error => {
          console.error('Failed to fetch profile:', error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    logout() {
      axios.post('/logout')
        .then(() => {
          localStorage.removeItem('auth_token');
          delete axios.defaults.headers.common['Authorization'];
          this.$router.push({ name: 'Login' });
        })
        .catch(error => {
          console.error('Logout failed:', error);
        });
    },
  },
  mounted() {
    this.fetchProfile();
  },
};
</script>

<style scoped>
button {
  margin-top: 10px;
}
</style>
