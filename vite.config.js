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
            input: 'resources/js/eloquent-ui.js',
            output: {
                format: 'umd',
                name: 'EloquentUI',
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`
            }
        },
        cssMinify: true
    }
});