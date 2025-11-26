import { onMounted, ref, watch } from 'vue';

/**
 * Define los posibles valores del tema.
 */
type Theme = 'light' | 'dark';

/**
 * Clave usada para guardar la preferencia del usuario en localStorage.
 */
const THEME_KEY = 'app-theme';

/**
 * Composable para manejar el modo claro/oscuro de la aplicación.
 * - Reactivo y persistente.
 * - Aplica el tema globalmente al elemento <html>.
 * - Escucha los cambios del sistema operativo (prefers-color-scheme).
 */
export function useTheme() {
    const theme = ref<Theme>('light');

    /**
     * Aplica el tema al documento y actualiza localStorage.
     */
    const setTheme = (newTheme: Theme): void => {
        theme.value = newTheme;
        const html = document.documentElement;

        if (newTheme === 'dark') {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        localStorage.setItem(THEME_KEY, newTheme);
    };

    /**
     * Alterna entre modo claro y oscuro.
     */
    const toggleTheme = (): void => {
        setTheme(theme.value === 'light' ? 'dark' : 'light');
    };

    /**
     * Detecta el tema guardado o el del sistema en el montaje.
     */
    onMounted(() => {
        const savedTheme = localStorage.getItem(THEME_KEY) as Theme | null;

        if (savedTheme === 'dark' || savedTheme === 'light') {
            setTheme(savedTheme);
        } else {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            setTheme(prefersDark ? 'dark' : 'light');
        }
    });

    /**
     * Reacciona a cambios del sistema (opcional).
     * Solo si el usuario no ha guardado una preferencia manual.
     */
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.addEventListener('change', (event) => {
        const storedTheme = localStorage.getItem(THEME_KEY);
        if (!storedTheme) {
            setTheme(event.matches ? 'dark' : 'light');
        }
    });

    // Opcional: reacción manual si el tema cambia (por integración externa)
    watch(theme, (newTheme) => {
        setTheme(newTheme);
    });

    return {
        theme,
        setTheme,
        toggleTheme,
    };
}
