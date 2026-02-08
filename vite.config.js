import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
    resolve: {
        alias: {
            'components': path.resolve(__dirname, 'resources/js/components'),
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
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