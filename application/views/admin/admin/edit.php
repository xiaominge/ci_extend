<?php $this->load->view("admin/common/header");?>
<script language="javascript" type="text/javascript" src="<?php echo config('base_url').config('common_static').'assets/My97DatePicker/WdatePicker.js'; ?>"></script>
    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>

<form action="<?php echo site_url()."/admin/{$resource}/edit/{$id}"; ?>" method="post" class="definewidth m20">
<table class="table table-bordered table-hover m10">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <tr>
        <td class="tableleft">名称</td>
        <td><input type="text" name="name" value="<?php echo $info->name; ?>" /><?php echo form_error('name'); ?></td>
    </tr>
    
    <tr>
        <td class="tableleft">密码</td>
        <td>
            <input type="text" name="pwd" value="" /><?php echo form_error('pwd'); ?>
        </td>
    </tr>

    <tr>
        <td class="tableleft">类别</td>
        <td>
            <input type="radio" name="roleid" value="1" <?php if($info->roleid == 1) { echo 'checked'; } ?> /> 超管
            <input type="radio" name="roleid" value="2" <?php if($info->roleid == 2) { echo 'checked'; } ?> /> 普通
        </td>
    </tr>

    <tr>
        <td class="tableleft">状态</td>
        <td>
            <input type="radio" name="status" value="1" <?php if($info->status == 1) { echo 'checked'; } ?> /> 正常
            <input type="radio" name="status" value="2" <?php if($info->status == 2) { echo 'checked'; } ?> /> 审核未通过
            <input type="radio" name="status" value="3" <?php if($info->status == 3) { echo 'checked'; } ?> /> 删除
        </td>
    </tr>

    <tr>
        <td class="tableleft"></td>
        <td>
            <button type="submit" class="btn btn-primary" type="button">保存</button>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-success" name="backid" id="backid">返回列表</button>
        </td>
    </tr>
</table>
</form>

<script>
    function modal() {
        $( '#UploadThumbModal' ).modal();
    }
    $(function () {       
        $('#backid').click(function() {
            // window.history.go(-1);
            window.location.href = '<?php echo site_url()."/admin/{$resource}/index"; ?>';
         });
    });
</script>

</body>
</html>