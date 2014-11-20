<!-- Modal -->
<div class="modal" id="<?php echo $modal_data['id']; ?>" tabindex="-1" style="display:none;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!-- modal-dialog -->
    <div class="modal-dialog">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $modal_data['title']; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $modal_data['message']; ?>
            </div>
            <div class="modal-footer">
                <?php echo $modal_data['footer']; ?>
            </div>
        </div>
        <!-- modal-content -->
    </div>
    <!-- modal-dialog -->
</div>
<!-- Modal -->