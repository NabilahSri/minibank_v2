<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MigrateV1ToV2Command extends Command
{
    protected $signature = 'migrate:v1-to-v2';

    protected $description = 'Migrasi data penuh dari db_minibank (v1) ke db_minibank_v2 (v2)';

    public function handle()
    {
        $this->info("=== MEMULAI PROSES MIGRASI DATA V1 KE V2 ===");

        // Memuat map untuk sandi & via transaksi 
        $this->info("Memuat referensi Sandi & Via...");
        $mapSandi = DB::table('sandi_transaksis')->pluck('id', 'kode')->toArray();
        $mapVia = DB::table('via_transaksis')->pluck('id', 'kode')->toArray();
        
        $defaultSandiId = DB::table('sandi_transaksis')->first()->id ?? null;
        $defaultViaId = DB::table('via_transaksis')->first()->id ?? null;

        // Menggunakan Transaction agar jika ada error di tengah jalan, semua data akan di-rollback (dibatalkan)
        DB::transaction(function () use ($mapSandi, $mapVia, $defaultSandiId, $defaultViaId) {

            // ==========================================
            // 1. MIGRASI USERS
            // ==========================================
            $this->info("1/9. Memindahkan data Users...");
            $oldUsers = DB::connection('db_v1')->table('users')->get();
            $mapUser = []; 
            $defaultAdminId = null;

            foreach ($oldUsers as $user) {
                $newUuid = (string) Str::uuid();
                $mapUser[$user->iduser] = $newUuid;

                // Mapping Role v1 -> v2
                $role = in_array($user->idlevel, ['adm', 'opr', 'nsb']) ? $user->idlevel : 'nsb';
                
                if ($role === 'adm' && !$defaultAdminId) {
                    $defaultAdminId = $newUuid;
                }

                DB::table('users')->insert([
                    'id'         => $newUuid,
                    'username'   => $user->username,
                    'password'   => $user->password,
                    'role'       => $role,
                    'created_at' => $user->created_at ?? now(),
                    'updated_at' => $user->updated_at ?? now(),
                ]);
            }
            if (!$defaultAdminId) {
                $defaultAdminId = DB::table('users')->where('role', 'adm')->value('id');
            }

            // ==========================================
            // 2. MIGRASI LOKASI
            // ==========================================
            $this->info("2/9. Memindahkan data Lokasi...");
            $oldLokasi = DB::connection('db_v1')->table('lokasi')->get();
            $mapLokasi = [];

            foreach ($oldLokasi as $lokasi) {
                $newUuid = (string) Str::uuid();
                $mapLokasi[$lokasi->idlokasi] = $newUuid;

                DB::table('lokasis')->insert([
                    'id'          => $newUuid,
                    'nama_lokasi' => $lokasi->nama,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
            $defaultLokasiId = DB::table('lokasis')->first()->id ?? null;

            // ==========================================
            // 3. MIGRASI PEGAWAI
            // ==========================================
            $this->info("3/9. Memindahkan data Pegawai...");
            $oldPegawai = DB::connection('db_v1')->table('pegawai')->get();

            foreach ($oldPegawai as $pegawai) {
                DB::table('pegawais')->insert([
                    'id'         => (string) Str::uuid(),
                    'user_id'    => $mapUser[$pegawai->iduser] ?? $defaultAdminId,
                    'lokasi_id'  => $mapLokasi[$pegawai->idlokasi] ?? $defaultLokasiId,
                    'nip'        => $pegawai->nip,
                    'nama'       => $pegawai->nama,
                    'jk'         => in_array($pegawai->jk, ['L', 'P']) ? $pegawai->jk : null,
                    'no_hp'      => $pegawai->nohp,
                    'email'      => $pegawai->email,
                    'alamat'     => $pegawai->alamat,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // ==========================================
            // 4. MIGRASI NASABAH
            // ==========================================
            $this->info("4/9. Memindahkan data Nasabah...");
            $oldNasabah = DB::connection('db_v1')->table('nasabah')->get();
            $mapNasabah = [];

            foreach ($oldNasabah as $nasabah) {
                $newUuid = (string) Str::uuid();
                $mapNasabah[$nasabah->nin] = $newUuid;

                $userId = isset($nasabah->iduser) ? ($mapUser[$nasabah->iduser] ?? null) : null;

                DB::table('nasabahs')->insert([
                    'id'         => $newUuid,
                    'user_id'    => $userId,
                    'nin'        => $nasabah->nin,
                    'nama'       => $nasabah->nama,
                    'jk'         => in_array($nasabah->jk, ['L', 'P']) ? $nasabah->jk : null,
                    'no_hp'      => $nasabah->nohp,
                    'email'      => $nasabah->email,
                    'alamat'     => $nasabah->alamat,
                    'nama_ortu'  => $nasabah->nm_ortu,
                    'kategori'   => $nasabah->kategori == 'siswa' ? 'siswa' : 'umum',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // ==========================================
            // 5. MIGRASI SISWA
            // ==========================================
            $this->info("5/9. Memindahkan data Siswa...");
            $oldSiswa = DB::connection('db_v1')->table('siswa')->get();
            
            foreach ($oldSiswa as $siswa) {
                if (isset($mapNasabah[$siswa->nin])) {
                    DB::table('siswas')->insert([
                        'id'          => (string) Str::uuid(),
                        'nasabah_id'  => $mapNasabah[$siswa->nin],
                        'nisn'        => $siswa->nisn,
                        'tahun_masuk' => $siswa->thnmasuk,
                        'jurusan'     => $siswa->jurusan,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }
            }

            // ==========================================
            // 6. MIGRASI REKENING
            // ==========================================
            $this->info("6/9. Memindahkan data Rekening...");
            $oldRekening = DB::connection('db_v1')->table('rekening')->get();
            $mapRekening = []; 

            foreach ($oldRekening as $rek) {
                if (!isset($mapNasabah[$rek->nin])) {
                    $this->warn("Skipping Rekening {$rek->norek} (Nasabah NIN {$rek->nin} tidak ditemukan)");
                    continue;
                }

                $newUuid = (string) Str::uuid();
                $mapRekening[$rek->norek] = $newUuid;

                DB::table('rekenings')->insert([
                    'id'         => $newUuid,
                    'nasabah_id' => $mapNasabah[$rek->nin],
                    'user_id'    => $mapUser[$rek->iduser] ?? $defaultAdminId,
                    'no_rek'     => $rek->norek,
                    'pin'        => $rek->pin,
                    'status'     => $rek->status,
                    'created_at' => $rek->created ?? now(),
                    'updated_at' => now(),
                ]);
            }

            // ==========================================
            // 7. MIGRASI SUB-REKENING
            // ==========================================
            $this->info("7/9. Memindahkan data Sub Rekening...");
            $oldSubRek = DB::connection('db_v1')->table('subrekening')->get();
            $mapSubRekening = [];

            foreach ($oldSubRek as $sub) {
                if (!isset($mapRekening[$sub->norek])) {
                    $this->warn("Skipping SubRekening {$sub->idsubrekening} (Rekening {$sub->norek} tidak ditemukan)");
                    continue;
                }

                $newUuid = (string) Str::uuid();
                $mapSubRekening[$sub->idsubrekening] = $newUuid;

                DB::table('subrekenings')->insert([
                    'id'               => $newUuid,
                    'rekening_id'      => $mapRekening[$sub->norek],
                    'kode_subrekening' => $sub->idsubrekening,
                    'subrekening'      => $sub->subrekening,
                    'tahun_pembayaran' => $sub->thnpembayaran ?? date('Y'),
                    'nominal'          => $sub->nominal ?? 0,
                    'kategori'         => in_array($sub->kategori ?? '', ['umum', 'siswa']) ? $sub->kategori : 'siswa',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }

            // ==========================================
            // 8. MIGRASI TRANSAKSI
            // ==========================================
            $this->info("8/9. Memindahkan data Transaksi...");
            $oldTransaksi = DB::connection('db_v1')->table('transaksi')->get();

            foreach ($oldTransaksi as $trx) {
                if (!isset($mapRekening[$trx->norek])) {
                    $this->warn("Skipping Transaksi {$trx->idtransaksi} (Rekening {$trx->norek} tidak ditemukan)");
                    continue;
                }

                $rekTujuan = ($trx->norektujuan === '-') ? null : ($mapRekening[$trx->norektujuan] ?? null);
                $subRek = ($trx->idsubrekening === '-') ? null : ($mapSubRekening[$trx->idsubrekening] ?? null);
                $keterangan = ($trx->keterangan === '-') ? null : $trx->keterangan;

                DB::table('transaksis')->insert([
                    'id'                 => (string) Str::uuid(),
                    'rekening_id'        => $mapRekening[$trx->norek],
                    'rekening_tujuan_id' => $rekTujuan,
                    'subrekening_id'     => $subRek,
                    'user_id'            => $mapUser[$trx->iduser] ?? $defaultAdminId,
                    'sandi_id'           => $mapSandi[$trx->sandi] ?? $defaultSandiId,
                    'via_id'             => $mapVia[$trx->via] ?? $defaultViaId,
                    'nominal'            => $trx->nominal ?? 0,
                    'ref'                => $trx->ref,
                    'keterangan'         => $keterangan,
                    'waktu'              => $trx->waktu ?? now(),
                    'created_at'         => $trx->waktu ?? now(),
                    'updated_at'         => now(),
                ]);
            }

            // ==========================================
            // 9. MIGRASI AUTODEBET
            // ==========================================
            $this->info("9/9. Memindahkan data Autodebet...");
            $oldAutodebet = DB::connection('db_v1')->table('autodebet')->get();

            foreach ($oldAutodebet as $auto) {
                if (!isset($mapRekening[$auto->norek])) {
                    $this->warn("Skipping Autodebet {$auto->idautodebet} (Rekening {$auto->norek} tidak ditemukan)");
                    continue;
                }

                $rekTujuan = ($auto->norektujuan === '-') ? null : ($mapRekening[$auto->norektujuan] ?? null);
                $subRek = ($auto->idsubrekening === '-') ? null : ($mapSubRekening[$auto->idsubrekening] ?? null);

                if (!$rekTujuan || !$subRek) {
                    $this->warn("Skipping Autodebet {$auto->idautodebet} (Tujuan/Subrekening tidak valid)");
                    continue;
                }

                DB::table('autodebets')->insert([
                    'id'                 => (string) Str::uuid(),
                    'rekening_id'        => $mapRekening[$auto->norek],
                    'rekening_tujuan_id' => $rekTujuan,
                    'subrekening_id'     => $subRek,
                    'user_id'            => $mapUser[$auto->iduser] ?? $defaultAdminId,
                    'tgl_penarikan'      => $auto->tglpenarikan ?? 1,
                    'status'             => $auto->status ?? 1,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }
        });

        $this->info("=== MIGRASI DATA SUKSES 100% ===");
    }
}
