<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Response; 
use DOMDocument;

class FileUploadController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt',
        ]);

        $file = $request->file('file');
        $content = file_get_contents($file->getRealPath());

        // Extract data from the file
        $lines = explode("\n", $content);
        $date = null;
        $programs = [];

        foreach ($lines as $line) {
            if (preg_match('/^\d{4}-\d{2}-\d{2}/', $line)) {
                $date = trim($line);
            } elseif (strpos($line, '---') !== false) {
                $parts = explode('---', $line);
                if (count($parts) >= 4) {
                    $time = trim($parts[0]);
                    $title = trim($parts[1]);
                    $description = trim($parts[2]);

                    $programs[] = [
                        'date' => $date,
                        'time' => $time,
                        'title' => $title,
                        'description' => $description,
                    ];
                }
            }
        }

        // guarda en la base de datos
        foreach ($programs as $program) {
            Program::create($program);
        }

        return redirect()->back()->with('success', 'el archivo se subio exitosamente!');
    }

    //metodos para el filtrado

    public function showFilterForm()
    {
        return view('filter');
    }

    /**
     * filtra los programas por fecha y muestra los resultados.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function filterPrograms(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Retrieve programs within the date range
        $programs = Program::whereBetween('date', [$startDate, $endDate])
                           ->orderBy('date')
                           ->orderBy('time')
                           ->get();

        // Check if the "View XML" button was clicked
        if ($request->has('view_xml')) {
            // Generate XML
            $xml = new \SimpleXMLElement('<programacion/>');
            $xml->addAttribute('inicio', $startDate . ' 00:00:00');
            $xml->addAttribute('fin', $endDate . ' 23:59:59');

            foreach ($programs as $program) {
                $evento = $xml->addChild('evento');
                $evento->addChild('fecha-hora', $program->date . ' ' . $program->time);
                $evento->addChild('titulo', $program->title);
                $evento->addChild('sinopsis', $program->description);
            }

            // Format the XML using DOMDocument
            $dom = new DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());

            // Get the formatted XML as a string
            $xmlContent = $dom->saveXML();

            // Pass XML content to the view
            return view('programacion', compact('xmlContent'));
        }

        // Default behavior: return the filter view with programs
        return view('filter', compact('programs', 'startDate', 'endDate'));
    }


}