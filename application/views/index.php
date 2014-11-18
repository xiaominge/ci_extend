<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <form action="http://localhost/workspace/ci_extend/" method="post">
        <input type="text" value="" name="name">
        <?php
            $this->load->helper('html');
            echo br(2);
        ?>
        <input type="text" value="" name="age">
        <input type="hidden" value="1" name="dosubmit">
        <button type="submit" type="button">提交</button>
    </form>
</body>
</html>