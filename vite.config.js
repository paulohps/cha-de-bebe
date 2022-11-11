import { defineConfig } from 'vite'
import laravel, {refreshPaths} from 'laravel-vite-plugin'

export default defineConfig({
    server: {
      https: process.env.NODE_ENV === 'production'
    },
    plugins: [
        laravel({
            input: [
                'resources/assets/css/app.css',
                'resources/assets/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
                'app/Forms/Components/**'
            ]
        })
    ]
})
