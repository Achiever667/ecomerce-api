<template>
  <div>
    <h2>{{ isEdit ? 'Edit Product' : 'Create Product' }}</h2>
    <form @submit.prevent="submitForm">
      <div>
        <label>Name:</label>
        <input v-model="product.name" type="text" required />
      </div>
      <div>
        <label>Price:</label>
        <input v-model.number="product.price" type="number" step="0.01" required />
      </div>
      <div>
        <label>Description:</label>
        <textarea v-model="product.description"></textarea>
      </div>
      <div>
        <label>Category:</label>
        <input v-model="product.category" type="text" />
      </div>
      <button type="submit">{{ isEdit ? 'Update' : 'Create' }}</button>
      <button @click.prevent="cancel">Cancel</button>
    </form>
    <p v-if="error" style="color:red">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      product: {
        name: '',
        price: 0,
        description: '',
        category: '',
      },
      error: '',
    };
  },
  computed: {
    isEdit() {
      return !!this.$route.params.id;
    },
  },
  async created() {
    if (this.isEdit) {
      await this.fetchProduct();
    }
  },
  methods: {
    async fetchProduct() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get(`/products/${this.$route.params.id}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.product = response.data;
      } catch (err) {
        this.error = 'Failed to load product.';
      }
    },
    async submitForm() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        if (this.isEdit) {
          await axios.put(`/products/${this.$route.params.id}`, this.product, {
            headers: { Authorization: `Bearer ${token}` },
          });
        } else {
          await axios.post('/products', this.product, {
            headers: { Authorization: `Bearer ${token}` },
          });
        }
        this.$router.push('/products');
      } catch (err) {
        this.error = 'Failed to save product.';
      }
    },
    cancel() {
      this.$router.push('/products');
    },
  },
};
</script>
