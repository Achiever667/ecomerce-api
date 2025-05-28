<template>
  <div>
    <h1>CMS Management</h1>
    <div v-if="loading">Loading CMS pages...</div>
    <div v-else>
      <ul>
        <li v-for="page in cmsPages" :key="page.id">
          <h3>{{ page.title }}</h3>
          <p>{{ page.content }}</p>
          <button @click="editPage(page.id)">Edit</button>
          <button @click="archivePage(page.id)" v-if="!page.is_archived">Archive</button>
          <button @click="unarchivePage(page.id)" v-else>Unarchive</button>
        </li>
      </ul>
      <button @click="createPage">Add New CMS Page</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'CMSManagement',
  data() {
    return {
      cmsPages: [],
      loading: false,
    };
  },
  methods: {
    fetchCMSPages() {
      this.loading = true;
      axios.get('/cms-pages')
        .then(response => {
          this.cmsPages = response.data;
        })
        .catch(error => {
          console.error('Failed to fetch CMS pages:', error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    createPage() {
      this.$router.push({ name: 'CMSCreateEdit', params: { id: 'new' } });
    },
    editPage(id) {
      this.$router.push({ name: 'CMSCreateEdit', params: { id } });
    },
    archivePage(id) {
      axios.post(`/cms-pages/${id}/archive`)
        .then(() => {
          this.fetchCMSPages();
        })
        .catch(error => {
          console.error('Failed to archive page:', error);
        });
    },
    unarchivePage(id) {
      axios.post(`/cms-pages/${id}/archive`)
        .then(() => {
          this.fetchCMSPages();
        })
        .catch(error => {
          console.error('Failed to unarchive page:', error);
        });
    },
  },
  mounted() {
    this.fetchCMSPages();
  },
};
</script>

<style scoped>
ul {
  list-style-type: none;
  padding: 0;
}
li {
  border: 1px solid #ccc;
  margin-bottom: 10px;
  padding: 10px;
}
button {
  margin-right: 5px;
}
</style>
