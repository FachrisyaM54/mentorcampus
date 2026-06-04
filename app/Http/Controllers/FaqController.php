<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqCategories = [

            "Umum" => [
                [
                    "q" => "Apa itu sebenarnya MentorCampus?",
                    "a" => "MentorCampus adalah platform jembatan akademik yang memungkinkan mahasiswa (Student) belajar langsung dari kakak tingkat atau sesama mahasiswa (Mentor) yang lebih berpengalaman."
                ],
                [
                    "q" => "Bagaimana cara kerja sistem booking di sini?",
                    "a" => "Sederhana: Cari mentor -> Pilih jadwal tersedia -> Tunggu konfirmasi -> Lakukan sesi mentoring sesuai waktu yang disepakati."
                ],
                [
                    "q" => "Apakah data pribadi saya aman?",
                    "a" => "Tentu saja. Kami menggunakan enkripsi standar industri untuk melindungi data profil dan riwayat booking Anda."
                ]
            ],

            "Untuk Student" => [
                [
                    "q" => "Bagaimana jika mentor tidak muncul saat sesi?",
                    "a" => "Jika mentor tidak hadir dalam 15 menit, Anda dapat melaporkannya melalui menu riwayat untuk pengembalian poin atau jadwal ulang."
                ],
                [
                    "q" => "Berapa lama durasi rata-rata satu sesi?",
                    "a" => "Standar durasi adalah 60 hingga 90 menit, namun bervariasi tergantung pengaturan mentor."
                ]
            ],

            "Untuk Mentor" => [
                [
                    "q" => "Bagaimana cara menjadi mentor?",
                    "a" => "Lengkapi data Mentor Profile termasuk CV di menu Profile. Admin akan memverifikasi akun Anda."
                ],
                [
                    "q" => "Bagaimana sistem pencairan dana?",
                    "a" => "Setiap sesi selesai akan menambah saldo. Pencairan dilakukan setiap akhir bulan ke rekening terdaftar."
                ]
            ]
        ];

        return view('faq.index', compact('faqCategories'));
    }
}
