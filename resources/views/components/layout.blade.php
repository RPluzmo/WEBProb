<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EmEks' }}</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @stack('styles')
</head>
<body>
    <x-navigation />

    <main class="page-main">
        {{ $slot }}
    </main>

    <div id="globalLightbox" class="lightbox-overlay" aria-hidden="true">
        <div class="lightbox-content">
            <img id="globalLightboxImage" class="lightbox-image" src="" alt="Palielināts attēls">
        </div>
    </div>

    <script>
        (() => {
            const overlay = document.getElementById('globalLightbox');
            const image = document.getElementById('globalLightboxImage');

            if (!overlay || !image) return;

            document.addEventListener('click', (e) => {
                const trigger = e.target.closest('[data-lightbox-src]');
                if (!trigger) return;

                e.preventDefault();
                const src = trigger.getAttribute('data-lightbox-src');
                if (!src) return;

                image.src = src;
                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
            });

            overlay.addEventListener('click', (e) => {
                if (e.target !== overlay) return;
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
                image.src = '';
            });

            document.addEventListener('keydown', (e) => {
                if (e.key !== 'Escape') return;
                if (!overlay.classList.contains('is-open')) return;
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
                image.src = '';
            });
        })();
    </script>
</body>
</html>
