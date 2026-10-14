<script>
    const themePreference = localStorage.getItem('theme');
    const prefersDarkTheme = window.matchMedia('(prefers-color-scheme: dark)').matches;

    document.documentElement.classList.toggle(
        'dark',
        themePreference === 'dark' || (themePreference === null && prefersDarkTheme)
    );
</script>
