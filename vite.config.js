import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    tailwindcss({
      theme: {
        extend: {
          colors: {
            genz: {
              bg: '#f6f8ff',
              primary: '#a78bfa',
              accent: '#60a5fa',
            },
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
        },
      },
    }),
  ],
});
