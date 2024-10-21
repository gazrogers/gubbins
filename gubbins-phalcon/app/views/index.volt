<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="The gubbins social network" />
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'nonce-{{ cspNonce|default('') }}' http://accounts.google.com/gsi/client; frame-src 'self' http://accounts.google.com/gsi/; connect-src 'self' http://accounts.google.com/gsi/;">
    <meta http-equiv="Cross-Origin-Opener-Policy" content="same-origin-allow-popups">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@100&display=swap" rel="stylesheet">
    <title>Gubbins</title>
    {{ assets.outputCss('css') }}
    {{ assets.outputJs('js') }}
</head>
{{ content() }}
</html>