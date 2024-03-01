<?php

namespace App\Http\Controllers;

use App\Models\TContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
class PreviewFileController extends Controller
{
    public function index(Request $request)
    {
        $content = TContent::find($request->id);
        $content_type = $content->content_type;
        $url = Storage::disk('local')->temporaryUrl($content->content_link, now()->addMinutes(5));
        return view('home.preview', compact('content_type','url'));
    }
    public function downloadFile(Request $request)
    {
        $content = TContent::find($request->id);
        $content_type = $content->content_type;
    
        if ($content_type == 'Pdf') {
            $filePath = Storage::disk('local')->path($content->content_link);
            $fileName = 'your-custom-filename.pdf';
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
        } elseif ($content_type == 'Video') {
            $filePath = Storage::disk('local')->path($content->content_link);
            $fileName = 'your-custom-filename.mp4';
            $headers = [
                'Content-Type' => 'video/mp4',
            ];
        } elseif ($content_type == 'Flash') {
            $filePath = Storage::disk('local')->path($content->content_link);
            $fileName = 'your-custom-filename.swf';
            $headers = [
                'Content-Type' => 'application/x-shockwave-flash',
            ];
        }
    
        return Response::download($filePath, $fileName, $headers);
    }
}
