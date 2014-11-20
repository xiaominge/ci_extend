<?php
$modalData = array(
    'modal_data' => array(
        'id'      => 'myModal',
        'title'   => '系统提示',
        'message' => '确认删除此'.$this->resourceName.'？',
        'footer'  => form_open('', array('id' => 'real-delete', 'method' => 'get'))
                        .form_button(array('content' => '取消', 'class' => 'btn btn-sm btn-default', 'data-dismiss' => 'modal'))
                        .form_submit(array('class' => 'btn btn-sm btn-danger', 'value' => '确认删除'))
                        .form_close(),
    ),
);

$betchDestroyModalData = array(
    'modal_data' => array(
        'id'      => 'betchDestroyModal',
        'title'   => '系统提示',
        'message' => '确认删除选中'.$this->resourceName.'？',
        'footer'  => form_open('', array('id' => 'real-betch-delete', 'method' => 'post'))
                     .form_hidden('destroy_ids', '')
                     .form_button(array('content' => '取消', 'class' => 'btn btn-sm btn-default', 'data-dismiss' => 'modal'))
                     .form_submit(array('class' => 'btn btn-sm btn-danger', 'value' => '确认删除'))
                     .form_close(),
    ),
);

?>
<?php $this->load->view("admin/common/delete_modal", $modalData); ?>
<?php $this->load->view("admin/common/betch_destroy_modal", $betchDestroyModalData); ?>
<script>

    function modal(href) {
        $('#real-delete').attr('action', href);
        $( '#myModal' ).modal();
    }

    function betch_destroy_modal(href, ids) {
        $('#real-betch-delete').attr('action', href);
        $('input[name="destroy_ids"]').val(ids);
        $( '#betchDestroyModal' ).modal();
    }

    function batch_destroy() {
        var type = "<?php echo $this->input->post('type'); ?>";
        ids = [];
        $("input[name='destroy']").each(function(i, n) {
            n = $(n);
            if(n.is(":checked")) {
                ids.push(n.val());
            }
        });
        ids = ids.join(',');
        if(type) {
            betch_destroy_modal("<?php echo site_url('admin/'.$resource.'/betch_destroy'); ?>"+"/"+type, ids);
        } else {
            betch_destroy_modal("<?php echo site_url('admin/'.$resource.'/betch_destroy'); ?>", ids);
        }
    }

    $(function () {
        
    });
</script>