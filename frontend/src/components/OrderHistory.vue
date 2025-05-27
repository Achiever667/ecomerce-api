<template>
  <div>
    <h1>Order History</h1>
    <div v-if="loading">Loading orders...</div>
    <div v-else>
      <ul v-if="orders.length > 0">
        <li v-for="order in orders" :key="order.id">
          <h3>Order #{{ order.id }} - Status: {{ order.status }}</h3>
