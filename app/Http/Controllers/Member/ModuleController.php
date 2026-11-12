<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\TrainingModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $categories = TrainingModule::select('kategori')->distinct()->pluck('kategori');

        return view('member.modules.index', compact('modules', 'categories'));
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

