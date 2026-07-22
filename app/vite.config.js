import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react(), tailwindcss()],
  // Nota: `npm run dev` sirve solo el frontend. Para probar /api/contact.js
  // en local hace falta `vercel dev` (usa la CLI de Vercel), que sirve el
  // sitio completo (frontend + funciones serverless) igual que en producción.
})
