<template>
  <div>
    <h2>Admin Product Management</h2>
    <button @click="showCreateForm = !showCreateForm">
      {{ showCreateForm ? 'Cancel' : 'Add New Product' }}
    </button>

    <div v-if="showCreateForm">
      <h3>Create Product</h3>
      <form @submit.prevent="createProduct">
        <div>
          <label>Name:</label>
          <input v-model="newProduct.name" type="text" required />
        </div>
        <div>
          <label>Price:</label>
          <input v-model.number="newProduct.price" type="number" step="0.01" required />
        </div>
        <div>
          <label>Description:</label>
          <textarea v-model="newProduct.description"></textarea>
        </div>
        <div>
          <label>Category:</label>
          <input v-model="newProduct.category" type="text" />
        </div>
        <button type="submit">Create</button>
      </form>
    </div>

    <ul>
      <li v-for="product in products" :key="product.id">
        <strong>{{ product.name }}</strong> - ${{ product.price.toFixed(2) }}
        <button @click="editProduct(product)">Edit</button>
        <button @click="deleteProduct(product.id)">Delete</button>
      </li>
    </ul>

    <div v-if="editingProduct">
      <h3>Edit Product</h3>
      <form @submit.prevent="updateProduct">
        <div>
          <label>Name:</label>
          <input v-model="editingProduct.name" type="text" required />
        </div>
        <div>
          <label>Price:</label>
          <input v-model.number="editingProduct.price" type="number" step="0.01" required />
        </div>
        <div>
          <label>Description:</label>
          <textarea v-model="editingProduct.description"></textarea>
        </div>
        <div>
          <label>Category:</label>
          <input v-model="editingProduct.category" type="text" />
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
      products: [],
      showCreateForm: false,
      newProduct: {
        name: '',
        price: 0,
        description: '',
        category: '',
      },
      editingProduct: null,
      error: '',
    };
  },
  async created() {
    await this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get('/api/products', {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.products = response.data;
      } catch (err) {
        this.error = 'Failed to load products.';
      }
    },
    async createProduct() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        await axios.post('/api/products', this.newProduct, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.showCreateForm = false;
        this.newProduct = { name: '', price: 0, description: '', category: '' };
        await this.fetchProducts();
      } catch (err) {
        this.error = 'Failed to create product.';
      }
    },
    editProduct(product) {
      this.editingProduct = { ...product };
    },
    async updateProduct() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        await axios.put(`/api/products/${this.editingProduct.id}`, this.editingProduct, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.editingProduct = null;
        await this.fetchProducts();
      } catch (err) {
        this.error = 'Failed to update product.';
      }
    },
    cancelEdit() {
      this.editingProduct = null;
    },
    async deleteProduct(id) {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        await axios.delete(`/api/products/${id}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        await this.fetchProducts();
      } catch (err) {
        this.error = 'Failed to delete product.';
      }
    },
  },
};
</script>
