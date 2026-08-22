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

        $defaultSandiId = DB::table('sandi_transaksis')->first()->id ?? null;
        if (!$defaultSandiId) {
            $commonSandi = [
                ['kode' => '01', 'nama' => 'Setor Tunai', 'jenis_transaksi' => 'setor'],
                ['kode' => '02', 'nama' => 'Tarik Tunai', 'jenis_transaksi' => 'tarik'],
                ['kode' => '03', 'nama' => 'Autodebet SPP', 'jenis_transaksi' => 'transfer'],
                ['kode' => '04', 'nama' => 'Transfer', 'jenis_transaksi' => 'transfer'],
                ['kode' => 'UNKN', 'nama' => 'Sandi Tidak Diketahui', 'jenis_transaksi' => 'setor'],
            ];

            foreach ($commonSandi as $s) {
                $id = (string) Str::uuid();
                DB::table('sandi_transaksis')->insert([
                    'id' => $id,
                    'kode' => $s['kode'],
                    'nama' => $s['nama'],
                    'jenis_transaksi' => $s['jenis_transaksi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                if ($s['kode'] === 'UNKN') {
                    $defaultSandiId = $id;
                }
            }
        }

        $defaultViaId = DB::table('via_transaksis')->first()->id ?? null;
        if (!$defaultViaId) {
            $commonVia = [
                ['kode' => '101', 'nama' => 'Teller'],
                ['kode' => '102', 'nama' => 'VA / Payment BSI'],
                ['kode' => '103', 'nama' => 'Nasabah'],
                ['kode' => 'UNKN', 'nama' => 'Via Tidak Diketahui'],
            ];

            foreach ($commonVia as $v) {
                $id = (string) Str::uuid();
                DB::table('via_transaksis')->insert([
                    'id' => $id,
                    'kode' => $v['kode'],
                    'nama' => $v['nama'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                if ($v['kode'] === 'UNKN') {
                    $defaultViaId = $id;
                }
            }
        }

        // Memuat map untuk sandi & via transaksi SETELAH memastikan data default ada
        $this->info("Memuat referensi Sandi & Via...");
        $mapSandi = DB::table('sandi_transaksis')->pluck('id', 'kode')->toArray();
        $mapVia = DB::table('via_transaksis')->pluck('id', 'kode')->toArray();

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
            // PREPARE DUMMY RECORDS UNTUK DATA YATIM
            // ==========================================
            $dummyNasabahId = (string) Str::uuid();
            DB::table('nasabahs')->insert([
                'id' => $dummyNasabahId,
                'user_id' => $defaultAdminId,
                'nin' => 'UNKNOWN_MIGRASI',
                'nama' => 'Nasabah Tidak Diketahui (Migrasi)',
                'kategori' => 'umum',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $dummyRekeningId = (string) Str::uuid();
            DB::table('rekenings')->insert([
                'id' => $dummyRekeningId,
                'nasabah_id' => $dummyNasabahId,
                'user_id' => $defaultAdminId,
                'no_rek' => 'UNKNOWN_REK',
                'pin' => '000000',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $dummySubRekeningId = (string) Str::uuid();
            DB::table('subrekenings')->insert([
                'id' => $dummySubRekeningId,
                'rekening_id' => $dummyRekeningId,
                'kode_subrekening' => 'UNKN_SUB',
                'subrekening' => 'Sub Rekening Tidak Diketahui (Migrasi)',
                'tahun_pembayaran' => date('Y'),
                'nominal' => 0,
                'kategori' => 'umum',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

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
                    $this->warn("Nasabah NIN {$rek->nin} tidak ditemukan untuk Rekening {$rek->norek}. Dialihkan ke Dummy Nasabah.");
                    $nasabahId = $dummyNasabahId;
                } else {
                    $nasabahId = $mapNasabah[$rek->nin];
                }

                $newUuid = (string) Str::uuid();
                $mapRekening[$rek->norek] = $newUuid;

                DB::table('rekenings')->insert([
                    'id'         => $newUuid,
                    'nasabah_id' => $nasabahId,
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
                    $this->warn("Rekening {$sub->norek} tidak ditemukan untuk SubRekening {$sub->idsubrekening}. Dialihkan ke Dummy Rekening.");
                    $rekeningId = $dummyRekeningId;
                } else {
                    $rekeningId = $mapRekening[$sub->norek];
                }

                $newUuid = (string) Str::uuid();
                $mapSubRekening[$sub->idsubrekening] = $newUuid;

                DB::table('subrekenings')->insert([
                    'id'               => $newUuid,
                    'rekening_id'      => $rekeningId,
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
                    $this->warn("Rekening {$trx->norek} tidak ditemukan untuk Transaksi {$trx->idtransaksi}. Dialihkan ke Dummy Rekening.");
                    $rekeningId = $dummyRekeningId;
                } else {
                    $rekeningId = $mapRekening[$trx->norek];
                }

                $rekTujuan = ($trx->norektujuan === '-') ? null : ($mapRekening[$trx->norektujuan] ?? $dummyRekeningId);
                $subRek = ($trx->idsubrekening === '-') ? null : ($mapSubRekening[$trx->idsubrekening] ?? $dummySubRekeningId);
                $keterangan = ($trx->keterangan === '-') ? null : $trx->keterangan;

                DB::table('transaksis')->insert([
                    'id'                 => (string) Str::uuid(),
                    'rekening_id'        => $rekeningId,
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
                    $this->warn("Rekening {$auto->norek} tidak ditemukan untuk Autodebet {$auto->idautodebet}. Dialihkan ke Dummy Rekening.");
                    $rekeningId = $dummyRekeningId;
                } else {
                    $rekeningId = $mapRekening[$auto->norek];
                }

                $rekTujuan = ($auto->norektujuan === '-') ? null : ($mapRekening[$auto->norektujuan] ?? $dummyRekeningId);
                $subRek = ($auto->idsubrekening === '-') ? null : ($mapSubRekening[$auto->idsubrekening] ?? $dummySubRekeningId);

                DB::table('autodebets')->insert([
                    'id'                 => (string) Str::uuid(),
                    'rekening_id'        => $rekeningId,
                    'rekening_tujuan_id' => $rekTujuan,
                    'subrekening_id'     => $subRek,
                    'user_id'            => $mapUser[$auto->iduser] ?? $defaultAdminId,
                    'tgl_penarikan'      => $auto->tglpenarikan ?? 1,
                    'status'             => $auto->status ?? 1,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }

            // ==========================================
            // 10. MIGRASI GROUP PEMBAYARAN
            // ==========================================
            $this->info("10/12. Memindahkan data Group Pembayaran...");
            $oldGroupPembayaran = DB::connection('db_v1')->table('grouppembayaran')->get();

            foreach ($oldGroupPembayaran as $gp) {
                if (!isset($mapSubRekening[$gp->idsubrekening])) {
                    $this->warn("SubRekening {$gp->idsubrekening} tidak ditemukan untuk Group Pembayaran {$gp->idgroup}. Dialihkan ke Dummy.");
                    $subrekeningId = $dummySubRekeningId;
                } else {
                    $subrekeningId = $mapSubRekening[$gp->idsubrekening];
                }

                if (!isset($mapRekening[$gp->norek])) {
                    $this->warn("Rekening {$gp->norek} tidak ditemukan untuk Group Pembayaran {$gp->idgroup}. Dialihkan ke Dummy.");
                    $rekeningId = $dummyRekeningId;
                } else {
                    $rekeningId = $mapRekening[$gp->norek];
                }

                DB::table('group_pembayarans')->updateOrInsert(
                    ['subrekening_id' => $subrekeningId, 'rekening_id' => $rekeningId],
                    [
                        'id' => (string) Str::uuid(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            // ==========================================
            // 11. MIGRASI TAGIHAN
            // ==========================================
            $this->info("11/12. Memindahkan data Tagihan...");
            $oldTagihan = DB::connection('db_v1')->table('tagihan')->get();

            foreach ($oldTagihan as $tagihan) {
                DB::table('tagihans')->insert([
                    'id'                      => (string) Str::uuid(),
                    'nomor_pembayaran'        => $tagihan->nomor_pembayaran,
                    'nomor_induk'             => $tagihan->nomor_induk,
                    'nama'                    => $tagihan->nama,
                    'kode_fakultas'           => $tagihan->kode_fakultas,
                    'nama_fakultas'           => $tagihan->nama_fakultas,
                    'kode_prodi'              => $tagihan->kode_prodi,
                    'nama_prodi'              => $tagihan->nama_prodi,
                    'kode_periode'            => $tagihan->kode_periode,
                    'nama_periode'            => $tagihan->nama_periode,
                    'strata'                  => $tagihan->strata,
                    'angkatan'                => $tagihan->angkatan,
                    'is_tagihan_aktif'        => $tagihan->is_tagihan_aktif ?? 1,
                    'tanggal'                 => $tagihan->tanggal,
                    'waktu_berlaku'           => $tagihan->waktu_berlaku,
                    'waktu_berakhir'          => $tagihan->waktu_berakhir,
                    'urutan_antrian'          => $tagihan->urutan_antrian ?? 0,
                    'total_nilai_tagihan'     => $tagihan->total_nilai_tagihan ?? 0,
                    'pembayaran_atau_voucher' => $tagihan->pembayaran_atau_voucher ?? 'PEMBAYARAN',
                    'voucher_nama'            => $tagihan->voucher_nama,
                    'created_at'              => now(),
                    'updated_at'              => now(),
                ]);
            }

            // ==========================================
            // 12. MIGRASI NOTIF
            // ==========================================
            $this->info("12/12. Memindahkan data Notif...");
            $oldNotif = DB::connection('db_v1')->table('notif')->get();

            foreach ($oldNotif as $notif) {
                DB::table('notifs')->insert([
                    'id'               => (string) Str::uuid(),
                    'code'             => $notif->code,
                    'message'          => $notif->message,
                    'type'             => $notif->type,
                    'number'           => $notif->number,
                    'amount'           => $notif->amount ?? 0,
                    'remaining_amount' => $notif->remainingamount ?? 0,
                    'va'               => $notif->va,
                    'date'             => $notif->date ? date('Y-m-d H:i:s', strtotime($notif->date)) : null,
                    'bank_code'        => $notif->bankcode,
                    'bank_name'        => $notif->bankname,
                    'ref'              => $notif->ref,
                    'channel'          => $notif->channel,
                    'name'             => $notif->name,
                    'phone'            => $notif->phone,
                    'email'            => $notif->email,
                    'address'          => $notif->address,
                    'time_notif'       => $notif->timenotif ?? now(),
                ]);
            }
        });

        $this->info("=== MIGRASI DATA SUKSES 100% ===");
    }
}
