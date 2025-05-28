<template>
  <div>
    <h2>Your Cart</h2>
    <ul>
      <li v-for="item in cartItems" :key="item.id">
        {{ item.product.name }} - Quantity: {{ item.quantity }}
        <button @click="removeFromCart(item.id)">Remove</button>
      </li>
    </ul>
    <p v-if="cartItems.length === 0">Your cart is empty.</p>
    <button @click="checkout" :disabled="cartItems.length === 0">Checkout</button>
    <p v-if="error" style="color:red">{{ error }}</p>
    <p v-if="success" style="color:green">{{ success }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      cartItems: [],
      error: '',
      success: '',
    };
  },
  async created() {
    await this.fetchCart();
  },
  methods: {
    async fetchCart() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get('/cart', {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.cartItems = response.data;
      } catch (err) {
        this.error = 'Failed to load cart.';
      }
    },
    async removeFromCart(itemId) {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        await axios.delete(`/cart/${itemId}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        await this.fetchCart();
      } catch (err) {
        this.error = 'Failed to remove item.';
      }
    },
    async checkout() {
      this.error = '';
      this.success = '';
      try {
        const token = localStorage.getItem('token');
        await axios.post('/checkout', {}, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.success = 'Order placed successfully!';
        this.cartItems = [];
      } catch (err) {
        this.error = 'Checkout failed.';
      }
    },
  },
};
</script>
