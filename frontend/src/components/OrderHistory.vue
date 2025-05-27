<template>
  <div>
    <h1>Order History</h1>
    <div v-if="loading">Loading orders...</div>
    <div v-else>
      <ul>
        <li v-for="order in orders" :key="order.id">
          <h3>Order #{{ order.id }} - Status: {{ order.status }}</h3>
          <p>Total: ${{ order.total.toFixed(2) }}</p>
          <ul>
            <li v-for="item in order.orderItems" :key="item.id">
              {{ item.product.name }} - Quantity: {{ item.quantity }} - Price: ${{ item.price.toFixed(2) }}
            </li>
          </ul>
        </li>
      </ul>
      <div v-if="orders.length === 0">You have no orders.</div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'OrderHistory',
  data() {
    return {
      orders: [],
      loading: false,
    };
  },
  methods: {
    fetchOrders() {
      this.loading = true;
      axios.get('/api/orders')
        .then(response => {
          this.orders = response.data;
        })
        .catch(error => {
          console.error('Failed to fetch orders:', error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
  mounted() {
    this.fetchOrders();
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
</style>
