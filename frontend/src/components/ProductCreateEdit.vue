<template>
  <div>
    <h1>{{ isEdit ? 'Edit Product' : 'Create Product' }}</h1>
    <form @submit.prevent="submitForm">
      <div>
        <label for="name">Name:</label>
        <input id="name" v-model="form.name" required />
      </div>
      <div>
        <label for="price">Pri