<script>
    if("<?php echo $_SERVER['QUERY_STRING']; ?>") {
        $('.page a').each(function(i, n) {
            n.href = n.href + "?<?php echo $_SERVER['QUERY_STRING']; ?>";
        });
    }
</script>