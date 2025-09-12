<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    private $allowedExtensions = [
        'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico'],
        'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
        'videos' => ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv', '3gp'],
        'audio' => ['mp3', 'wav', 'ogg', 'aac', 'flac', 'm4a', 'wma']
    ];

    private $blockedExtensions = [
        'code' => ['html', 'css', 'js', 'json', 'xml', 'php', 'py', 'java', 'cpp', 'c', 'h', 'sql', 'sh'],
        'archives' => ['zip', 'rar', '7z', 'tar', 'gz', 'bz2'],
        'text' => ['txt', 'rtf', 'csv', 'log', 'md', 'yml', 'yaml', 'ini', 'conf'],
        'office_legacy' => ['odt', 'ods', 'odp'],
        'executables' => ['exe', 'bat', 'cmd', 'msi', 'deb', 'rpm', 'dmg', 'app'],
        'system' => ['dll', 'sys', 'ini', 'cfg', 'conf', 'log']
    ];

    private $maxFileSize = 51200; 
    private $basePath = 'filemanager'; 

    public function index(Request $request)
    {
        $page_data['page_title'] = 'File Manager';
        $page_data['select_mode'] = $request->get('select_mode', false);
        $page_data['file_type'] = $request->get('file_type', 'image');
        $page_data['input_id'] = $request->get('input_id', '');
        
        if ($page_data['select_mode']) {
            
            return view('backend.filemanager.select', $page_data);
        }
        
        return view('backend.filemanager.index', $page_data);
    }

    public function browse(Request $request)
    {
        $path = $request->get('path', '');
        $fileTypeFilter = $request->get('file_type', 'image');
        $selectMode = $request->get('select_mode', false);
        $path = $this->sanitizePath($path);
        
        $fullPath = public_path($this->basePath . '/' . $path);
        
        if (!file_exists($fullPath)) {
            return response()->json(['error' => 'Directory not found'], 404);
        }

        $items = [];
        $files = scandir($fullPath);
        
      

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            $filePath = $fullPath . '/' . $file;
            $relativePath = $path ? $path . '/' . $file : $file;
            
            $isDir = is_dir($filePath);
            $fileType = 'file';
            $shouldInclude = false;
            
            if ($isDir) {
                $fileType = 'folder';
                $shouldInclude = true; 
            } else {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $category = $this->getFileCategory($extension);
                
    
                if (!$selectMode) {
                    $shouldInclude = true;
             
                    switch ($category) {
                        case 'images':
                            $fileType = 'image';
                            break;
                        case 'documents':
                            $fileType = 'document';
                            break;
                        case 'videos':
                            $fileType = 'video';
                            break;
                        default:
                            $fileType = 'file';
                            break;
                    }
                } else {
                    switch ($category) {
                        case 'images':
                            $fileType = 'image';
                            $shouldInclude = (in_array($fileTypeFilter, ['image', 'images']));
                            break;
                        case 'documents':
                            $fileType = 'document';
                            $shouldInclude = (in_array($fileTypeFilter, ['document', 'documents']));
                            break;
                        case 'videos':
                            $fileType = 'video';
                            $shouldInclude = (in_array($fileTypeFilter, ['video', 'videos']));
                            break;
                        case 'audio':
                            $fileType = 'audio';
                            $shouldInclude = (in_array($fileTypeFilter, ['audio', 'audios']));
                            break;
                        default:
                            $fileType = 'file';
                            $shouldInclude = (in_array($fileTypeFilter, ['file', 'all']) || $category === 'unknown');
                            break;
                    }
                }
                
            }
            
            if (!$shouldInclude) continue;
            
            $item = [
                'name' => $file,
                'path' => $relativePath,
                'type' => $fileType,
                'size' => is_file($filePath) ? $this->formatBytes(filesize($filePath)) : null,
                'modified' => date('Y-m-d H:i:s', filemtime($filePath)),
                'url' => is_file($filePath) ? $this->generateFileUrl($relativePath) : null
            ];

            if (!$isDir) {
                $item['extension'] = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $item['category'] = $this->getFileCategory($item['extension']);
            }

            $items[] = $item;
        }

        usort($items, function($a, $b) {
            if ($a['type'] !== $b['type']) {
                return $a['type'] === 'folder' ? -1 : 1;
            }
            
            $timeA = strtotime($a['modified']);
            $timeB = strtotime($b['modified']);
            return $timeB - $timeA; 
        });

        return response()->json([
            'success' => true,
            'files' => $items,
            'current_path' => $path,
            'parent_path' => dirname($path) !== '.' ? dirname($path) : ''
        ]);
    }

    public function createFolder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\-_\s]+$/',
            'path' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $path = $this->sanitizePath($request->get('path', ''));
        $folderName = $this->sanitizeFileName($request->name);
        
        $fullPath = public_path($this->basePath . '/' . $path . '/' . $folderName);

        if (file_exists($fullPath)) {
            return response()->json(['error' => 'Folder already exists'], 409);
        }

        if (!File::makeDirectory($fullPath, 0755, true)) {
            return response()->json(['error' => 'Failed to create folder'], 500);
        }

        return response()->json(['success' => 'Folder created successfully']);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required',
            'files.*' => 'file|max:' . $this->maxFileSize,
            'path' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $path = $this->sanitizePath($request->get('path', ''));
        $uploadedFiles = [];
        $errors = [];

        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());

            if (!$this->isAllowedExtension($extension)) {
                $blockedCategory = $this->getBlockedFileCategory($extension);
                if ($blockedCategory) {
                    $errors[] = "File {$originalName}: {$blockedCategory} files are not allowed";
                } else {
                    $errors[] = "File {$originalName}: File type .{$extension} is not supported";
                }
                continue;
            }

            $filename = $this->generateSafeFilename($originalName);
            $destinationPath = public_path($this->basePath . '/' . $path);
            
            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            try {
                $file->move($destinationPath, $filename);
                $uploadedFiles[] = $filename;
            } catch (\Exception $e) {
                $errors[] = "File {$originalName}: Upload failed";
            }
        }

        $response = [
            'success' => count($uploadedFiles) > 0,
            'uploaded' => $uploadedFiles,
            'errors' => $errors,
        ];

        if (count($uploadedFiles) > 0) {
            $response['message'] = count($uploadedFiles) . ' file(s) uploaded successfully';
            if (count($errors) > 0) {
                $response['message'] .= ' (' . count($errors) . ' failed)';
            }
        } else {
            $response['message'] = 'No files were uploaded';
            if (count($errors) > 0) {
                $response['message'] = 'Upload failed: ' . $errors[0];
            }
        }

        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $deleted = [];
        $errors = [];

        foreach ($request->items as $item) {
            $sanitizedPath = $this->sanitizePath($item);
            $fullPath = public_path($this->basePath . '/' . $sanitizedPath);

            if (!file_exists($fullPath)) {
                $errors[] = "Item {$item}: Not found";
                continue;
            }

            try {
                if (is_dir($fullPath)) {
                    File::deleteDirectory($fullPath);
                } else {
                    unlink($fullPath);
                }
                $deleted[] = $item;
            } catch (\Exception $e) {
                $errors[] = "Item {$item}: Delete failed";
            }
        }

        return response()->json([
            'success' => count($deleted) > 0,
            'deleted' => $deleted,
            'errors' => $errors,
            'message' => count($deleted) . ' item(s) deleted successfully'
        ]);
    }

    public function rename(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_name' => 'required|string',
            'new_name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\-_\s\.]+$/',
            'path' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $basePath = $this->sanitizePath($request->get('path', ''));
        $oldName = $this->sanitizePath($request->old_name);
        $newName = $this->sanitizeFileName($request->new_name);

        $oldPath = public_path($this->basePath . '/' . $basePath . '/' . $oldName);
        $newPath = public_path($this->basePath . '/' . $basePath . '/' . $newName);

        if (!file_exists($oldPath)) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        if (file_exists($newPath)) {
            return response()->json(['error' => 'Item with new name already exists'], 409);
        }

        if (!rename($oldPath, $newPath)) {
            return response()->json(['error' => 'Failed to rename item'], 500);
        }

        return response()->json(['success' => 'Item renamed successfully']);
    }

    private function sanitizePath($path)
    {
        $path = str_replace(['../', '..\\', '../', '..\\'], '', $path);
        $path = trim($path, '/\\');
        return $path;
    }

    private function sanitizeFileName($filename)
    {
        $filename = preg_replace('/[^a-zA-Z0-9\-_\.\s]/', '', $filename);
        $filename = trim($filename);
        return $filename;
    }

    private function generateSafeFilename($originalName)
    {
        $pathInfo = pathinfo($originalName);
        $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
        $basename = $pathInfo['filename'];
        
        $basename = $this->sanitizeFileName($basename);
        $basename = Str::slug($basename, '_');
        
        $timestamp = time();
        
        return $basename . '_' . $timestamp . $extension;
    }

    private function isAllowedExtension($extension)
    {
        foreach ($this->allowedExtensions as $category => $extensions) {
            if (in_array($extension, $extensions)) {
                return true;
            }
        }
        return false;
    }

    private function getFileCategory($extension)
    {
        foreach ($this->allowedExtensions as $category => $extensions) {
            if (in_array($extension, $extensions)) {
                return $category;
            }
        }
        return 'unknown';
    }

    private function getBlockedFileCategory($extension)
    {
        foreach ($this->blockedExtensions as $category => $extensions) {
            if (in_array($extension, $extensions)) {
                switch ($category) {
                    case 'audio':
                        return 'Audio';
                    case 'code':
                        return 'Code';
                    case 'archives':
                        return 'Archive';
                    case 'text':
                        return 'Text';
                    case 'office_legacy':
                        return 'Legacy Office';
                    case 'executables':
                        return 'Executable';
                    case 'system':
                        return 'System';
                    default:
                        return 'Blocked';
                }
            }
        }
        return null;
    }

    private function generateFileUrl($relativePath)
    {
        
        return getBaseURL() . 'public/filemanager/' . $relativePath;
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
}
