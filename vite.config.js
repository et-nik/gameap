import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import { viteCommonjs } from '@originjs/vite-plugin-commonjs'

export default defineConfig({
    plugins: [
        viteCommonjs(),
        laravel({
            'input': ['./resources/assets/js/app.js', './resources/assets/sass/app.scss'],
            refresh: true,
        }),
        vue({
            template: {
                compilerOptions: {
                    // treat all tags with a dash as custom elements
                    isCustomElement: (tag) => tag.includes('-')
                }
            }
        })
    ],
});


// import vue from '@vitejs/plugin-vue'
//
// export default {
//     build: {
//         rollupOptions: {
//             input: 'resources/assets/js/app.js',
//         },
//         outDir: 'public',
//     },
//     plugins: [
//         vue({
//             template: {
//                 compilerOptions: {
//                     // treat all tags with a dash as custom elements
//                     isCustomElement: (tag) => tag.includes('-')
//                 }
//             }
//         })
//     ]
// }

