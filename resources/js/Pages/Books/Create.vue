<template>
  <BookForm :book="book" />
</template>

<script>
import BookForm from '@/Components/BookForm.vue';

export default {
  props: {
    book: Object,
    errors: Object
  },
  components: {
    BookForm,
  },
};
</script>
