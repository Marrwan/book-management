<template>
  <div class="form-container">
    <h1 class="form-title">{{ formTitle }}</h1>
    <div v-if="$page.props.errors && Object.keys($page.props.errors).length" class="alert alert-danger">
      <ul>
        <li v-for="(error, key) in $page.props.errors" :key="key">{{ error }}</li>
      </ul>
    </div>
    <form @submit.prevent="submitForm" class="book-form">
      <div class="form-group">
        <label for="title" class="form-label">Title</label>
        <input type="text" v-model="form.title" id="title" class="form-input" />
        <span v-if="form.errors.title" class="error-message">{{ form.errors.title }}</span>
      </div>
      <div class="form-group">
        <label for="author" class="form-label">Author</label>
        <input type="text" v-model="form.author" id="author" class="form-input" />
        <span v-if="form.errors.author" class="error-message">{{ form.errors.author }}</span>
      </div>
      <div class="form-group">
        <label for="published_year" class="form-label">Published Year</label>
        <input type="number" v-model="form.published_year" id="published_year" class="form-input" min="1900" max="2099" step="1" />
        <span v-if="form.errors.published_year" class="error-message">{{ form.errors.published_year }}</span>
      </div>
      <div class="form-group">
        <label for="genre" class="form-label">Genre</label>
        <input type="text" v-model="form.genre" id="genre" class="form-input" />
        <span v-if="form.errors.genre" class="error-message">{{ form.errors.genre }}</span>
      </div>
      <button type="submit" class="submit-button">Submit</button>
    </form>
  </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';
import { watch } from 'vue';
import { useToast } from 'vue-toastification';
import { usePage } from '@inertiajs/inertia-vue3';


export default {
  setup() {
    const { props } = usePage();

    const toast = useToast();

    const form = useForm({
      title: '',
      author: '',
      published_year: '',
      genre: '',
    });
    toast.error(props.error);
    // Watch for changes in props.errors and set form errors accordingly
    watch(() => props.errors, (newErrors) => {
      toast.error(newErrors);
      if (newErrors) {
        console.log("Errors on mount:", newErrors);
        form.setErrors(newErrors);
        Object.values(newErrors).forEach(error => {
          toast.error(error);
        });
      }
    }, { immediate: true });

    const submitForm = () => {
      form.post(route('books.store'), {
        onError: (error) => {
          console.log("Errors on submit:", error);
          form.setErrors(error);
          Object.values(error).forEach(err => {
            toast.error(err);
          });
        }
      });
    };

    return {
      form,
      submitForm,
      formTitle: 'Add New Book',
    };
  },
};
</script>

<style scoped>
/* Container Styling */
.form-container {
  max-width: 600px;
  margin: auto;
  padding: 2rem;
  background: #ff9a9e;
  border-radius: 0.5rem;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

/* Title Styling */
.form-title {
  text-align: center;
  color: #fff;
  font-size: 2rem;
  margin-bottom: 1.5rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
}

/* Form Styling */
.book-form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold;
  color: #fff;
}

.form-input {
  width: 100%;
  padding: 0.75rem;
  border-radius: 0.25rem;
  border: 2px solid #ff6f61;
  box-sizing: border-box;
  font-size: 1rem;
  transition: border-color 0.3s;
}

.form-input:focus {
  border-color: #ff9a9e;
  outline: none;
}

/* Error Message Styling */
.error-message {
  color: #ff6347;
  font-size: 0.875rem;
  margin-top: 0.5rem;
}

/* Submit Button Styling */
.submit-button {
  padding: 0.75rem 1.5rem;
  background: #ff6f61;
  color: #fff;
  border: none;
  border-radius: 0.25rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.3s, transform 0.2s;
}

.submit-button:hover {
  background: #ff8c00;
  transform: scale(1.05);
}

.submit-button:active {
  background: #ff6347;
}
</style>
