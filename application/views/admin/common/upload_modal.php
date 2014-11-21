<!-- Modal -->
<?php
if(isset($old_url)) {
    $up_url = 'admin/upload/image/'.$source."/".$old_url;
} else {
    $up_url = 'admin/upload/image/'.$source;
}
?>
<div class="modal" id="<?php echo $id; ?>" style="display:none;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!-- modal-dialog -->
    <div class="modal-dialog">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $title; ?></h4>
            </div>
            <?php $this->load->helper('form'); ?>
            <?php echo form_open_multipart(site_url($up_url), array('target' => "hidden_frame")); ?>
            <div class="modal-body">
                <input type="file" name="<?php echo $source; ?>_image" />
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">取消</button>
                <button type="submit" class="btn btn-success">上传</button>
            </div>
        </form>
        <iframe style="display:none" name='hidden_frame' id="hidden_frame">
            <html>
                <head>
                    <meta charset="utf-8" />
                </head>
            </html>
        </iframe>
        </div>
        <!-- modal-content -->
    </div>
    <!-- modal-dialog -->
</div>
<!-- Modal -->