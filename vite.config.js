import vue from '@vitejs/plugin-vue'

export default {
    build: {
        rollupOptions: {
            input: 'resources/assets/js/app.js',
        },
        outDir: 'public',
    },
    plugins: [
        vue({
            template: {
                compilerOptions: {
                    // treat all tags with a dash as custom elements
                    isCustomElement: (tag) => tag.includes('-')
                }
            }
        })
    ]
}
