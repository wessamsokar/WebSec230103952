<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileEncryptionController extends Controller
{
    private function ensureDirectoriesExist()
    {
        $paths = ['encrypted', 'decrypted'];
        foreach ($paths as $path) {
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }
        }
    }

    public function encryptFile(Request $request)
    {
        try {
            $this->ensureDirectoriesExist();

            $request->validate([
                'file' => 'required|file',
                'password' => 'required|string|min:8',
            ]);

            $file = $request->file('file');
            if (!$file->isValid()) {
                return back()->with('error', 'Invalid file upload.');
            }

            $contents = file_get_contents($file->getRealPath());

            // Generate encryption key and IV from password
            $key = hash('sha256', $request->password);
            $iv = substr(hash('sha256', $request->password), 0, 16);

            // Encrypt file contents
            $encrypted = openssl_encrypt($contents, 'AES-256-CBC', $key, 0, $iv);

            if ($encrypted === false) {
                return back()->with('error', 'Encryption failed. Please try again.');
            }

            $originalExtension = $file->getClientOriginalExtension();

            // Add extension to encrypted filename
            $filename = 'encrypted' . DIRECTORY_SEPARATOR . 'encrypted_' . time() . '_' . $originalExtension . '.enc';

            // Store encrypted content with metadata
            $encryptedData = json_encode([
                'ext' => $originalExtension,
                'data' => $encrypted
            ]);

            // Store file with error checking
            if (!Storage::put($filename, $encryptedData)) {
                Log::error("Failed to save encrypted file: " . $filename);
                return back()->with('error', 'Failed to save encrypted file.');
            }

            $fullPath = Storage::path($filename);

            // Verify file exists and is readable
            if (!file_exists($fullPath) || !is_readable($fullPath)) {
                Log::error("Generated file not found or not readable: " . $fullPath);
                return back()->with('error', 'Generated file not found or not accessible.');
            }

            return response()->download($fullPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error("Encryption error: " . $e->getMessage());
            return back()->with('error', 'An error occurred during encryption: ' . $e->getMessage());
        }
    }

    public function decryptFile(Request $request)
    {
        try {
            $this->ensureDirectoriesExist();

            $request->validate([
                'file' => 'required|file',
                'password' => 'required|string|min:8',
            ]);

            $file = $request->file('file');
            if (!$file->isValid()) {
                return back()->with('error', 'Invalid file upload.');
            }

            $contents = file_get_contents($file->getRealPath());

            // Decode the JSON structure
            $encryptedData = json_decode($contents, true);
            if (!$encryptedData || !isset($encryptedData['ext']) || !isset($encryptedData['data'])) {
                return back()->with('error', 'Invalid encrypted file format.');
            }

            $originalExtension = $encryptedData['ext'];

            // Decrypt the actual data
            $decrypted = openssl_decrypt(
                $encryptedData['data'],
                'AES-256-CBC',
                hash('sha256', $request->password),
                0,
                substr(hash('sha256', $request->password), 0, 16)
            );

            if ($decrypted === false) {
                return back()->with('error', 'Decryption failed. Invalid password or corrupted file.');
            }

            // Use original extension for decrypted file
            $filename = 'decrypted' . DIRECTORY_SEPARATOR . 'decrypted_' . time() . '.' . $originalExtension;

            if (!Storage::put($filename, $decrypted)) {
                Log::error("Failed to save decrypted file: " . $filename);
                return back()->with('error', 'Failed to save decrypted file.');
            }

            $fullPath = Storage::path($filename);

            if (!file_exists($fullPath) || !is_readable($fullPath)) {
                Log::error("Generated file not found or not readable: " . $fullPath);
                return back()->with('error', 'Generated file not found or not accessible.');
            }

            return response()->download($fullPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error("Decryption error: " . $e->getMessage());
            return back()->with('error', 'An error occurred during decryption: ' . $e->getMessage());
        }
    }
}
