<?php

namespace App\Http\Controllers;

use App\Models\NoteAttachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|string',
            'encrypted_filename' => 'required|string|max:500',
            'mime_type' => 'nullable|string|max:100',
            'size' => 'required|integer|max:26214400', // 25MB
            'temp_id' => 'required|string|uuid',
        ]);

        // Decode base64 encrypted blob
        $encryptedContent = base64_decode($request->file);

        // Generate storage path
        $storagePath = 'attachments/' . Str::uuid() . '.enc';

        // Store on R2
        Storage::disk('r2')->put($storagePath, $encryptedContent);

        // Store temp record in session
        $tempAttachments = session('temp_attachments', []);
        $tempAttachments[$request->temp_id] = [
            'encrypted_filename' => $request->encrypted_filename,
            'storage_path' => $storagePath,
            'mime_type' => $request->mime_type,
            'size' => $request->size,
        ];
        session(['temp_attachments' => $tempAttachments]);

        return response()->json([
            'success' => true,
            'temp_id' => $request->temp_id,
        ]);
    }

    public function download(NoteAttachment $attachment): Response
    {
        // Get encrypted content from R2
        $content = Storage::disk('r2')->get($attachment->storage_path);

        return response($content)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment');
    }
}
