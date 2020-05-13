<script>
    (function() {
        const urlParams = new URLSearchParams(window.location.search);
        const code = urlParams.get('code');
        window.opener.postMessage(code, "*");
        window.close();
    })();
</script>