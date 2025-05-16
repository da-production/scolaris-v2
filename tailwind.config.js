
export default {
    darkMode: ["class"],

    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/masmerise/livewire-toaster/resources/views/**/*.blade.php', // 👈 Assure-toi d'inclure tous les fichiers
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}