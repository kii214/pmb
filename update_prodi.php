<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$updated = App\Models\ProgramStudy::where('name', 'Teknik Informatika')->update([
    'accreditation_certificate_url' => 'https://drive.google.com/uc?export=download&id=1uHO1IUCpozmpsDVMkpOYIFYJTym6gI6A',
]);

echo "Teknik Informatika certificate URL updated: $updated row(s)\n";
