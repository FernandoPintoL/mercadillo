import { ref, watchEffect } from 'vue';

export function useDarkMode() {
    const isDark = ref(localStorage.getItem('theme') === 'dark' ||
        (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches));

    const toggleDarkMode = () => {
        isDark.value = !isDark.value;
        localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', isDark.value);
    };

    watchEffect(() => {
        document.documentElement.classList.toggle('dark', isDark.value);
    });

    return { isDark, toggleDarkMode };
}
