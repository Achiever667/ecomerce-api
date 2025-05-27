<template>
  <div>
    <h1>Product List</h1>
    <div v-if="loading">Loading products...</div>
    <div v-else>
      <ul>
        <li v-for="product in products" :key="product.id">
          <h3>{{ product.name }}</h3>
          <p>{{ product.description }}</p>
          <p>Price: ${{ product.price.toFixed(2) }}</p>
          <img v-if="product.image" :src="getImageUrl(product.image)" alt="Product Image" width="100" />
          <button @click="editProduct(product.id)">Edit</button>
          <button @click="deleteProduct(product.id)">Delete</button>
        </li>
      </ul>
      <button @click="createProduct">Add New Product</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'ProductList',
  data() {
    return {
      products: [],
      loading: false,
    };
  },
  methods: {
    getImageUrl(imagePath) {
      return `${import.meta.env.VITE_API_BASE_URL}/storage/${imagePath}`;
    },
    fetchProducts() {
      this.loading = true;
      axios.get('/api/products')
        .then(response => {
          this.products = response.data;
        })
        .catch(error => {
          console.error('Failed to fetch products:', error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    createProduct() {
      this.$router.push({ name: 'ProductCreateEdit', params: { id: 'new' } });
    },
    editProduct(id) {
      this.$router.push({ name: 'ProductCreateEdit', params: { id } });
    },
    deleteProduct(id) {
      if (confirm('Are you sure you want to delete this product?')) {
        axios.delete(`/api/products/${id}`)
          .then(() => {
            this.fetchProducts();
          })
          .catch(error => {
            console.error('Failed to delete product:', error);
          });
      }
    },
  },
  mounted() {
    this.fetchProducts();
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
