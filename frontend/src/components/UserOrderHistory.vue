<template>
  <div>
    <h2>Your Order History</h2>
    <ul>
      <li v-for="order in orders" :key="order.id">
        Order #{{ order.id }} - Status: {{ order.status }} - Total: ${{ order.total }}
      </li>
    </ul>
    <p v-if="orders.length === 0">You have no orders.</p>
    <p v-if="error" style="color:red">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      orders: [],
      error: '',
    };
  },
  async created() {
    await this.fetchOrders();
  },
  methods: {
    async fetchOrders() {
      this.error = '';
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get('/orders', {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.orders = response.data;
      } catch (err) {
        this.error = 'Failed to load orders.';
      }
    },
  },
};
</script>
