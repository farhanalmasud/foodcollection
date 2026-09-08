<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title')
    </title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- Viewport-->
    <meta name="_token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="shortcut icon" href="favicon.ico">
    <!-- Font -->
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/vendor.min.css">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/vendor/icon-set/style.css">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/custom.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/theme.minc619.css?v=1.0">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/style.css">

    <script
        src="{{asset('public/assets/admin')}}/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script>
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/toastr.css">
</head>
<!-- Body-->
<body class="toolbar-enabled">
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        
        <section class="col-lg-12">
            <div class="checkout_details mt-3">
                <div style="justify-content: center;" class="row">

                    <center>
                    <br>
                    <div class='loader'></div>
                    <br>
                    <input id="invoiceId" type="hidden" value="{{ $data['invoice_id'] }}">
                    <h2 style="color:red;">Do not close app</h2>
                    <p id="paymentVerify"><span>Please wait.Verifying your payment.</span><br><span>After payment verify it will auto redirect you.....</span></p>
                    </center>

                </div>
            </div>
        </section>
    </div>
</div>

<!-- JS Front -->
<script src="{{asset('public/assets/admin')}}/js/custom.js"></script>
<script src="{{asset('public/assets/admin')}}/js/vendor.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/admin')}}/js/sweet_alert.js"></script>
<script src="{{asset('public/assets/admin')}}/js/toastr.js"></script>
<script src="{{asset('public/assets/admin')}}/js/bootstrap.min.js"></script>

{!! Toastr::message() !!}




<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    VerifyPayment();
    function VerifyPayment() {
        var invoiceId = document.getElementById("invoiceId").value;
        
        $('#loading').show();
        // get token
        $.ajax({
                url: '{{ route('uddoktapay.verifyPayment') }}',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    "invoice_id": invoiceId
                }),
                success: function (data) {
                    // console.log(data);
                    $('#loading').hide();
                    var status = data.status;
                    
                    if(status === "COMPLETED")
                    {
                     
                    var tranId = data.metadata.tran_id;
                    var url = "{{ route('uddoktapay.completePayment', ['tran_id' => ':tranId'] ) }}";
                    url = url.replace('%3AtranId', tranId);
                    window.location = url;
                      
                    }else if(status === "PENDING")
                    {
                        var tranId = data.metadata.tran_id;
                        var url = "{{ route('uddoktapay.failedPayment', ['tran_id' => ':tranId'] ) }}";
                        url = url.replace('%3AtranId', tranId);
                        window.location = url;
                    }else
                    {
                        var tranId = data.metadata.tran_id;
                        var url = "{{ route('uddoktapay.failedPayment', ['tran_id' => ':tranId'] ) }}";
                        url = url.replace('%3AtranId', tranId);
                        window.location = url;
                    }
                },
            error: function (err) {
                console.log(err);
                $('#loading').hide();
                showErrorMessage(err);
            }
        });
    }

    function showErrorMessage(response) {
        let message = 'Unknown Error';
        if (response.hasOwnProperty('errorMessage')) {
            let errorCode = parseInt(response.errorCode);
            let bkashErrorCode = [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014,
                2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030,
                2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039, 2040, 2041, 2042, 2043, 2044, 2045, 2046,
                2047, 2048, 2049, 2050, 2051, 2052, 2053, 2054, 2055, 2056, 2057, 2058, 2059, 2060, 2061, 2062,
                2063, 2064, 2065, 2066, 2067, 2068, 2069, 503,
            ];
            if (bkashErrorCode.includes(errorCode)) {
                message = response.errorMessage
            }
        }
        Swal.fire("Payment Failed!", message, "error");
    }
</script>

</body>
</html>