import { defineConfig } from 'vite';

export default defineConfig({
    build: {
        outDir: 'public/build',
        rollupOptions: {
            input: {
                'eloquent-ui': 'resources/js/eloquent-ui.js',
                'eloquent-ui.css': 'resources/css/eloquent-ui.css'
            },
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`
            }
        },
        cssMinify: true
    }
});