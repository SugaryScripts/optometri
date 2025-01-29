<!doctype html>
<html lang="en">
<!-- When there is no desire, all things are at peace. - Laozi -->
<!-- [Head] start -->

<head>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
        name="description"
        content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies."
    />
    <meta
        name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard"
    />
    <meta name="author" content="Phoenixcoded" />

    <title>{{ $page_title }}</title>

    <x-layout.core.style />

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true"
      data-pc-layout="vertical" data-pc-direction="ltr"
      data-pc-theme_contrast="true" data-pc-theme="dark">

<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->
<!-- [ Sidebar Menu ] start -->
<x-layout.sidebar />
<!-- [ Sidebar Menu ] end -->
<!-- [ Header Topbar ] start -->
<x-layout.header />
<!-- [ Header ] end -->



<!-- [ Main Content ] start -->
<div class="pc-container">
    <!-- [ Main Content ] start -->
    {{ $slot }}
    <!-- [ Main Content ] end -->
</div>
<!-- [ Main Content ] end -->

<x-layout.footer />

<x-layout.core.script />


</body>
<!-- [Body] end -->
</html>
