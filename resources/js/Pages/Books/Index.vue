<template>
  <div class="container" :key="componentKey">
    <h1 class="title">Books Management</h1>
    <table class="book-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>Published Year</th>
          <th>Genre</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="book in books" :key="book.id" class="book-row">
          <td>{{ book.title }}</td>
          <td>{{ book.author }}</td>
          <td>{{ book.published_year }}</td>
          <td>{{ book.genre }}</td>
          <td>
            <Link :href="route('books.edit', book.id)" class="button edit">Edit</Link>
            <form :action="route('books.destroy', book.id)" method="POST" @submit.prevent="deleteBook(book.id)" class="delete-form">
            
              <button type="submit" class="button delete">Delete</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
    <Link :href="route('books.create')" class="button add">Add New Book</Link>
  </div>
</template>

<script>
import { useToast } from 'vue-toastification';
import { ref, watch, onMounted } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

export default {
  props: {
    books: Array,
    flash: Object,
  },
  components: {
    Link,
  },
  setup(props) {
    const toast = useToast();
    const componentKey = ref(Date.now());

    const handleFlash = (flash) => {
      if (flash && flash.message) {
        if (flash.type === 'success') {
          toast.success(flash.message);
        } else if (flash.type === 'error') {
          toast.error(flash.message);
        } else {
          toast.info("Welcome");
        }
      }
    };

    onMounted(() => {
      handleFlash(props.flash);
    });

    watch(
      () => props.flash,
      (newFlash) => {
        handleFlash(newFlash);
      },
      { immediate: true }
    );

    return {
      componentKey,
    };
  },
  methods: {
    deleteBook(id) {
      this.$inertia.delete(route('books.destroy', id));
      useToast().success("Book deleted successfully");
    },
  },
};
</script>

<style scoped>
/* Container Styling */
.container {
  padding: 2rem;
  background: linear-gradient(to right, #ff7e5f, #feb47b);
  min-height: 100vh;
  font-family: 'Arial', sans-serif;
  min-width: 100vw;
}

/* Title Styling */
.title {
  text-align: center;
  color: #fff;
  font-size: 2.5rem;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
}

/* Table Styling */
.book-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 2rem;
}

.book-table thead {
  background: #ff6f61;
  color: #fff;
}

.book-table th,
.book-table td {
  padding: 1rem;
  text-align: left;
  border: 1px solid #fff;
  font-size: 1.1rem;
}

.book-table tr:nth-child(even) {
  background: rgba(255, 255, 255, 0.2);
}

.book-table tr:hover {
  background: rgba(255, 255, 255, 0.4);
}

/* Button Styling */
.button {
  display: inline-block;
  padding: 0.5rem 1rem;
  margin: 0.5rem;
  color: #fff;
  text-decoration: none;
  border-radius: 0.3rem;
  font-weight: bold;
  transition: background 0.3s, transform 0.2s;
}

.button.edit {
  background: #ff8c00;
}

.button.delete {
  background: #ff6347;
}

.button.add {
  background: #4caf50;
}

.button:hover {
  transform: scale(1.1);
}

.button:active {
  background: #333;
}

/* Form Styling */
.delete-form {
  display: inline;
}
</style>
