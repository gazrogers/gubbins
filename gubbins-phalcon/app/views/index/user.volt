<body>
<header>
    <nav>
        {{ loggedInUsername }}
        <ul>
            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
        </ul>
    </nav>
</header>
<main>
    <ul class="posts">

    </ul>
    <post-box tokenKey="{{ security.getTokenKey() }}" token="{{ security.getToken() }}"></post-box>
</main>
{{ partial('partials/components/post-box') }}
</body>