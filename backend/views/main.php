<!-- main navigation -->
<nav>
    <ul class="main_nav">
        <li><a href="<?php echo APP_URL; ?>">Home</a></li>
        <li class="logout"><a href="backend/actions.php?action=logout">Logout</a></li>
    </ul>
    <br clear="all">
</nav>
<br clear="both"/>
<!-- main wrapper -->
<section id="main_wrapper">
    <div class="row">
        <div class="w-100 p-3 mx-auto text-center">
            <!-- stream listing -->
            <div id="stream_listing"></div>
        </div>
    </div>
</section>
<br clear="both"/>

<script type="text/javascript">
    $(function () {
        load_streaming();
    });
</script>
<!-- footer -->
<footer class="footer">
    <div align="center">&copy;SV - 2018</div>
</footer>
