import { mount } from '@vue/test-utils';
import BookForm from '@/Components/BookForm.vue';

describe('BookForm.vue', () => {
  it('renders a form with the correct fields', () => {
    const wrapper = mount(BookForm);
    expect(wrapper.find('input[id="title"]').exists()).toBe(true);
    expect(wrapper.find('input[id="author"]').exists()).toBe(true);
    expect(wrapper.find('input[id="published_year"]').exists()).toBe(true);
    expect(wrapper.find('input[id="genre"]').exists()).toBe(true);
  });

  it('renders correctly with props', () => {
    const book = {
      title: 'Test Book',
      author: 'Test Author',
      published_year: 2020,
      genre: 'Test Genre',
    };
    const wrapper = mount(BookForm, {
      props: { book },
    });

    expect(wrapper.find('input[id="title"]').element.value).toBe(book.title);
    expect(wrapper.find('input[id="author"]').element.value).toBe(book.author);
    expect(wrapper.find('input[id="published_year"]').element.value).toBe(book.published_year.toString());
    expect(wrapper.find('input[id="genre"]').element.value).toBe(book.genre);
  });
});
