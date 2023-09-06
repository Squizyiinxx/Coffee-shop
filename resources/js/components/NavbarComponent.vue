<script>
export default {
  props: ["title"],
};
</script>
<template>
  <nav class="navbar bg-nav">
    <div class="container">
      <a class="navbar-brand fw-bold text-white" href="#">{{ title }}</a>
    </div>
  </nav>
</template>
