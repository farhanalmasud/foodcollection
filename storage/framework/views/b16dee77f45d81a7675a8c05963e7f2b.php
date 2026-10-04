
<div class="modal fade removeSlideDown gsearch-modal" id="staticBackdrop" tabindex="-1"
     role="dialog" aria-label="<?php echo e(translate('Search by keyword')); ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered gsearch-dialog" role="document">
        <div class="modal-content gsearch border-0">

            <div class="gsearch-head">
                <span class="gsearch-head-ico" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                         stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="m20 20-3.2-3.2"></path>
                    </svg>
                </span>

                
                <form class="gsearch-form" id="searchForm" action="<?php echo e($searchRoute); ?>" onsubmit="return false;">
                    <?php echo csrf_field(); ?>
                    <input type="search" id="searchInput" name="search" maxlength="255" autocomplete="off"
                           class="form-control gsearch-input search-input"
                           placeholder="<?php echo e(translate('Search by keyword')); ?>"
                           aria-label="<?php echo e(translate('Search by keyword')); ?>"
                           role="combobox" aria-expanded="true" aria-autocomplete="list"
                           aria-controls="searchResults">
                </form>

                <button type="button" class="gsearch-clear" id="gsearchClear" hidden
                        aria-label="<?php echo e(translate('Clear')); ?>" title="<?php echo e(translate('Clear')); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"
                         stroke-linecap="round" aria-hidden="true">
                        <path d="M18 6 6 18M6 6l12 12"></path>
                    </svg>
                </button>

                <button type="button" class="gsearch-esc" data-dismiss="modal"><?php echo e(translate('Esc')); ?></button>
            </div>

            <div class="gsearch-progress" aria-hidden="true"></div>

            <div class="gsearch-body search-result" id="searchResults" role="listbox"
                 aria-live="polite" aria-label="<?php echo e(translate('Search result')); ?>"></div>

            <div class="gsearch-foot">
                <span class="gsearch-hint"><kbd>&uarr;</kbd><kbd>&darr;</kbd><?php echo e(translate('Navigate')); ?></span>
                <span class="gsearch-hint"><kbd>&crarr;</kbd><?php echo e(translate('Open')); ?></span>
                <span class="gsearch-hint"><kbd>Esc</kbd><?php echo e(translate('Close')); ?></span>
            </div>

        </div>
    </div>
</div>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/partials/_global_search_modal.blade.php ENDPATH**/ ?>