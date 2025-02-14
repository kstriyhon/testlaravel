<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TvShow;

class FileUploadController extends Controller
{
    public function index()
    {
        $tvShows = TvShow::all(); // Fetch data from the database
        return view('upload', compact('tvShows'));
    }

    public function upload(Request $request)
    {
        // Validate uploaded file
        $request->validate([
            'file' => 'required|mimes:txt|max:2048'
        ]);

        // Read file content
        $file = $request->file('file');
        $content = file_get_contents($file->getRealPath());

        // Extract structured data
        $lines = explode("\n", trim($content));

        foreach ($lines as $line) {
            $parts = explode('---', $line);

            if (count($parts) > 2) {
                $time = trim($parts[0]); // Extract time
                $title = trim($parts[1]); // Extract title
                $description = trim($parts[2]); // Extract description

                // Store extracted data in database
                TvShow::create([
                    'time' => $time,
                    'title' => $title,
                    'description' => $description
                ]);
            }
        }

        return redirect('/upload')->with('success', 'File uploaded and data inserted successfully!');
    }
}
