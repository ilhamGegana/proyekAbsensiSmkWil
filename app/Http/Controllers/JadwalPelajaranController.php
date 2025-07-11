<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelajaran;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        $jadwalPelajaran = JadwalPelajaran::with(['guru', 'mapel', 'kelas'])
            ->orderBy('hari')->orderBy('jam_ke')->get();

        return view('admin.jadwalPelajaran.index', [
            'jadwalPelajaran' => $jadwalPelajaran,
            'guru'  => Guru::all(),
            'mapel' => Mapel::all(),
            'kelas' => Kelas::all()
        ]);
    }

    public function downloadPdf()
    {
        $jadwalPelajaran = JadwalPelajaran::with(['guru', 'mapel', 'kelas'])
            ->orderBy('hari')->orderBy('jam_ke')->get();

        $pdf = Pdf::loadView('admin.jadwalPelajaran.pdf', ['jadwalPelajaran' => $jadwalPelajaran]);

        return $pdf->download('jadwal-pelajaran.pdf');
    }

    public function create()
    {
        $guru = Guru::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.jadwalPelajaran.create', compact('guru', 'mapel', 'kelas'));
    }

    public function store(Request $request)
    {
        $this->validateForm($request);

        $data = $request->only(['hari', 'jam_ke', 'id_mapel', 'id_kelas']);
        $data['id_guru'] = Mapel::findOrFail($data['id_mapel'])->id_guru;
        JadwalPelajaran::create($data);

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        $guru = Guru::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.jadwalPelajaran.edit', compact('jadwalPelajaran', 'guru', 'mapel', 'kelas'));
    }

    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $this->validateForm($request, $jadwalPelajaran->id);

        $data = $request->only(['hari', 'jam_ke', 'id_mapel', 'id_kelas', 'is_active']);
        $data['id_guru']   = Mapel::findOrFail($data['id_mapel'])->id_guru;
        $data['is_active'] = $request->has('is_active');

        $jadwalPelajaran->update($data);

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function toggle(JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->update(['is_active' => ! $jadwalPelajaran->is_active]);

        return back()->with(
            'success',
            $jadwalPelajaran->is_active
                ? 'Jadwal di-aktifkan.'
                : 'Jadwal di-nonaktifkan.'
        );
    }

    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        if ($jadwalPelajaran->absensi()->exists()) {
            $jadwalPelajaran->update(['is_active' => false]);

            return back()->with('success', 'Jadwal sudah terpakai; status di-nonaktifkan.');
        }

        $jadwalPelajaran->delete();

        return back()->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }

    private function validateForm(Request $r, $ignoreId = null): void
    {
        $r->validate([
            'hari'   => ['required', 'max:20'],
            'jam_ke' => [
                'required',
                'integer',
                'min:0',
                'max:20',
                Rule::unique('jadwal_pelajaran')
                    ->where(fn($q) => $q->where('hari', $r->hari)
                        ->where('id_kelas', $r->id_kelas))
                    ->ignore($ignoreId),
            ],
            'id_mapel' => ['required', 'exists:mapel,id'],
            'id_kelas' => ['required', 'exists:kelas,id'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }
}
