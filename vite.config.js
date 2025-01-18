import { defineConfig } from 'vite';
import symfonyPlugin from 'vite-plugin-symfony';

export default defineConfig({
    plugins: [
        symfonyPlugin(),
    ],
    server: {
        strictPort: true,
        port: 5173, // Port du serveur de développement Vite
        watch: {
            usePolling: true, // Pour les environnements Docker/WSL
        },
    },
    build: {
        outDir: 'public/build',
        manifest: true, // Générer un fichier manifest.json pour Symfony
    },
});
