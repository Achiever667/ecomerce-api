<template>
  <div>
    <h1>Your Cart</h1>
    <div v-if="loading">Loading cart items...</div>
    <div v-else>
      <ul>
        <li v-for="item in cartItems" :key="item.id">
          <h3>{{ item.product.name }}</h3>
          <p>Quantity: {{ item.quantity }}</p>
          <p>Price: ${{ (item.product.price * item.quantity).toFixed(2) }}</p>
          <button @click="removeItem(item.id)">Remove</button>
        </li>
      </ul>
      <div v-if="cartItems.length === 0">Your cart is empty.</div>
      <button v-if="cartItems.length > 0" @click="checkout">Checkout</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Cart',
  data() {
    return {
      cartItems: [],
      loading: false,
    };
  },
  methods: {
    fetchCart() {
      this.loading = true;
      axios.get('/api/cart')
        .then(response => {
          this.cartItems = response.data;
        })
        .catch(error => {
          console.error('Failed to fetch cart:', error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    removeItem(id) {
      axios.delete(`/api/cart/${id}`)
        .then(() => {
          this.fetchCart();
        })
        .catch(error => {
          console.error('Failed to remove item:', error);
        });
    },
    checkout() {
      this.$router.push({ name: 'OrderHistory' });
    },
  },
  mounted() {
    this.fetchCart();
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
  margin-top: 5px;
}
</style>
