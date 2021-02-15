<template>
<div class="card">
    <div :class="customStyles" class="card-header">
      <slot name="card-header"></slot>
      <router-link :to="redirection" v-if="urlImg">
        <span><img :src="urlImg" alt="" height="50"></span>
      </router-link>
      <p v-if="title" :class="titleStyle">{{ title }}</p>
    </div>
    <div class="card-body" :class="bodyCustomStyles">
        <slot name="card-body"></slot>
        <slot name="card-footer"> </slot>
    </div>
</div>
</template>

<script>
export default {
    name: 'Card',

    props: {
    title: {
      type: String,
      default: null
    },
    customStyles: {
      type: String,
    },
    titleStyle: {
      type: String
    },
    urlImg: {
      type: String,
      default: null
    },
    bodyCustomStyles: {
      type: String,
      default: null
    },
    redirection: {
      type: Object,
      default: null
    }
  }
}
</script>
