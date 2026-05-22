<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RUTO — {{ config('ruto.tagline') }}</title>
    @vite(['resources/css/app.css', 'resources/css/ruto-auth.css'])
</head>
<body class="splash-body">
    <div class="splash-scene" id="splashScene" role="button" tabindex="0" aria-label="Lanjut ke halaman masuk">
        <div class="splash-logo-wrap">
            <x-ruto-logo class="splash-logo" />
        </div>

        <div class="splash-steam" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="splash-loader" aria-hidden="true"></div>
        <p class="splash-skip">Ketuk untuk lanjut</p>
    </div>

    <script>
        (function () {
            const scene = document.getElementById('splashScene');
            const loginUrl = @json(route('login'));
            let done = false;

            function goToLogin() {
                if (done) return;
                done = true;
                scene.classList.add('splash-exit');
                setTimeout(() => { window.location.href = loginUrl; }, 550);
            }

            setTimeout(goToLogin, 3000);

            scene.addEventListener('click', goToLogin);
            scene.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    goToLogin();
                }
            });
        })();
    </script>
</body>
</html>
