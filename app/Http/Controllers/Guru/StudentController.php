<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StudentController extends Controller
{
    /** Daftar siswa + status absensi suatu tanggal */
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $query = Siswa::with([
            'kelas:id,nama_kelas',
            'absensi' => fn ($q) => $q->whereDate('tgl_waktu_absen', $date)
        ]);

        if ($request->filled('name')) {
            $query->where('nama_siswa', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('class')) {
            $query->where('id_kelas', $request->class);
        }

        $students = $query->get();
        $classes  = Kelas::select('id','nama_kelas')->orderBy('nama_kelas')->get();

        return view('guru.student.index', compact('students','classes','date'));
    }

    /** Form edit status_absen untuk satu siswa */
    public function edit(Request $request, Siswa $siswa)
    {
        $date    = $request->input('date', Carbon::today()->toDateString());
        $absensi = Absensi::firstOrCreate(
            ['id_siswa' => $siswa->id, 'tgl_waktu_absen' => $date],
            ['status_absen' => 'alpha']      // default jika belum ada
        );

        return view('guru.student.edit', compact('siswa','absensi','date'));
    }

    /** Simpan perubahan */
    public function update(Request $request, Siswa $siswa)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $validated = $request->validate([
            'status_absen' => 'required|in:hadir,sakit,izin,alpha',
            'keterangan'   => 'nullable|string|max:255',
        ]);

        Absensi::updateOrCreate(
            ['id_siswa' => $siswa->id, 'tgl_waktu_absen' => $date],
            $validated
        );

        return redirect()
            ->route('guru.students.index', ['date' => $date])
            ->with('success', 'Status absensi berhasil diperbarui.');
    }
}
