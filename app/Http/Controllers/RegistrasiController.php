<?php

namespace App\Http\Controllers;

use App\JadwalDokter;
use App\Pasien;
use App\Registrasi;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Http\Request;
use Monolog\Registry;

class RegistrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registrasi = Registrasi::select('registrasi.no_registrasi', 'registrasi.no_rm', 'pas.nama_pasien', 'p.nama_poli', 'd.nama_dokter', 'registrasi.tgl_periksa', 'registrasi.no_antrian')
            ->join('pasien as pas', 'pas.no_rm', 'registrasi.no_rm')
            ->join('jadwal_dokter as jd', 'jd.id_jadwal', 'registrasi.id_jadwal')
            ->join('poliklinik as p', 'p.id_poli', 'jd.id_poli')
            ->join('dokter as d', 'd.id_dokter', 'jd.id_dokter')
            ->get();

        return response()->json([
            "metadata" => [
                "code" => 200,
                "message" => "Success"
            ],
            "response" => $registrasi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tgl_periksa = date('Y-m-d', strtotime($request->tgl_periksa));
        $cek_registrasi = Registrasi::where('tgl_periksa', $tgl_periksa)
            ->where('id_jadwal', $request->id_jadwal)
            ->where('no_rm', $request->no_rm)
            ->first();

        if (!empty($cek_registrasi)) {
            $detail_reg = Registrasi::select('registrasi.no_registrasi', 'registrasi.no_rm', 'pas.nama_pasien', 'p.nama_poli', 'd.nama_dokter', 'registrasi.tgl_periksa', 'registrasi.no_antrian')
                ->join('pasien as pas', 'pas.no_rm', 'registrasi.no_rm')
                ->join('jadwal_dokter as jd', 'jd.id_jadwal', 'registrasi.id_jadwal')
                ->join('poliklinik as p', 'p.id_poli', 'jd.id_poli')
                ->join('dokter as d', 'd.id_dokter', 'jd.id_dokter')
                ->where('no_registrasi', $cek_registrasi->no_registrasi)
                ->first();

            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Anda telah terdaftar, berikut detail registrasi anda."
                ],
                "response" => $detail_reg
            ]);
        } else {
            $cek_jadwal = JadwalDokter::find($request->id_jadwal);
            $cek_pasien = Pasien::find($request->no_rm);

            if (empty($cek_jadwal) || empty($cek_pasien)) {
                return response()->json([
                    "metadata" => [
                        "code" => 201,
                        "message" => "Failed! Jadwal Dokter atau Pasien tidak ditemukan."
                    ],
                    "response" => ""
                ]);
            } else {
                $count_registrasi = Registrasi::where('tgl_periksa', $tgl_periksa)
                    ->where('id_jadwal', $request->id_jadwal)
                    ->count();

                $registrasi = new Registrasi();
                $registrasi->no_rm = $request->no_rm;
                $registrasi->id_jadwal = $request->id_jadwal;
                $registrasi->tgl_periksa = $tgl_periksa;
                $registrasi->no_antrian = $count_registrasi + 1;
                $registrasi->save();

                $detail_reg = Registrasi::select('registrasi.no_registrasi', 'registrasi.no_rm', 'pas.nama_pasien', 'p.nama_poli', 'd.nama_dokter', 'registrasi.tgl_periksa', 'registrasi.no_antrian')
                    ->join('pasien as pas', 'pas.no_rm', 'registrasi.no_rm')
                    ->join('jadwal_dokter as jd', 'jd.id_jadwal', 'registrasi.id_jadwal')
                    ->join('poliklinik as p', 'p.id_poli', 'jd.id_poli')
                    ->join('dokter as d', 'd.id_dokter', 'jd.id_dokter')
                    ->where('no_registrasi', $registrasi->no_registrasi)
                    ->first();

                return response()->json([
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => $detail_reg
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail_reg = Registrasi::select('registrasi.no_registrasi', 'registrasi.no_rm', 'pas.nama_pasien', 'p.nama_poli', 'd.nama_dokter', 'registrasi.tgl_periksa', 'registrasi.no_antrian')
            ->join('pasien as pas', 'pas.no_rm', 'registrasi.no_rm')
            ->join('jadwal_dokter as jd', 'jd.id_jadwal', 'registrasi.id_jadwal')
            ->join('poliklinik as p', 'p.id_poli', 'jd.id_poli')
            ->join('dokter as d', 'd.id_dokter', 'jd.id_dokter')
            ->where('no_registrasi', $id)
            ->first();

        if (empty($detail_reg)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data registrasi tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => $detail_reg
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tgl_periksa = date('Y-m-d', strtotime($request->tgl_periksa));
        $cek_registrasi = Registrasi::where('tgl_periksa', $tgl_periksa)
            ->where('id_jadwal', $request->id_jadwal)
            ->where('no_rm', $request->no_rm)
            ->first();

        if (!empty($cek_registrasi)) {
            $detail_reg = Registrasi::select('registrasi.no_registrasi', 'registrasi.no_rm', 'pas.nama_pasien', 'p.nama_poli', 'd.nama_dokter', 'registrasi.tgl_periksa', 'registrasi.no_antrian')
                ->join('pasien as pas', 'pas.no_rm', 'registrasi.no_rm')
                ->join('jadwal_dokter as jd', 'jd.id_jadwal', 'registrasi.id_jadwal')
                ->join('poliklinik as p', 'p.id_poli', 'jd.id_poli')
                ->join('dokter as d', 'd.id_dokter', 'jd.id_dokter')
                ->where('no_registrasi', $cek_registrasi->no_registrasi)
                ->first();

            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Anda telah terdaftar, berikut detail registrasi anda."
                ],
                "response" => $detail_reg
            ]);
        } else {
            $registrasi = Registrasi::find($id);

            if (empty($registrasi)) {
                return response()->json([
                    "metadata" => [
                        "code" => 201,
                        "message" => "Failed! Registrasi tidak ditemukan."
                    ],
                    "response" => ""
                ]);
            } else {
                $cek_jadwal = JadwalDokter::find($request->id_jadwal);
                $cek_pasien = Pasien::find($request->no_rm);

                if (empty($cek_jadwal) || empty($cek_pasien)) {
                    return response()->json([
                        "metadata" => [
                            "code" => 201,
                            "message" => "Failed! Jadwal Dokter atau Pasien tidak ditemukan."
                        ],
                        "response" => ""
                    ]);
                } else {
                    $count_registrasi = Registrasi::where('tgl_periksa', $tgl_periksa)
                        ->where('id_jadwal', $request->id_jadwal)
                        ->count();

                    $registrasi->no_rm = $request->no_rm;
                    $registrasi->id_jadwal = $request->id_jadwal;
                    $registrasi->tgl_periksa = $tgl_periksa;
                    $registrasi->no_antrian = $count_registrasi + 1;
                    $registrasi->save();

                    $detail_reg = Registrasi::select('registrasi.no_registrasi', 'registrasi.no_rm', 'pas.nama_pasien', 'p.nama_poli', 'd.nama_dokter', 'registrasi.tgl_periksa', 'registrasi.no_antrian')
                        ->join('pasien as pas', 'pas.no_rm', 'registrasi.no_rm')
                        ->join('jadwal_dokter as jd', 'jd.id_jadwal', 'registrasi.id_jadwal')
                        ->join('poliklinik as p', 'p.id_poli', 'jd.id_poli')
                        ->join('dokter as d', 'd.id_dokter', 'jd.id_dokter')
                        ->where('no_registrasi', $id)
                        ->first();

                    return response()->json([
                        "metadata" => [
                            "code" => 200,
                            "message" => "Success"
                        ],
                        "response" => $detail_reg
                    ]);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $registrasi = Registrasi::find($id);

        if (empty($registrasi)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data registrasi tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $registrasi->delete();
            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => ""
            ]);
        }
    }
}
