

<script>
    window.statusToggleLang = {
        confirm_title: <?php echo json_encode(translate('messages.Are you sure?'), 15, 512) ?>,
        yes: <?php echo json_encode(translate('messages.Yes'), 15, 512) ?>,
        no: <?php echo json_encode(translate('messages.No'), 15, 512) ?>,
        on: <?php echo json_encode(translate('messages.Active'), 15, 512) ?>,
        off: <?php echo json_encode(translate('messages.Inactive'), 15, 512) ?>,
        done: <?php echo json_encode(translate('Updated successfully'), 15, 512) ?>,
        failed: <?php echo json_encode(translate('messages.Status update failed'), 15, 512) ?>
    };
</script>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/partials/_status-toggle-lang.blade.php ENDPATH**/ ?>