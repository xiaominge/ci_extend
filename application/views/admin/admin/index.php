<?php $this->load->view("admin/common/header");?>

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
<form class="form-inline definewidth m20" action="<?php echo site_url()."/admin/$resource/index"; ?>" method="get">
    类别：<select class="form-control" name="roleid">
        <option value="" >所有</option>
        <option value="1" <?php if($this->input->get('roleid') == 1) { echo 'selected="selected"'; } ?> >超级</option>
        <option value="2" <?php if($this->input->get('roleid') == 2) { echo 'selected="selected"'; } ?> >普通</option>
    </select>
    状态：<select class="form-control" name="status">
        <option value="" >所有</option>
        <option value="1" <?php if($this->input->get('status') == 1) { echo 'selected="selected"'; } ?> >正常</option>
        <option value="2" <?php if($this->input->get('status') == 2) { echo 'selected="selected"'; } ?> >审核未通过</option>
        <option value="3" <?php if($this->input->get('status') == 3) { echo 'selected="selected"'; } ?> >已删除</option>
    </select>
    名称：<input type="text" name="name" id="name" value="<?php echo $this->input->get('name'); ?>" class="form-control">
    <button type="submit" class="btn btn-primary">查询</button>
    <a class="btn btn-success" href="<?php echo site_url()."/admin/$resource/add"; ?>" >新增</a>
</form>
<form id="sort" action="<?php echo site_url('admin/'.$resource.'/sort') ?>" method="post">
    <table class="table table-hover definewidth m10">
        <thead>
            <tr>
                <th ><a href="javascript:void(0)" onclick="all_select('destroy')">全选</a></th>
                <!--<th >排序</th>-->
                <th>名称</th>
                <th>类别</th>
                <th>状态</th>
                <th>添加时间</th>
                <th>修改时间</th>
                <th>管理操作</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($list as $l): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="destroy" value="<?php echo $l->id; ?>">
                    </td>
                    <!--<td>
                        <input name="order[<?php echo $l->id; ?>]" style="width:30px;" type="text" value="<?php echo $l->order; ?>">
                    </td>-->
                    <td><?php echo $l->name; ?></td>
                    <td>
                        <?php
                            if($l->roleid == 1) {
                                echo "超管";
                            } elseif($l->roleid == 2) {
                                echo '普通';
                            }
                        ?>
                    </td>
                    <td><?php if($l->status == 1) { echo "正常"; } elseif($l->status == 2) { echo '审核未通过'; } elseif($l->status == 3) { echo '删除'; } ?></td>
                    <td><?php echo $l->ctime; ?></td>
                    <td><?php echo $l->mtime; ?></td>
                    <td>
                        <div class="">
                          <a class="" href="<?php echo site_url()."/admin/$resource/edit/$l->id"; ?>">修改</a>&nbsp;
                          <a class="" onclick="modal('<?php echo site_url()."/admin/$resource/delete/$l->id"; ?>')" href="javascript:void(0)" >删除</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="9">
                    <a href="javascript:void(0)" onclick="batch_destroy()" class="btn btn-xs btn-danger">删除</a>&nbsp;
                    <!-- <button type="submit" class="btn btn-primary">排序</button> -->
                </td>
            </tr>
        </tbody>
    </table>
</form>
    <div class="inline pull-right page"><?php echo $this->pagination->create_links(); ?></div>

<?php $this->load->view("admin/common/delete"); ?>
<?php $this->load->view("admin/common/page"); ?>

</body>
</html>