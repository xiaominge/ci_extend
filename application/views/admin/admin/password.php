<?php $this->load->view("admin/common/header");?>
<script language="javascript" type="text/javascript" src="/public/assets/My97DatePicker/WdatePicker.js"></script>
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

        <?php echo form_open(site_url()."/admin/admin/changepwd", array('class' => 'definewidth m20')); ?>

			<table class="table table-bordered table-hover m10">

				<tr>
			        <td class="tableleft">旧密码</td>
			        <td>
			            <input name='old_pass' type='password' class='normal' id="old_pass"  />
						<?php echo form_error('old_pass'); ?>
			        </td>
			    </tr>

			    <tr>
			        <td class="tableleft">新密码</td>
			        <td>
						<input name='new_pass' type='password' class='normal' id="new_pass" />
						<?php echo form_error('new_pass'); ?>
					</td>
			    </tr>

			   	<tr>
			        <td class="tableleft">确认新密码</td>
			        <td>
						<input name='new_pass_confirm' type='password' class='normal' id="new_pass_confirm"  />
						<?php echo form_error('new_pass_confirm'); ?>
					</td>
			    </tr>

			    <tr>
			        <td class="tableleft"></td>
			        <td>
			            <button type="submit" class="btn btn-primary" type="button">保存</button>
			        </td>
			    </tr>
			</table>
		<?php echo form_close(); ?>

</body>
</html>