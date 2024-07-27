<template>
  <div>
    <h1>{{ formTitle }}</h1>
    <form @submit.prevent="submitForm">
      <div>
        <label for="title">Title</label>
        <input type="text" v-model="form.title" id="title" />
        <span v-if="form.errors.title">{{ form.errors.title }}</span>
      </div>
      <div>
        <label for="author">Author</label>
        <input type="text" v-model="form.author" id="author" />
        <span v-if="form.errors.author">{{ form.errors.author }}</span>
      </div>
      <div>
        <label for="published_year">Published Year</label>
        <input type="number" v-model="form.published_year" id="published_year" />
        <span v-if="form.errors.published_year">{{ form.errors.published_year }}</span>
      </div>
      <div>
        <label for="genre">Genre</label>
        <input type="text" v-model="form.genre" id="genre" />
        <span v-if="form.errors.genre">{{ form.errors.genre }}</span>
      </div>
      <button type="submit">Submit</button>
    </form>
  </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';

export default {
  props: {
    book: Object,
  },
  setup(props) {
    const form = useForm({
      title: props.book ? props.book.title : '',
      author: props.book ? props.book.author : '',
      published_year: props.book ? props.book.published_year : '',
      genre: props.book ? props.book.genre : '',
    });

    const submitForm = () => {
      if (props.book) {
        form.put(route('books.update', props.book.id));
      } else {
        form.post(route('books.store'));
      }
    };

    return {
      form,
      submitForm,
      formTitle: props.book ? 'Edit Book' : 'Add New Book',
    };
  },
};
</script>
