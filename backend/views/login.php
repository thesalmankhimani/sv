<div class="row">
    <!-- Sign in -->
    <div id="signin" class="col-md-6 mx-auto text-center">
        <h2>Welcome to Stream Viewer !!</h2><br/>
        <div align="center" id="g-signin2" data-height="200" data-longtitle="true">
        </div>
    </div>
</div>
<!-- load scripts after body -->
<script>
    var google_signin_scope = '<?php echo GOOGLE_SIGNIN_SCOPE; ?>';
    // prevent gmail auto-login
    window.onbeforeunload = function (e) {
        gapi.auth2.getAuthInstance().signOut();
    };
</script>
<script src="js/google.js"></script>
<script src="//apis.google.com/js/platform.js?onload=renderButton" async defer></script>