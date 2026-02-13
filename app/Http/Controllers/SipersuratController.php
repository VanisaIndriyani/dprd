<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;

use Illuminate\Support\Facades\Storage;

class SipersuratController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Simple login logic for demo purposes (hardcoded)
        // In real app, use Auth::attempt and database
        
        // Login Admin / TU
        if ($request->username === 'admin' && $request->password === 'admin') {
            session([
                'is_logged_in' => true, 
                'user_role' => 'Tata Usaha',
                'user_name' => 'Admin TU'
            ]);
            return redirect()->route('dashboard');
        }

        // Login Pimpinan / Sekwan
        if ($request->username === 'pimpinan' && $request->password === 'pimpinan') {
            session([
                'is_logged_in' => true, 
                'user_role' => 'Sekwan',
                'user_name' => 'Sekretaris Dewan'
            ]);
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        if (!session('is_logged_in')) return redirect()->route('login');

        $countSuratMasuk = SuratMasuk::count();
        $countMenungguDisposisi = SuratMasuk::where('status', 'Menunggu Disposisi')->count();
        $countSuratKeluar = SuratKeluar::count();
        $countArsip = SuratMasuk::where('status', 'Arsip')->count() + SuratKeluar::where('status', 'Arsip')->count();

        // Chart Data (Surat Masuk per month)
        $suratMasukPerMonth = SuratMasuk::selectRaw('MONTH(tgl_terima) as month, COUNT(*) as count')
            ->whereYear('tgl_terima', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')->toArray();

        // Chart Data (Surat Keluar per month)
        $suratKeluarPerMonth = SuratKeluar::selectRaw('MONTH(tgl_keluar) as month, COUNT(*) as count')
            ->whereYear('tgl_keluar', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')->toArray();

        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartDataMasuk = [];
        $chartDataKeluar = [];

        for ($i=1; $i<=12; $i++) {
            $chartDataMasuk[] = $suratMasukPerMonth[$i] ?? 0;
            $chartDataKeluar[] = $suratKeluarPerMonth[$i] ?? 0;
        }

        return view('dashboard', compact(
            'countSuratMasuk', 
            'countMenungguDisposisi', 
            'countSuratKeluar', 
            'countArsip',
            'chartLabels',
            'chartDataMasuk',
            'chartDataKeluar'
        ));
    }

    public function suratMasuk(Request $request)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        
        $query = SuratMasuk::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('pengirim', 'like', "%{$search}%");
            });
        }

        $suratMasuk = $query->get();
        return view('surat-masuk.index', compact('suratMasuk'));
    }

    public function createSuratMasuk()
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-masuk');

        return view('surat-masuk.create');
    }

    public function storeSuratMasuk(Request $request)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-masuk');

        $validated = $request->validate([
            'no_surat' => 'required|unique:surat_masuks',
            'pengirim' => 'required',
            'perihal' => 'required',
            'tgl_terima' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('surat-masuk', 'public');
        }

        $validated['status'] = 'Menunggu Disposisi';
        
        SuratMasuk::create($validated);

        return redirect()->route('surat-masuk')->with('success', 'Surat Masuk berhasil ditambahkan!');
    }

    public function editSuratMasuk($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-masuk');

        $surat = SuratMasuk::findOrFail($id);
        return view('surat-masuk.edit', compact('surat'));
    }

    public function updateSuratMasuk(Request $request, $id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-masuk');

        $surat = SuratMasuk::findOrFail($id);

        $validated = $request->validate([
            'no_surat' => 'required|unique:surat_masuks,no_surat,'.$id,
            'pengirim' => 'required',
            'perihal' => 'required',
            'tgl_terima' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        if ($request->hasFile('file_path')) {
            // Delete old file if exists
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('surat-masuk', 'public');
        }

        $surat->update($validated);

        return redirect()->route('surat-masuk')->with('success', 'Surat Masuk berhasil diperbarui!');
    }

    public function destroySuratMasuk($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-masuk');

        $surat = SuratMasuk::findOrFail($id);
        
        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }
        
        $surat->delete();

        return redirect()->route('surat-masuk')->with('success', 'Surat Masuk berhasil dihapus!');
    }

    public function suratKeluar(Request $request)
    {
        if (!session('is_logged_in')) return redirect()->route('login');

        $query = SuratKeluar::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%");
            });
        }

        $suratKeluar = $query->get();
        return view('surat-keluar.index', compact('suratKeluar'));
    }

    public function createSuratKeluar()
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-keluar');

        return view('surat-keluar.create');
    }

    public function storeSuratKeluar(Request $request)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-keluar');

        $validated = $request->validate([
            'no_surat' => 'required|unique:surat_keluars',
            'tujuan' => 'required',
            'perihal' => 'required',
            'tgl_keluar' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('surat-keluar', 'public');
        }

        $validated['status'] = 'Draft'; // Default status
        
        SuratKeluar::create($validated);

        return redirect()->route('surat-keluar')->with('success', 'Surat Keluar berhasil ditambahkan!');
    }

    public function editSuratKeluar($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-keluar');

        $surat = SuratKeluar::findOrFail($id);
        return view('surat-keluar.edit', compact('surat'));
    }

    public function updateSuratKeluar(Request $request, $id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-keluar');

        $surat = SuratKeluar::findOrFail($id);

        $validated = $request->validate([
            'no_surat' => 'required|unique:surat_keluars,no_surat,'.$id,
            'tujuan' => 'required',
            'perihal' => 'required',
            'tgl_keluar' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'status' => 'required'
        ]);

        if ($request->hasFile('file_path')) {
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('surat-keluar', 'public');
        }

        $surat->update($validated);

        return redirect()->route('surat-keluar')->with('success', 'Surat Keluar berhasil diperbarui!');
    }

    public function destroySuratKeluar($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') === 'Sekwan') return redirect()->route('surat-keluar');

        $surat = SuratKeluar::findOrFail($id);

        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }

        $surat->delete();

        return redirect()->route('surat-keluar')->with('success', 'Surat Keluar berhasil dihapus!');
    }

    public function downloadSuratMasukFile($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        $surat = SuratMasuk::findOrFail($id);

        if (!$surat->file_path || !Storage::disk('public')->exists($surat->file_path)) {
            return back()->with('error', 'File tidak ditemukan!');
        }

        return Storage::disk('public')->download($surat->file_path);
    }

    public function downloadSuratKeluarFile($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        $surat = SuratKeluar::findOrFail($id);

        if (!$surat->file_path || !Storage::disk('public')->exists($surat->file_path)) {
            return back()->with('error', 'File tidak ditemukan!');
        }

        return Storage::disk('public')->download($surat->file_path);
    }

    public function disposisi($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');

        $surat = SuratMasuk::findOrFail($id);
        $disposisiList = Disposisi::where('surat_masuk_id', $id)->latest()->get();
        
        return view('disposisi.show', compact('surat', 'disposisiList'));
    }

    public function storeDisposisi(Request $request, $id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') !== 'Sekwan') return redirect()->back()->with('error', 'Hanya Pimpinan yang dapat melakukan disposisi!');

        $validated = $request->validate([
            'tujuan_disposisi' => 'required',
            'sifat' => 'required',
            'isi_disposisi' => 'required',
            'catatan' => 'nullable',
            'batas_waktu' => 'nullable|date',
        ]);

        $validated['surat_masuk_id'] = $id;
        $validated['status'] = 'Disposisi';

        Disposisi::create($validated);

        // Update status surat masuk
        $surat = SuratMasuk::findOrFail($id);
        $surat->update(['status' => 'Disposisi']);

        return redirect()->back()->with('success', 'Disposisi berhasil dikirim!');
    }

    public function finishDisposisi($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        // Allow Tata Usaha to mark as finished
        if (session('user_role') !== 'Tata Usaha') return redirect()->back()->with('error', 'Hanya Admin TU yang dapat menyelesaikan disposisi!');

        $surat = SuratMasuk::findOrFail($id);
        $surat->update(['status' => 'Selesai']);

        return redirect()->back()->with('success', 'Disposisi berhasil diselesaikan!');
    }

    public function disposisiSuratKeluar($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');

        $surat = SuratKeluar::findOrFail($id);
        $disposisiList = Disposisi::where('surat_keluar_id', $id)->latest()->get();
        
        return view('disposisi.show-keluar', compact('surat', 'disposisiList'));
    }

    public function storeDisposisiSuratKeluar(Request $request, $id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        if (session('user_role') !== 'Sekwan') return redirect()->back()->with('error', 'Hanya Pimpinan yang dapat melakukan disposisi!');

        $validated = $request->validate([
            'tujuan_disposisi' => 'required',
            'sifat' => 'required',
            'isi_disposisi' => 'required',
            'catatan' => 'nullable',
            'batas_waktu' => 'nullable|date',
        ]);

        $validated['surat_keluar_id'] = $id;
        $validated['status'] = 'Disposisi';

        Disposisi::create($validated);

        // Update status surat keluar
        $surat = SuratKeluar::findOrFail($id);
        $surat->update(['status' => 'Disposisi']);

        return redirect()->back()->with('success', 'Disposisi berhasil dikirim!');
    }

    public function finishDisposisiSuratKeluar($id)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        // Allow Tata Usaha to mark as finished
        if (session('user_role') !== 'Tata Usaha') return redirect()->back()->with('error', 'Hanya Admin TU yang dapat menyelesaikan disposisi!');

        $surat = SuratKeluar::findOrFail($id);
        $surat->update(['status' => 'Selesai']);

        return redirect()->back()->with('success', 'Disposisi berhasil diselesaikan!');
    }

    public function arsip(Request $request)
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        
        $queryMasuk = SuratMasuk::whereIn('status', ['Selesai', 'Arsip']);
        $queryKeluar = SuratKeluar::whereIn('status', ['Dikirim', 'Arsip']);

        // Filter Logic
        if ($request->filled('search')) {
            $search = $request->search;
            $queryMasuk->where(function($q) use ($search) {
                $q->where('no_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
            });
            $queryKeluar->where(function($q) use ($search) {
                $q->where('no_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            if ($request->kategori == '1') { // Surat Masuk
                $queryKeluar = SuratKeluar::where('id', -1); // Empty
            } elseif ($request->kategori == '2') { // Surat Keluar
                $queryMasuk = SuratMasuk::where('id', -1); // Empty
            }
        }

        if ($request->filled('tanggal')) {
            $queryMasuk->whereDate('tgl_terima', $request->tanggal);
            $queryKeluar->whereDate('tgl_keluar', $request->tanggal);
        }

        $suratMasuk = $queryMasuk->get()->map(function($item) {
            $item->jenis = 'Surat Masuk';
            $item->tanggal = $item->tgl_terima;
            return $item;
        });

        $suratKeluar = $queryKeluar->get()->map(function($item) {
            $item->jenis = 'Surat Keluar';
            $item->tanggal = $item->tgl_keluar;
            return $item;
        });

        $arsip = $suratMasuk->merge($suratKeluar)->sortByDesc('tanggal');

        return view('arsip.index', compact('arsip'));
    }

    public function profile()
    {
        if (!session('is_logged_in')) return redirect()->route('login');
        return view('profile.edit');
    }

    public function updateProfile(Request $request)
    {
        if (!session('is_logged_in')) return redirect()->route('login');

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed'
        ]);

        // Update Session Data
        session(['user_name' => $request->name]);

        // Note: In a real app with DB auth, you would update the User model here.
        // $user = Auth::user();
        // $user->name = $request->name;
        // if ($request->filled('password')) {
        //     $user->password = Hash::make($request->password);
        // }
        // $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
