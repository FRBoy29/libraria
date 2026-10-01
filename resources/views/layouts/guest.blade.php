<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIA - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@600;700&family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL,GRAD,opsz,wght@0..1,-50..200,20..48,100..700" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: "class" };
        try {
            var t = localStorage.getItem("libraria-auth-theme");
            if (t !== "light") document.documentElement.classList.add("dark");
        } catch (e) {
            document.documentElement.classList.add("dark");
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-family: "Material Symbols Outlined";
            font-weight: normal; font-style: normal; line-height: 1;
            letter-spacing: normal; text-transform: none; display: inline-block;
            white-space: nowrap; word-wrap: normal; direction: ltr;
            -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility;
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
            user-select: none;
        }
    </style>
    <livewire:styles />
</head>
<body class="min-h-screen font-[Inter,sans-serif]">
    {{ $slot }}
    <script>
        (function () {
            function isDark() { return document.documentElement.classList.contains("dark"); }
            function renderAuthTheme() {
                document.querySelectorAll(".auth-theme-toggle").forEach(function (btn) {
                    var icon = btn.querySelector("[data-theme-icon]");
                    var label = btn.querySelector("[data-theme-label]");
                    if (icon) icon.textContent = isDark() ? "dark_mode" : "light_mode";
                    if (label) label.textContent = isDark() ? "Mode Gelap" : "Mode Terang";
                });
            }
            function setAuthTheme(dark) {
                document.documentElement.classList.toggle("dark", dark);
                try { localStorage.setItem("libraria-auth-theme", dark ? "dark" : "light"); } catch (e) {}
                renderAuthTheme();
            }
            window.toggleAuthTheme = function () { setAuthTheme(!isDark()); };
            renderAuthTheme();
        })();
    </script>
    <livewire:scripts />
</body>
</html>
