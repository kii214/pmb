<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$banners = App\Models\Banner::all();
echo "Total banners: " . $banners->count() . "\n";
foreach($banners as $b) {
    echo "ID: {$b->id} | Title: {$b->title} | Status: {$b->status} | Active: " . ($b->is_active ?? 'N/A') . "\n";
}
