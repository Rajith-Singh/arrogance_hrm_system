import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    host: '0.0.0.0', // Bind to all network interfaces
    port: 5000, // Port number
    hmr: {
      host: '192.168.246.93', // Replace with your public IP or domain if accessible
      port: 3000,
    },
  },
});
