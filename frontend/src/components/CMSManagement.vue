<template>
  <div>
    <h1>CMS Management</h1>
    <div v-if="loading">Loading CMS pages...</div>
    <div v-else>
      <ul v-if="pages.length > 0">
        <li v-for="page in pages" :key="page.id">
          <h3>{{ page.title }}</h3>
          <p v-html="page.content"></