<?php
    use App\CentralLogics\Helpers;
    use App\Models\SocialMedia;

    $businessName = Helpers::get_settings('business_name');
    $title = ($metaData['meta_title'] ?? null)?->getRawOriginal('value') ?? $businessName;
    $description = ($metaData['meta_description'] ?? null)?->getRawOriginal('value') ?? $businessName . ' — best platform for your needs.';
    $image = Helpers::get_full_url(
        'landing/meta_image',
        $metaData['meta_image']?->value ?? '',
        $metaData['meta_image']?->storage[0]?->value ?? 'public',
        'upload_image'
    );
    $url = url()->current();
    $home = url('/');
    $locale = app()->getLocale();
    $logo = Helpers::logoFullUrl();
    $phone = Helpers::get_settings('phone');
    $email = Helpers::get_settings('email_address');
    $address = Helpers::get_settings('address');
    $updatedTime = collect($metaData)->filter()->max(fn ($item) => $item->updated_at)?->toIso8601String();
    $sameAs = SocialMedia::where('status', 1)->pluck('link')->filter()->values()->all();

    $organization = array_filter([
        '@type' => 'Organization',
        '@id' => $home . '#organization',
        'name' => $businessName,
        'url' => $home,
        'logo' => $logo,
        'email' => $email ?: null,
        'address' => $address ?: null,
        'contactPoint' => $phone ? [
            '@type' => 'ContactPoint',
            'telephone' => $phone,
            'contactType' => 'customer service',
        ] : null,
        'sameAs' => $sameAs ?: null,
    ]);

    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            $organization,
            [
                '@type' => 'WebSite',
                '@id' => $home . '#website',
                'url' => $home,
                'name' => $businessName,
                'inLanguage' => $locale,
                'publisher' => ['@id' => $home . '#organization'],
            ],
            [
                '@type' => 'WebPage',
                '@id' => $url . '#webpage',
                'url' => $url,
                'name' => $title,
                'description' => $description,
                'inLanguage' => $locale,
                'isPartOf' => ['@id' => $home . '#website'],
            ],
        ],
    ];
?>

<meta name="description" content="<?php echo e($description); ?>">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
<meta name="author" content="<?php echo e($businessName); ?>">
<link rel="canonical" href="<?php echo e($url); ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?php echo e($businessName); ?>">
<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($description); ?>">
<meta property="og:url" content="<?php echo e($url); ?>">
<meta property="og:locale" content="<?php echo e($locale); ?>">
<?php if($updatedTime): ?>
<meta property="og:updated_time" content="<?php echo e($updatedTime); ?>">
<?php endif; ?>
<?php if($image): ?>
<meta property="og:image" content="<?php echo e($image); ?>">
<meta property="og:image:secure_url" content="<?php echo e($image); ?>">
<meta property="og:image:alt" content="<?php echo e($description); ?>">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<?php endif; ?>
<meta property="fb:app_id" content="<?php echo e(config('services.facebook.app_id') ?? ''); ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($title); ?>">
<meta name="twitter:description" content="<?php echo e($description); ?>">
<meta name="twitter:url" content="<?php echo e($url); ?>">
<?php if($image): ?>
<meta name="twitter:image" content="<?php echo e($image); ?>">
<meta name="twitter:image:alt" content="<?php echo e($description); ?>">
<?php endif; ?>
<meta name="twitter:site" content="<?php echo e(config('services.twitter.handle') ?? ''); ?>">
<meta name="twitter:creator" content="<?php echo e(config('services.twitter.handle') ?? ''); ?>">

<meta name="theme-color" content="#ffffff">
<meta name="application-name" content="<?php echo e($businessName); ?>">
<meta name="apple-mobile-web-app-title" content="<?php echo e($businessName); ?>">

<script type="application/ld+json">
<?php echo json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>

</script>
<?php /**PATH /home/foodcol2/portal.foodcollections.com/resources/views/layouts/landing/_seo.blade.php ENDPATH**/ ?>