<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use App\Models\Faq;
use App\Models\Fee;
use App\Models\News;
use App\Models\ProgramStudy;
use App\Models\RegistrationPath;
use App\Models\RegistrationStep;
use App\Models\RegistrationWave;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@rosma.ac.id'],
            [
                'name' => 'Admin PMB STMIK ROSMA',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        User::firstOrCreate(
            ['email' => 'calon@rosma.ac.id'],
            [
                'name' => 'Calon Mahasiswa',
                'password' => bcrypt('password123'),
                'role' => 'applicant',
                'phone' => '081298765432',
            ]
        );

        ContactSetting::query()->delete();
        ContactSetting::create([
            'admin_name' => 'Admin PMB STMIK ROSMA',
            'whatsapp_number' => '6281234567890',
            'whatsapp_message' => 'Halo Admin PMB STMIK ROSMA, saya ingin mendapatkan informasi mengenai pendaftaran mahasiswa baru.',
            'status' => 'active',
        ]);

        $programs = [
            ['name' => 'Teknik Informatika', 'level' => 'S1', 'code' => 'TI', 'accreditation' => 'A', 'sort_order' => 1],
            ['name' => 'Sistem Informasi', 'level' => 'S1', 'code' => 'SI', 'accreditation' => 'A', 'sort_order' => 2],
            ['name' => 'Manajemen Informatika', 'level' => 'D3', 'code' => 'MI', 'accreditation' => 'B', 'sort_order' => 3],
            ['name' => 'Komputerisasi Akuntansi', 'level' => 'D3', 'code' => 'KA', 'accreditation' => 'B', 'sort_order' => 4],
        ];

        $studyList = [];
        foreach ($programs as $program) {
            $studyList[] = ProgramStudy::firstOrCreate(
                ['slug' => Str::slug($program['name'])],
                [
                    'name' => $program['name'],
                    'slug' => Str::slug($program['name']),
                    'level' => $program['level'],
                    'code' => $program['code'],
                    'description' => 'Program studi unggulan dengan kurikulum yang relevan dengan kebutuhan industri digital.',
                    'accreditation' => $program['accreditation'],
                    'status' => 'active',
                    'sort_order' => $program['sort_order'],
                ]
            );
        }

        $paths = [
            ['name' => 'Reguler', 'description' => 'Jalur Reguler untuk lulusan SMA/SMK sederajat', 'sort_order' => 1],
            ['name' => 'Ekstensi', 'description' => 'Jalur Ekstensi Kelas Karyawan (Hybrid)', 'sort_order' => 2],
            ['name' => 'RPL', 'description' => 'Jalur Rekognisi Pembelajaran Lampau / Pengalaman Kerja', 'sort_order' => 3],
            ['name' => 'Beasiswa KIP Kuliah', 'description' => 'Program Beasiswa Kartu Indonesia Pintar dari Pemerintah', 'sort_order' => 4],
            ['name' => 'Beasiswa YAPEROS', 'description' => 'Program Beasiswa dari Yayasan Pendidikan Rosma', 'sort_order' => 5],
        ];

        $pathList = [];
        foreach ($paths as $path) {
            $pathList[] = RegistrationPath::firstOrCreate(
                ['name' => $path['name']],
                ['name' => $path['name'], 'description' => 'Jalur pendaftaran '.$path['name'], 'status' => 'active', 'sort_order' => $path['sort_order']]
            );
        }

        $waves = [
            ['name' => 'Gelombang 1', 'academic_year' => '2026/2027', 'start_date' => '2026-01-01', 'end_date' => '2026-03-31', 'sort_order' => 1],
            ['name' => 'Gelombang 2', 'academic_year' => '2026/2027', 'start_date' => '2026-04-01', 'end_date' => '2026-06-30', 'sort_order' => 2],
        ];

        $waveList = [];
        foreach ($waves as $wave) {
            $waveList[] = RegistrationWave::firstOrCreate(
                ['name' => $wave['name'], 'academic_year' => $wave['academic_year']],
                [
                    'name' => $wave['name'],
                    'academic_year' => $wave['academic_year'],
                    'start_date' => $wave['start_date'],
                    'end_date' => $wave['end_date'],
                    'status' => 'active',
                    'sort_order' => $wave['sort_order'],
                ]
            );
        }

        $steps = [
            ['name' => 'Pendaftaran', 'description' => 'Membuat akun dan mengisi data awal.', 'sort_order' => 1, 'icon' => 'bi-pen', 'color' => '#2563EB'],
            ['name' => 'Lengkapi Data', 'description' => 'Mengisi biodata dan pendidikan.', 'sort_order' => 2, 'icon' => 'bi-person-lines-fill', 'color' => '#0B1F3A'],
            ['name' => 'Upload Dokumen', 'description' => 'Mengunggah dokumen persyaratan.', 'sort_order' => 3, 'icon' => 'bi-upload', 'color' => '#0EA5E9'],
            ['name' => 'Pembayaran', 'description' => 'Melakukan pembayaran biaya pendaftaran.', 'sort_order' => 4, 'icon' => 'bi-credit-card', 'color' => '#16A34A'],
            ['name' => 'Verifikasi', 'description' => 'Tim PMB memeriksa berkas dan pembayaran.', 'sort_order' => 5, 'icon' => 'bi-check-circle', 'color' => '#F59E0B'],
            ['name' => 'Pengumuman', 'description' => 'Informasi hasil seleksi dan penerimaan.', 'sort_order' => 6, 'icon' => 'bi-megaphone', 'color' => '#7C3AED'],
        ];

        foreach ($steps as $step) {
            RegistrationStep::firstOrCreate(
                ['name' => $step['name']],
                [
                    'name' => $step['name'],
                    'description' => $step['description'],
                    'status' => 'active',
                    'sort_order' => $step['sort_order'],
                    'icon' => $step['icon'],
                    'color' => $step['color'],
                ]
            );
        }

        foreach ($studyList as $study) {
            foreach ($pathList as $path) {
                foreach ($waveList as $wave) {
                    Fee::firstOrCreate(
                        [
                            'program_study_id' => $study->id,
                            'registration_path_id' => $path->id,
                            'registration_wave_id' => $wave->id,
                            'name' => 'Registrasi',
                        ],
                        [
                            'program_study_id' => $study->id,
                            'registration_path_id' => $path->id,
                            'registration_wave_id' => $wave->id,
                            'name' => 'Registrasi',
                            'amount' => 1500000,
                            'start_date' => $wave->start_date,
                            'end_date' => $wave->end_date,
                            'status' => 'active',
                            'sort_order' => 1,
                        ]
                    );

                    Fee::firstOrCreate(
                        [
                            'program_study_id' => $study->id,
                            'registration_path_id' => $path->id,
                            'registration_wave_id' => $wave->id,
                            'name' => 'Tahap 2',
                        ],
                        [
                            'program_study_id' => $study->id,
                            'registration_path_id' => $path->id,
                            'registration_wave_id' => $wave->id,
                            'name' => 'Tahap 2',
                            'amount' => 2500000,
                            'start_date' => $wave->start_date,
                            'end_date' => $wave->end_date,
                            'status' => 'active',
                            'sort_order' => 2,
                        ]
                    );

                    Fee::firstOrCreate(
                        [
                            'program_study_id' => $study->id,
                            'registration_path_id' => $path->id,
                            'registration_wave_id' => $wave->id,
                            'name' => 'Tahap 3',
                        ],
                        [
                            'program_study_id' => $study->id,
                            'registration_path_id' => $path->id,
                            'registration_wave_id' => $wave->id,
                            'name' => 'Tahap 3',
                            'amount' => 3500000,
                            'start_date' => $wave->start_date,
                            'end_date' => $wave->end_date,
                            'status' => 'active',
                            'sort_order' => 3,
                        ]
                    );
                }
            }
        }

        $newsItems = [
            ['title' => 'Persyaratan PMB 2026/2027 Diperbarui', 'content' => 'Informasi terbaru mengenai persyaratan dokumen PMB telah diperbarui. Pastikan calon mahasiswa membaca setiap ketentuan dengan seksama.', 'published_at' => '2026-09-01'],
            ['title' => 'Jadwal Pendaftaran Gelombang 2 Sudah Dibuka', 'content' => 'Gelombang 2 penerimaan mahasiswa baru dibuka mulai bulan April 2026. Calon mahasiswa dapat segera menyiapkan dokumen persyaratan.', 'published_at' => '2026-08-12'],
            ['title' => 'Kegiatan Campus Day STMIK ROSMA', 'content' => 'STMIK ROSMA menyelenggarakan campus day sebagai ajang pengenalan program studi dan lingkungan kampus.', 'published_at' => '2026-07-18'],
        ];

        foreach ($newsItems as $item) {
            News::firstOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']),
                    'content' => $item['content'],
                    'status' => 'published',
                    'published_at' => $item['published_at'],
                ]
            );
        }

        $faqs = [
            ['question' => 'Apakah pendaftaran bisa dilakukan secara online?', 'answer' => 'Ya, seluruh proses pendaftaran dapat dilakukan secara online melalui platform PMB STMIK ROSMA.', 'sort_order' => 1],
            ['question' => 'Bagaimana cara mengecek status pendaftaran?', 'answer' => 'Anda dapat login ke akun calon mahasiswa dan masuk ke halaman dashboard untuk melihat status pendaftaran.', 'sort_order' => 2],
            ['question' => 'Apakah terdapat jalur beasiswa?', 'answer' => 'Ya, STMIK ROSMA menyediakan jalur beasiswa dan prestasi sesuai ketentuan yang berlaku.', 'sort_order' => 3],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                [
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'status' => 'active',
                    'sort_order' => $faq['sort_order'],
                ]
            );
        }
    }
}
