<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\TVSchedule;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        $uploads = Upload::all();
        return view('uploads.index', compact('uploads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt|max:2048',
        ]);

        if ($request->file('file')->isValid()) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');

            $upload = Upload::create([
                'filename' => $filename,
                'filepath' => $path,
            ]);

            // Process and store extracted data
            $content = Storage::disk('public')->get($upload->filepath);
            $entries = $this->parseTvSchedule($content);

            foreach ($entries as $entry) {
                TVSchedule::create($entry);
            }

            return redirect()->route('uploads.index')->with('success', 'File uploaded and data stored successfully.');
        }

        return back()->withErrors(['file' => 'Invalid file upload.']);
    }

    public function show(Upload $upload)
    {
        $entries = TVSchedule::whereDate('date', now())->get(); // Show today's schedule

        return view('uploads.show', compact('upload', 'entries'));
    }

    private function parseTvSchedule($content)
    {
        $lines = explode("\n", trim($content));
        $entries = [];
        $currentDate = null;

        foreach ($lines as $line) {
            $line = trim($line);

            // If the line is a date (YYYY-MM-DD), update the current date
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $line)) {
                $currentDate = $line;
                continue;
            }

            // Extract time, title, and description
            if (preg_match('/^(\d{2}:\d{2})---(.*?)---(.*?)---/', $line, $matches)) {
                $entries[] = [
                    'date' => $currentDate,
                    'time' => $matches[1],
                    'title' => $matches[2],
                    'description' => $matches[3],
                ];
            }
        }

        return $entries;
    }
}
