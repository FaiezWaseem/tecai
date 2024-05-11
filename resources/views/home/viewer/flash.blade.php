<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ANIMATION</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        body {
            background: black;
            overflow: hidden;
        }

        ruffle-player {
            width: 100vw;
            height: 100vh;
        }

        ruffle-player,
        ruffle-embed,
        ruffle-object {
            --splash-screen-background: #2967a5;
            --logo-display: none !important;
        }

        ruffle-player .logo,
        ruffle-embed .logo,
        ruffle-object .logo {
            display: none !important;
        }
    </style>
</head>

<body>
    <div id="container"></div>


    <script src="{{ asset('ruffle/ruffle.js') }}"></script>
    <script>
        try {
            window.RufflePlayer = window.RufflePlayer || {};
            window.RufflePlayer.config = {
                // Start playing the content automatically, without audio if the browser in use does not allow audio to autoplay
                "autoplay": "on",
                // Do not show an overlay to unmute the content while it plays; when the content area receives its first interaction, it will unmute
                "unmuteOverlay": "hidden",
                "credentialAllowList": ["https://teclms.net/"],
                // Do not show a splash screen before the content loads; the content area will remain blank until Ruffle fully loads the content
            }

            window.addEventListener("DOMContentLoaded", () => {
                let ruffle = window.RufflePlayer.newest();
                let player = ruffle.createPlayer();
                let container = document.getElementById("container");
                container.appendChild(player);
                player.load("{{ route('preview.file.download',['id'=> $id]) }}");
            });
            window.localStorage.clear()
        } catch (e) {
            alert(e)
        }
    </script>
</body>

</html>