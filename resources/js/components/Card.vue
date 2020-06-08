<template>
  <div class="card bg-secondary shadow border-0">
    
    <div class="card-body px-lg-5 py-lg-5">
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: { type: String, default: null }
  }
}
</script>
