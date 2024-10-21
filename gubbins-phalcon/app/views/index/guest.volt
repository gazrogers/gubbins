<body class="login">
<main>
</main>
<aside>
    <div>
        <div id="g_id_onload"
             data-client_id="{{ clientId }}"
             data-context="signin"
             data-ux_mode="popup"
             data-login_uri="http://localhost/gubbins/auth/callback"
             data-nonce=""
             data-itp_support="true">
        </div>

        <div class="g_id_signin"
             data-type="standard"
             data-shape="rectangular"
             data-theme="outline"
             data-text="signin_with"
             data-size="large"
             data-logo_alignment="left">
        </div>
    </div>
</aside>
<script type="application/javascript" src="//accounts.google.com/gsi/client" async></script>
</body>