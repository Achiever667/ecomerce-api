<template>
  <div>
    <h1>{{ isNew ? 'Create Product' : 'Edit Product' }}</h1>
    <form @submit.prevent="submitForm">
      <div>
        <label for="name">Name:</label>
        <input id="name" v-model="product.name" required />
      </div>
      <div>
        <label for="price">Price:</label>
        <input id="price" type="number" v-model.number="product.price" required />
      </div>
      <div>
        <label for="description">Description:</label>
        <textarea id="description" v-model="product.description"></textarea>
      </div>
      <div>
        <label for="category">Category:</label>
        <input id="category" v-model="product.category" />
      </div>
      <div>
        <label for="image">Image:</label>
        <input id="image" type="file" @change="handleFileChange" />
        <div v-if="previewImage">
          <img :src="previewImage" alt="Preview" width="100" />
        </div>
      </div>
      <button type="submit">{{ isNew ? 'Create' : 'Update' }}</button>
      <button @click.prevent="cancel">Cancel</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ProductCreateEdit',
  data() {
    return {
      product: {
        name: '',
        price: 0,
        description: '',
        category: '',
        image: null,
      },
      previewImage: null,
      isNew: true,
    };
  },
  methods: {
    fetchProduct() {
      if (this.$route.params.id !== 'new') {
        this.isNew = false;
        axios.get(`/products/${this.$route.params.id}`)
          .then(response => {
            this.product = response.data;
            if (this.product.image) {
              this.previewImage = `${import.meta.env.VITE_API_BASE_URL}/storage/${this.product.image}`;
            }
          })
          .catch(error => {
            console.error('Failed to fetch product:', error);
          });
      }
    },
    handleFileChange(event) {
      const file = event.target.files[0];
      this.product.image = file;
      this.previewImage = URL.createObjectURL(file);
    },
    submitForm() {
      const formData = new FormData();
      formData.append('name', this.product.name);
      formData.append('price', this.product.price);
      formData.append('description', this.product.description);
      formData.append('category', this.product.category);
      if (this.product.image instanceof File) {
        formData.append('image', this.product.image);
      }

      if (this.isNew) {
        axios.post('/products', formData)
          .then(() => {
            this.$router.push({ name: 'ProductList' });
          })
          .catch(error => {
            console.error('Failed to create product:', error);
          });
      } else {
        axios.post(`/products/${this.$route.params.id}`, formData, {
          headers: { 'X-HTTP-Method-Override': 'PUT' },
        })
          .then(() => {
            this.$router.push({ name: 'ProductList' });
          })
          .catch(error => {
            console.error('Failed to update product:', error);
          });
      }
    },
    cancel() {
      this.$router.push({ name: 'ProductList' });
    },
  },
  mounted() {
    this.fetchProduct();
  },
};
</script>

<style scoped>
form div {
  margin-bottom: 10px;
}
</style>
