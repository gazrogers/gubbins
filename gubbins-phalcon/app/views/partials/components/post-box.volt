<template id="post-box">
    <article contenteditable="true"></article>
    <button class="clear">Clear</button>
    <button class="post">Post</button>
<style>
:host {
    display: grid;
    grid-template:
        [row1-start] "new-post new-post" 10em [row1-end]
        [row2-start] "clear post" 2em [row2-end];
    grid-gap: 1em;
}
article {
    grid-area: new-post;
    border: .5px solid rgba(0, 0, 0, .25);
    padding: .5em;
}
article:empty:before {
    content: 'Type something';
    color: rgba(0, 0, 0, .5);
}
</style>
</template>
<script type="application/javascript" nonce="{{ cspNonce }}">
    class PostBox extends HTMLElement {
        constructor() {
            super();
        }

        connectedCallback() {
            let template = document.getElementById("post-box");
            let templateContent = template.content;
            const shadowRoot = this.attachShadow({ mode: "open" });
            shadowRoot.appendChild(templateContent.cloneNode(true));
            this.csrfTokenKey = this.getAttribute('tokenKey');
            this.csrfToken = this.getAttribute('token');
            this.editor = shadowRoot.querySelector('article');
            this.clearButton = shadowRoot.querySelector('.clear');
            this.postButton = shadowRoot.querySelector('.post');

            this.clearButton.addEventListener('click', () => this.editor.replaceChildren());
            this.postButton.addEventListener('click', () => {
                fetch('post', {
                    method: 'POST',
                    body: this.editor.textContent,
                    headers: {
                        "x-csrf-token-key": this.csrfTokenKey,
                        "x-csrf-token": this.csrfToken
                    }
                });
            });
        }
    }
    customElements.define("post-box", PostBox);
</script>

