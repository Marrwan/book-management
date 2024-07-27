import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import Pages from 'vite-plugin-pages';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Pages({
            // You can customize the pattern if needed
            dirs: 'resources/js/Pages',
            extensions: ['vue'],
          }),
    ],
    resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
    },
  },
});
