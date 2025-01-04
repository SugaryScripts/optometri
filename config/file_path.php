<?php
/**
 * usage: config('file_path.about')
 * Run this on shell linux for seeder image
 * for dir in cms_carousel_images cms_article_images cms_publication_images cms_service_images cms_about konservasi_pendahuluan konservasi_dokumentasi konservasi_peta peta_informatif pjl_anggota_map; do [ -d "$dir" ] || mkdir "$dir"; done
 */
return [
    //env('PRODUCTS_IMAGE_PATH', 'storage/images/products/'),
    'product' => 'product/',
    'brand' => 'brand/',
];
