<?php $__env->startSection('title',\App\CentralLogics\Helpers::get_business_settings('business_name', false)??translate('Dashboard')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <?php if(auth('admin')->user()->role_id == 1 || \App\CentralLogics\Helpers::module_permission_check('dashboard')): ?>
        <div class="page-header">
            <div class="row align-items-center py-2">
                <div class="col-sm mb-2 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <img class="onerror-image" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/grocery.svg')); ?>" src="<?php echo e(Config::get('module.current_module_icon')); ?>"
                        width="38" alt="img">
                        <div class="w-0 flex-grow pl-2">
                            <h1 class="page-header-title mb-0"><?php echo e(translate(Config::get('module.current_module_name'))); ?> <?php echo e(translate('Dashboard')); ?>.</h1>
                            <p class="page-header-desc"><?php echo e(translate('Today\'s orders, earnings and anything waiting on you, across this module.')); ?></p>
                            <p class="page-header-text m-0"><?php echo e(translate('Hello, here you can manage your orders by zone.')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-auto min--280">
                    <select name="zone_id" class="form-control js-select2-custom fetch_data_zone_wise" >
                        <option value="all"><?php echo e(translate('All zones')); ?></option>
                        <?php $__currentLoopData = \App\CentralLogics\Helpers::zones_dropdown(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($zone['id']); ?>" <?php echo e($params['zone_id'] == $zone['id']?'selected':''); ?>>
                                <?php echo e($zone['name']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body pt-0">
                <div class="d-flex flex-wrap align-items-center justify-content-end">
                    <div class="status-filter-wrap">
                        <div class="statistics-btn-grp">
                            <label>
                                <input type="radio" name="statistics" value="this_year" <?php echo e($params['statistics_type'] == 'this_year'?'checked':''); ?> class="order_stats_update" hidden>
                                <span><?php echo e(translate('This year')); ?></span>
                            </label>
                            <label>
                                <input type="radio" name="statistics" value="this_month" <?php echo e($params['statistics_type'] == 'this_month'?'checked':''); ?> class="order_stats_update" hidden>
                                <span><?php echo e(translate('This month')); ?></span>
                            </label>
                            <label>
                                <input type="radio" name="statistics" value="this_week" <?php echo e($params['statistics_type'] == 'this_week'?'checked':''); ?> class="order_stats_update" hidden>
                                <span><?php echo e(translate('This week')); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row g-2" id="order_stats">
                    <div class="col-sm-6 col-lg-3">
                        <div class="__dashboard-card-2">
                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/items.svg')); ?>" alt="dashboard/grocery">
                            <h6 class="name"><?php echo e(translate('messages.Items')); ?></h6>
                            <h3 class="count"><?php echo e($data['total_items']); ?></h3>
                            <div class="subtxt"><?php echo e($data['new_items']); ?> <?php echo e(translate('newly added')); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="__dashboard-card-2">
                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/orders.svg')); ?>" alt="dashboard/grocery">
                            <h6 class="name"><?php echo e(translate('messages.Orders')); ?></h6>
                            <h3 class="count"><?php echo e($data['total_orders']); ?></h3>
                            <div class="subtxt"><?php echo e($data['new_orders']); ?> <?php echo e(translate('newly added')); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="__dashboard-card-2">
                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/stores.svg')); ?>" alt="dashboard/grocery">
                            <h6 class="name"><?php echo e(translate('Grocery stores')); ?></h6>
                            <h3 class="count"><?php echo e($data['total_stores']); ?></h3>
                            <div class="subtxt"><?php echo e($data['new_stores']); ?> <?php echo e(translate('newly added')); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="__dashboard-card-2">
                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/customers.svg')); ?>" alt="dashboard/grocery">
                            <h6 class="name"><?php echo e(translate('messages.customers')); ?></h6>
                            <h3 class="count"><?php echo e($data['total_customers']); ?></h3>
                            <div class="subtxt"><?php echo e($data['new_customers']); ?> <?php echo e(translate('newly added')); ?></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-2">
                            <div class="col-sm-6 col-lg-3">
                                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['searching_for_deliverymen'])); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center text-hover--primary">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/unassigned.svg')); ?>" alt="dashboard" class="oder--card-icon">
                                            <span><?php echo e(translate('messages.Unassigned orders')); ?></span>
                                        </h6>
                                        <span class="card-title text-3F8CE8">
                                            <?php echo e($data['searching_for_dm']); ?>

                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['accepted'])); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center text-hover--primary">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/accepted.svg')); ?>" alt="dashboard" class="oder--card-icon">
                                            <span><?php echo e(translate('Accepted by deliveryman')); ?></span>
                                        </h6>
                                        <span class="card-title text-success">
                                            <?php echo e($data['accepted_by_dm']); ?>

                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['processing'])); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center text-hover--primary">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/packaging.svg')); ?>" alt="dashboard" class="oder--card-icon">
                                            <span><?php echo e(translate('Packaging')); ?></span>
                                        </h6>
                                        <span class="card-title text-FFA800">
                                            <?php echo e($data['preparing_in_rs']); ?>

                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['item_on_the_way'])); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center text-hover--primary">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/out-for.svg')); ?>" alt="dashboard" class="oder--card-icon">
                                            <span><?php echo e(translate('Out for delivery')); ?></span>
                                        </h6>
                                        <span class="card-title text-success">
                                            <?php echo e($data['picked_up']); ?>

                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['delivered'])); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center text-hover--primary">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/delivered.svg')); ?>" alt="dashboard" class="oder--card-icon">
                                            <span><?php echo e(translate('Delivered')); ?></span>
                                        </h6>
                                        <span class="card-title text-success">
                                            <?php echo e($data['delivered']); ?>

                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['canceled'])); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center text-hover--primary">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/order-status/canceled.svg')); ?>" alt="dashboard" class="oder--card-icon">
                                            <span><?php echo e(translate('Canceled')); ?></span>
                                        </h6>
                                        <span class="card-title text-danger">
                                            <?php echo e($data['canceled']); ?>

                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['refunded'])); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center text-hover--primary">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/order-status/refunded.svg')); ?>" alt="dashboard" class="oder--card-icon">
                                            <span><?php echo e(translate('Refunded')); ?></span>
                                        </h6>
                                        <span class="card-title text-danger">
                                            <?php echo e($data['refunded']); ?>

                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['failed'])); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center text-hover--primary">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/order-status/payment-failed.svg')); ?>" alt="dashboard" class="oder--card-icon">
                                            <span><?php echo e(translate('Payment failed')); ?></span>
                                        </h6>
                                        <span class="card-title text-danger">
                                            <?php echo e($data['refund_requested']); ?>

                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row g-2">
            <div class="col-lg-8 col--xl-8">
                <div class="card h-100">
                    <div class="card-body" id="sales-chart-section">
                        <div class="d-flex flex-wrap justify-content-between align-items-center __gap-12px">
                            <div class="__gross-amount" id="gross_sale">
                                <h6><?php echo e(\App\CentralLogics\Helpers::format_currency(array_sum($total_sell))); ?></h6>
                                <span><?php echo e(translate('Gross sale')); ?></span>
                            </div>
                            <div class="chart--label __chart-label p-0 move-left-100 ml-auto">
                                <span class="indicator chart-bg-2"></span>
                                <span class="info">
                                    <?php echo e(translate('sale')); ?> (<?php echo e(date("Y")); ?>)
                                </span>
                            </div>
                            <select class="custom-select border-0 text-center w-auto ml-auto commission_overview_stats_update" name="commission_overview">
                                    <option
                                    value="this_year" <?php echo e($params['commission_overview'] == 'this_year'?'selected':''); ?>>
                                    <?php echo e(translate('This year')); ?>

                                </option>
                                <option
                                    value="this_month" <?php echo e($params['commission_overview'] == 'this_month'?'selected':''); ?>>
                                    <?php echo e(translate('This month')); ?>

                                </option>
                                <option
                                    value="this_week" <?php echo e($params['commission_overview'] == 'this_week'?'selected':''); ?>>
                                    <?php echo e(translate('This week')); ?>

                                </option>
                            </select>
                        </div>
                        <div id="commission-overview-board">

                            <div id="grow-sale-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col--xl-4">
                <div class="card h-100">
                    <div class="card-header border-0">
                        <h5 class="card-header-title">
                            <?php echo e(translate('User statistics')); ?>

                        </h5>
                        <div id="stat_zone">

                            <?php echo $__env->make('admin-views.partials._zone-change',['data'=>$data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


                        </div>
                        <select class="custom-select border-0 text-center w-auto user_overview_stats_update" name="user_overview">
                                <option
                                value="this_year" <?php echo e($params['user_overview'] == 'this_year'?'selected':''); ?>>
                                <?php echo e(translate('This year')); ?>

                            </option>
                            <option
                                value="this_month" <?php echo e($params['user_overview'] == 'this_month'?'selected':''); ?>>
                                <?php echo e(translate('This month')); ?>

                            </option>
                            <option
                                value="this_week" <?php echo e($params['user_overview'] == 'this_week'?'selected':''); ?>>
                                <?php echo e(translate('This week')); ?>

                            </option>
                            <option
                                value="overall" <?php echo e($params['user_overview'] == 'overall'?'selected':''); ?>>
                                <?php echo e(translate('messages.Overall')); ?>

                            </option>
                        </select>
                    </div>

                    <div class="card-body" id="user-overview-board">
                        <div class="position-relative pie-chart">
                            <div id="dognut-pie"></div>
                            <div class="total--orders">
                                <h3 class="text-uppercase mb-xxl-2"><?php echo e($data['customer'] + $data['stores'] + $data['delivery_man']); ?></h3>
                                <span class="text-capitalize"><?php echo e(translate('messages.Total users')); ?></span>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-center mt-4">
                            <div class="chart--label">
                                <span class="indicator chart-bg-1"></span>
                                <span class="info">
                                    <?php echo e(translate('messages.Customer')); ?> <?php echo e($data['customer']); ?>

                                </span>
                            </div>
                            <div class="chart--label">
                                <span class="indicator chart-bg-2"></span>
                                <span class="info">
                                    <?php echo e(translate('messages.Store')); ?> <?php echo e($data['stores']); ?>

                                </span>
                            </div>
                            <div class="chart--label">
                                <span class="indicator chart-bg-3"></span>
                                <span class="info">
                                    <?php echo e(translate('Deliveryman')); ?> <?php echo e($data['delivery_man']); ?>

                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100" id="top-restaurants-view">
                    <?php echo $__env->make('admin-views.partials._top-restaurants',['top_restaurants'=>$data['top_restaurants']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100" id="popular-restaurants-view">
                    <?php echo $__env->make('admin-views.partials._popular-restaurants',['popular'=>$data['popular']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100" id="top-selling-foods-view">
                    <?php echo $__env->make('admin-views.partials._top-selling-foods',['top_sell'=>$data['top_sell']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100" id="top-rated-foods-view">
                    <?php echo $__env->make('admin-views.partials._top-rated-foods',['top_rated_foods'=>$data['top_rated_foods']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100" id="top-deliveryman-view">
                    <?php echo $__env->make('admin-views.partials._top-deliveryman',['top_deliveryman'=>$data['top_deliveryman']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card h-100" id="top-customer-view">
                    <?php echo $__env->make('admin-views.partials._top-customer',['top_customers'=>$data['top_customers']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

        </div>
        <?php else: ?>
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><?php echo e(translate('messages.welcome')); ?>, <?php echo e(auth('admin')->user()->f_name); ?>.</h1>
                    <p class="page-header-desc"><?php echo e(translate('Today\'s orders, earnings and anything waiting on you, across this module.')); ?></p>
                    <p class="page-header-text"><?php echo e(translate('messages.Employee welcome message')); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>

    <script src="<?php echo e(asset('/public/assets/admin/js/apex-charts/apexcharts.js')); ?>"></script>

<?php $__env->stopPush(); ?>


<?php $__env->startPush('script_2'); ?>

    <script>
        "use strict";
        let options;
        let chart;
        options = {
            series: [<?php echo e($data['customer']); ?>, <?php echo e($data['stores']); ?>, <?php echo e($data['delivery_man']); ?>],
            chart: {
                width: 320,
                type: 'donut',
            },
            labels: ['<?php echo e(translate('Customer')); ?>', '<?php echo e(translate('Store')); ?>', '<?php echo e(translate('Deliveryman')); ?>'],
            dataLabels: {
                enabled: false,
                style: {
                    colors: ['#005555', '#00aa96', '#b9e0e0',]
                }
            },
            responsive: [{
                breakpoint: 1650,
                options: {
                    chart: {
                        width: 250
                    },
                }
            }],
            colors: ['#005555','#00aa96', '#111'],
            fill: {
                colors: ['#005555','#00aa96', '#b9e0e0']
            },
            legend: {
                show: false
            },
        };

        chart = new ApexCharts(document.querySelector("#dognut-pie"), options);
        chart.render();


        options = {
            series: [{
                name: '<?php echo e(translate('Gross sale')); ?>',
                data: [<?php echo e(implode(",",$total_sell)); ?>]
            },{
                name: '<?php echo e(translate('Admin commission')); ?>',
                data: [<?php echo e(implode(",",$commission)); ?>]
            },{
                name: '<?php echo e(translate('Delivery commission')); ?>',
                data: [<?php echo e(implode(",",$delivery_commission)); ?>]
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show:false
                },
                colors: ['#76ffcd','#ff6d6d', '#005555'],
            },
            colors: ['#76ffcd','#ff6d6d', '#005555'],
            dataLabels: {
                enabled: false,
                colors: ['#76ffcd','#ff6d6d', '#005555'],
            },
            stroke: {
                curve: 'smooth',
                width: 2,
                colors: ['#76ffcd','#ff6d6d', '#005555'],
            },
            fill: {
                type: 'gradient',
                colors: ['#76ffcd','#ff6d6d', '#005555'],
            },
            xaxis: {
                //   type: 'datetime',
                categories: [<?php echo implode(",",$label); ?>]
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
        };

        chart = new ApexCharts(document.querySelector("#grow-sale-chart"), options);
        chart.render();


    <!-- Dognut Pie Chart -->

        // INITIALIZATION OF CHARTJS
        // =======================================================
        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function () {
            $.HSCore.components.HSChartJS.init($(this));
        });

        let updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));


        $('.order_stats_update').on('change', function (){
            let type = $(this).val();
            order_stats_update(type);
        })

        function order_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.dashboard-stats.order')); ?>',
                data: {
                    statistics_type: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('statistics_type',type);
                    $('#order_stats').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        $('.fetch_data_zone_wise').on('change', function (){
            let zone_id = $(this).val();
            fetch_data_zone_wise(zone_id);
        })


        function fetch_data_zone_wise(zone_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.dashboard-stats.zone')); ?>',
                data: {
                    zone_id: zone_id
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('zone_id', zone_id);
                    $('#order_stats').html(data.order_stats);
                    $('#user-overview-board').html(data.user_overview);
                    $('#sales-chart-section').html(data.monthly_graph);
                    $('#popular-restaurants-view').html(data.popular_restaurants);
                    $('#top-deliveryman-view').html(data.top_deliveryman);
                    $('#top-rated-foods-view').html(data.top_rated_foods);
                    $('#top-restaurants-view').html(data.top_restaurants);
                    $('#top-selling-foods-view').html(data.top_selling_foods);
                    $('#stat_zone').html(data.stat_zone);
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        $('.user_overview_stats_update').on('change', function (){
            let type = $(this).val();
            user_overview_stats_update(type);
        })


        function user_overview_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.dashboard-stats.user-overview')); ?>',
                data: {
                    user_overview: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('user_overview',type);
                    $('#user-overview-board').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        $('.commission_overview_stats_update').on('change', function (){
            let type = $(this).val();
            commission_overview_stats_update(type);
        })


        function commission_overview_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.dashboard-stats.commission-overview')); ?>',
                data: {
                    commission_overview: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('commission_overview',type);
                    $('#commission-overview-board').html(data.view)
                    $('#gross_sale').html(data.gross_sale)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        function insert_param(key, value) {
            key = encodeURIComponent(key);
            value = encodeURIComponent(value);
            // kvp looks like ['key1=value1', 'key2=value2', ...]
            let kvp = document.location.search.substr(1).split('&');
            let i = 0;

            for (; i < kvp.length; i++) {
                if (kvp[i].startsWith(key + '=')) {
                    let pair = kvp[i].split('=');
                    pair[1] = value;
                    kvp[i] = pair.join('=');
                    break;
                }
            }
            if (i >= kvp.length) {
                kvp[kvp.length] = [key, value].join('=');
            }
            // can return this or...
            let params = kvp.join('&');
            // change url page with new params
            window.history.pushState('page2', 'Title', '<?php echo e(url()->current()); ?>?' + params);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/admin-views/dashboard-grocery.blade.php ENDPATH**/ ?>