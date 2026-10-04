<?php
    $ajaxFrameworkLang = [
        'confirm_title' => translate('messages.Are you sure?'),
        'yes' => translate('messages.Yes'),
        'no' => translate('messages.No'),
        'working' => translate('messages.Working...'),
        'failed' => translate('messages.Action failed'),
        'expired' => translate('messages.Your session has expired. Please sign in again.'),
        'refresh_failed' => translate('messages.Could not refresh this section'),
    ];
?>

<script>
    window.appAjaxLang = <?php echo json_encode($ajaxFrameworkLang, 15, 512) ?>;
</script>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/partials/_ajax-framework-lang.blade.php ENDPATH**/ ?>