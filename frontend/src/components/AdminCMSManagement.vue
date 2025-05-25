<template>
  <div>
    <h2>CMS Management</h2>
    <button @click="showCreateForm = !showCreateForm">
      {{ showCreateForm ? 'Cancel' : 'Add New Page' }}
    </button>

    <div v-if="showCreateForm">
      <h3>Create CMS Page</h3>
      <form @submit.prevent="createPage">
        <div>
          <label>Title:</label>
          <input v-model="newPage.title" type="text" required />
        </div>
        <div>
          <label>Content:</label>
          <textarea v-model="newPage.content" required></textarea>
        </div>
        <div>
          <label>Banner Image URL:</label>
          <input v-model="newPage.banner_image" type="text" />
        </div>
        <div>
          <label>Banner Link:</label>
          <input v-model="newPage.banner_link" type="text" />
        </div>
        <button type="submit">Create</button>
      </form>
    </div>

    <ul>
      <li v-for="page in pages" :key="page.id">
        <strong>{{ page.title }}</strong> - 
        <span v-if="page.archived">Archived</span>
        <span v-else>Active</span>
        <button @click="editPage(page)">Edit</button>
        <button @click="toggleArchive(page)">{{ page.archived ? 'Unarchive' : 'Archive' }}</button>
      </li>
    </ul>

    <div v-if="editingPage">
      <h3>Edit CMS Page</h3>
      <form @submit.prevent="updatePage">
        <div>
          <label>Title:</label>
          <input v-model="editingPage.title" type="text" required />
        </div>
        <div>
          <label>Content:</label>
          <textarea v-model="editingPage.content" required></textarea>
        </div>
        <div>
          <label>Banner Image URL:</label>
          <input v-model="editingPage.banner_image" type="text" />
        </div>
        <div>
          <label>Banner Link:</label>
          <input v-model="editingPage.banner_link" type="text" />
        </div>
        <button type="submit">Update</button>
        <button @click="cancelEdit">Cancel</button>
      </form>
    </div>

    <p v-if="error" style="color:red">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      pages: [],
      showCreateForm: false,
      newPage: {
        title: '',
        content: '',
        banner_image: '',
        banner_link: '',
      },
      editingPage: null,
      error: '',
    };
  },
  async created() {
    await this.fetchPages();
  },
  methods: {
    async fetchPages() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get('/api/cms-pages', {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.pages = response.data;
      } catch (err) {
        this.error = 'Failed to load CMS pages.';
      }
    },
    async createPage() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        await axios.post('/api/cms-pages', this.newPage, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.showCreateForm = false;
        this.newPage = { title: '', content: '', banner_image: '', banner_link: '' };
        await this.fetchPages();
      } catch (err) {
        this.error = 'Failed to create CMS page.';
      }
    },
    editPage(page) {
      this.editingPage = { ...page };
    },
    async updatePage() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        await axios.put(`/api/cms-pages/${this.editingPage.id}`, this.editingPage, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.editingPage = null;
        await this.fetchPages();
      } catch (err) {
        this.error = 'Failed to update CMS page.';
      }
    },
    cancelEdit() {
      this.editingPage = null;
    },
    async toggleArchive(page) {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        await axios.put(`/api/cms-pages/${page.id}/archive`, {}, {
          headers: { Authorization: `Bearer ${token}` },
        });
        await this.fetchPages();
      } catch (err) {
        this.error = 'Failed to update archive status.';
      }
    },
  },
};
</script>
