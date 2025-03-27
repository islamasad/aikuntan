import './bootstrap';
import 'preline';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

// Cek tema dari localStorage atau preferensi sistem
if (
    localStorage.getItem("color-theme") === "dark" ||
    (!("color-theme" in localStorage) &&
        window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
    document.documentElement.classList.add("dark");
    themeToggleLightIcon.classList.remove("hidden");
} else {
    document.documentElement.classList.remove("dark");
    themeToggleDarkIcon.classList.remove("hidden");
}

var themeToggleBtn = document.getElementById("theme-toggle");

themeToggleBtn.addEventListener("click", function () {
    themeToggleDarkIcon.classList.toggle("hidden");
    themeToggleLightIcon.classList.toggle("hidden");

    let theme = document.documentElement.classList.contains("dark") ? "light" : "dark";

    // Ubah tema di localStorage dan class HTML
    localStorage.setItem("color-theme", theme);
    document.documentElement.classList.toggle("dark", theme === "dark");

    // Ambil CSRF token dari meta tag
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Kirim request AJAX ke Laravel untuk menyimpan preferensi tema
    fetch('/update-theme', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ theme: theme })
    }).then(response => response.json())
      .then(data => console.log("Theme updated:", data))
      .catch(error => console.error("Error updating theme:", error));
});
