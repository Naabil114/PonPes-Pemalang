<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['santri', 'admin_putra', 'admin_putri', 'super_admin']);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Madrasah
        Schema::create('madrasah', function (Blueprint $table) {
            $table->bigIncrements('id_madrasah');
            $table->enum('nama_madrasah', ['TPQ', 'Awaliyah', 'Diniyah', 'Wustho']);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Kamar
        Schema::create('kamar', function (Blueprint $table) {
            $table->bigIncrements('id_kamar');
            $table->string('nomor_kamar', 10)->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('kapasitas')->default(20);
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();
        });

        // Santri
        Schema::create('santri', function (Blueprint $table) {
            $table->bigIncrements('id_santri');
            $table->unsignedBigInteger('user_id')->unique(); 

            $table->string('nis', 20)->unique();
            $table->string('nama_santri', 100);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nama_orang_tua', 100);
            $table->string('no_telp', 15)->unique();
            $table->text('alamat');
            $table->unsignedBigInteger('id_madrasah')->nullable();
            $table->unsignedBigInteger('id_kamar')->nullable();
            $table->enum('status_santri', ['pendaftar', 'aktif', 'alumni', 'keluar'])->default('pendaftar');
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();

            // 🔗 Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('id_madrasah')->references('id_madrasah')->on('madrasah')->nullOnDelete();
            $table->foreign('id_kamar')->references('id_kamar')->on('kamar')->nullOnDelete();
        });

         // Berkas Pendaftaran
        Schema::create('berkas_pendaftaran', function (Blueprint $table) {
            $table->bigIncrements('id_berkas');
            $table->unsignedBigInteger('id_santri');
            $table->string('file_kk')->nullable();
            $table->string('file_akta_kelahiran')->nullable();
            $table->string('file_ijazah_sd')->nullable();
            $table->string('file_skhu_sd')->nullable();
            $table->string('file_pas_foto')->nullable();
            $table->enum('status_verifikasi', ['pending', 'diverifikasi', 'ditolak'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_santri')->references('id_santri')->on('santri')->cascadeOnDelete();
            $table->foreign('diverifikasi_oleh')->references('id')->on('users')->nullOnDelete();
        });

         // Komponen SPP
        Schema::create('komponen_spp', function (Blueprint $table) {
            $table->bigIncrements('id_komponen');
            $table->unsignedBigInteger('id_madrasah');
            $table->string('nama_komponen', 50);
            $table->decimal('harga', 10, 2);
            $table->enum('kategori', ['makan', 'listrik', 'sosial', 'ianah']);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_madrasah')->references('id_madrasah')->on('madrasah')->cascadeOnDelete();
        });

         // Pilihan Makan Santri
        Schema::create('pilihan_makan_santri', function (Blueprint $table) {
            $table->bigIncrements('id_pilihan_makan');
            $table->unsignedBigInteger('id_santri');
            $table->integer('bulan');
            $table->year('tahun');
            $table->enum('jenis_makan', ['tidak_ambil', 'sehari_1x', 'sehari_2x']);
            $table->timestamp('tanggal_pilih')->useCurrent();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['id_santri', 'bulan', 'tahun']);
            $table->foreign('id_santri')->references('id_santri')->on('santri')->cascadeOnDelete();
        });

        // Tagihan SPP
        Schema::create('tagihan_spp', function (Blueprint $table) {
            $table->bigIncrements('id_tagihan');
            $table->unsignedBigInteger('id_santri');
            $table->integer('bulan');
            $table->year('tahun');
            $table->decimal('biaya_makan', 10, 2)->default(0);
            $table->decimal('biaya_listrik', 10, 2)->default(0);
            $table->decimal('biaya_sosial', 10, 2)->default(0);
            $table->decimal('biaya_ianah', 10, 2)->default(0);
            $table->decimal('total_tagihan', 10, 2);
            $table->enum('status_tagihan', ['belum_bayar', 'pending_verifikasi', 'lunas', 'terlambat'])->default('belum_bayar');
            $table->date('jatuh_tempo');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['id_santri', 'bulan', 'tahun']);
            $table->index('status_tagihan');
            $table->foreign('id_santri')->references('id_santri')->on('santri')->cascadeOnDelete();
        });

         // Pembayaran SPP
        Schema::create('pembayaran_spp', function (Blueprint $table) {
            $table->bigIncrements('id_pembayaran');
            $table->unsignedBigInteger('id_tagihan');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->date('tanggal_bayar');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('metode_pembayaran', ['transfer_bank', 'cash'])->default('transfer_bank');
            $table->string('bank_pengirim', 50)->nullable();
            $table->string('nama_pengirim', 100)->nullable();
            $table->enum('status_verifikasi', ['pending', 'diverifikasi', 'ditolak'])->default('pending');
            $table->unsignedBigInteger('diverifikasi_oleh')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('id_tagihan');
            $table->index('status_verifikasi');

            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan_spp')->cascadeOnDelete();
            $table->foreign('diverifikasi_oleh')->references('id')->on('users')->nullOnDelete();
        });

        // tabel kegiatan santri
        Schema::create('kegiatan_santri', function (Blueprint $table) {
            $table->bigIncrements('id_kegiatan_santri');
            $table->string('nama_kegiatan');
            $table->string('jenis_kegiatan');
            $table->string('keterangan_kegiatan');
            $table->timestamps();
            $table->softDeletes();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
         Schema::dropIfExists('pembayaran_spp');
        Schema::dropIfExists('tagihan_spp');
        Schema::dropIfExists('pilihan_makan_santri');
        Schema::dropIfExists('komponen_spp');
        Schema::dropIfExists('berkas_pendaftaran');
        Schema::dropIfExists('santri');
        Schema::dropIfExists('kamar');
        Schema::dropIfExists('madrasah');
    }
};
