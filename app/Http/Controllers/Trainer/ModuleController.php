<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainingModule::with(['trainer', 'training'])->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('judul', 'like', "%{$s}%")
                  ->orWhere('deskripsi', 'like', "%{$s}%")
                  ->orWhere('kategori', 'like', "%{$s}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tipe') && $request->tipe !== 'all') {
            if ($request->tipe === 'pdf') {
                $query->where('file_type', 'pdf');
            } elseif ($request->tipe === 'ppt') {
                $query->whereIn('file_type', ['ppt', 'pptx']);
            }
        }

        $modules = $query->paginate(9)->withQueryString();
        $trainings = Training::latest('tanggal')->get();
        $categories = TrainingModule::select('kategori')->distinct()->pluck('kategori');

        return view('trainer.modules.index', compact('modules', 'trainings', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'kategori' => 'required|string|max:100',
            'training_id' => 'nullable|exists:trainings,id',
            'modul_file' => 'required|file|mimes:pdf,ppt,pptx|max:25600', // max 25MB
        ], [
            'judul.required' => 'Judul modul pelatihan wajib diisi.',
            'kategori.required' => 'Kategori materi wajib dipilih.',
            'modul_file.required' => 'Berkas modul pelatihan (PDF/PPT/PPTX) wajib diunggah.',
            'modul_file.mimes' => 'Format berkas harus berupa Dokumen PDF (.pdf) atau Presentasi PowerPoint (.ppt, .pptx).',
            'modul_file.max' => 'Ukuran berkas maksimal 25 MB.',
        ]);

        $file = $request->file('modul_file');
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $fileSize = $file->getSize();

        $savedFileName = Str::slug($request->judul) . '-' . time() . '.' . $extension;
        $path = $file->storeAs('training_modules', $savedFileName, 'public');

        TrainingModule::create([
            'trainer_id' => $request->user()->id,
            'training_id' => $request->training_id ?: null,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'file_path' => $path,
            'file_name' => $originalName,
            'file_type' => $extension,
            'file_size' => $fileSize,
            'downloads_count' => 0,
        ]);

        return redirect()->route('trainer.modules.index')->with('success', 'Modul pelatihan berhasil diunggah.');
    }

    public function preview($id)
    {
        $module = TrainingModule::findOrFail($id);

        if (!Storage::disk('public')->exists($module->file_path)) {
            abort(404, 'Berkas modul tidak ditemukan di penyimpanan server.');
        }

        $fullPath = Storage::disk('public')->path($module->file_path);
        
        $mimeType = match(strtolower($module->file_type)) {
            'pdf' => 'application/pdf',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            default => 'application/octet-stream',
        };

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $module->file_name . '"',
        ]);
    }

    public function destroy($id)
    {
        $module = TrainingModule::findOrFail($id);

        if ($module->file_path && Storage::disk('public')->exists($module->file_path)) {
            Storage::disk('public')->delete($module->file_path);
        }

        $module->delete();

        return redirect()->route('trainer.modules.index')->with('success', 'Modul pelatihan berhasil dihapus.');
    }

    public function download($id)
    {
        $module = TrainingModule::findOrFail($id);
        $module->increment('downloads_count');

        if (!Storage::disk('public')->exists($module->file_path)) {
            return back()->with('error', 'Berkas modul tidak ditemukan di penyimpanan server.');
        }

        return Storage::disk('public')->download($module->file_path, $module->file_name);
    }
}

