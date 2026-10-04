
<div class="shadow-sm p-xxl-20 p-xl-3 p-2 bg-white mb-20" id="measurement_units_section">
    <div class="mb-20">
        <h4 class="mb-1">
            <?php echo e(translate('Measurement units')); ?>

        </h4>
        <p class="mb-0 fs-12">
            <?php echo e(translate('The units every rate, coverage area, weight class and dimension class is read in. Changing one changes what those stored numbers mean.')); ?>

        </p>
    </div>
    <div class="bg-light2 rounded p-xxl-20 p-3">
        <div class="row g-3">
            <div class="col-sm-6 col-md-4 col-xl-4">
                <div class="form-group mb-0">
                    <label class="input-label" for="distance_unit"><?php echo e(translate('Distance unit')); ?>

                        <span class="text-danger">*</span>
                    </label>
                    <select name="distance_unit" id="distance_unit"
                        class="form-control js-select2-custom h--45px">
                        <option value="km" <?php echo e($distanceUnit === 'km' ? 'selected' : ''); ?>>
                            <?php echo e(translate('messages.Kilometre')); ?> (km)</option>
                        <option value="mi" <?php echo e($distanceUnit === 'mi' ? 'selected' : ''); ?>>
                            <?php echo e(translate('messages.Mile')); ?> (mi)</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-4">
                <div class="form-group mb-0">
                    <label class="input-label" for="weight_unit"><?php echo e(translate('Weight unit')); ?>

                        <span class="text-danger">*</span>
                    </label>
                    <select name="weight_unit" id="weight_unit"
                        class="form-control js-select2-custom h--45px">
                        <option value="kg" <?php echo e($weightUnit === 'kg' ? 'selected' : ''); ?>>
                            <?php echo e(translate('messages.Kilogram')); ?> (kg)</option>
                        <option value="lb" <?php echo e($weightUnit === 'lb' ? 'selected' : ''); ?>>
                            <?php echo e(translate('messages.Pound')); ?> (lb)</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-4">
                <div class="form-group mb-0">
                    <label class="input-label" for="dimension_unit"><?php echo e(translate('Dimension unit')); ?>

                        <span class="text-danger">*</span>
                    </label>
                    <select name="dimension_unit" id="dimension_unit"
                        class="form-control js-select2-custom h--45px">
                        <option value="cm" <?php echo e($dimensionUnit === 'cm' ? 'selected' : ''); ?>>
                            <?php echo e(translate('messages.Centimetre')); ?> (cm)</option>
                        <option value="in" <?php echo e($dimensionUnit === 'in' ? 'selected' : ''); ?>>
                            <?php echo e(translate('messages.Inch')); ?> (in)</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="rule-hint mb-0">
                    <img src="<?php echo e(asset('public/assets/admin/img/svg/bulb.svg')); ?>" class="svg" alt="">
                    <span><?php echo e(translate('Rates, coverage areas, weight classes and dimension classes are stored exactly as you typed them. Changing a unit changes what those numbers mean, not the numbers themselves.')); ?></span>
                </div>
            </div>
        </div>


    </div>
</div>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/admin-views/business-settings/settings/partials/_measurement-units.blade.php ENDPATH**/ ?>