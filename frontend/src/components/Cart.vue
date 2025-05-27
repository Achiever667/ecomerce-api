<template>
  <div>
    <h1>Your Cart</h1>
    <div v-if="loading">Loading cart items...</div>
    <div v-else>
      <ul v-if="cartItems.length > 0">
        <li v-for="item in cartItems" :key="item.id">
          <h3>{{ item.product.name }}</h3>