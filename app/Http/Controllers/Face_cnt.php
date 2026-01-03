<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFace;
use App\Models\M_file;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class Face_cnt extends Controller
{
    public function save_face_data(Request $request)
    {
        // Validate request
        $request->validate([
            'emp_id' => 'required|string',
            'face_descriptor' => 'required|string',
            'file_added' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        $empId = $request->input('emp_id');
        $faceDescriptor = $request->input('face_descriptor');
        $currentTime = Carbon::now();

        $fileName = null;

        // Handle file upload
        if ($request->hasFile('file_added')) {
            $file = $request->file('file_added');
            $currentDateTime = $currentTime->format('Y-m-d_H-i-s');
            $fileName = $currentDateTime . '-' . $file->getClientOriginalName();

            // Upload to S3 (configured in config/filesystems.php)
            Storage::disk('s3')->putFileAs('docs', $file, $fileName);
        }

        // Check if user_face exists
        $userFace = UserFace::where('user_id', $empId)
            ->where('status', 'active')
            ->first();

        if ($userFace) {
            // Update existing
            $userFace->update([
                'file' => $fileName,
                'encode' => $faceDescriptor,
                'updated_at' => $currentTime,
            ]);

            // Update m_file record
            M_file::where('f_id', $empId)
                ->where('cat', 'image')
                ->update(['file' => $fileName]);

            Session::put('photo_updated', true);
            return redirect()->route('camera_web', ['emp_id' => $empId]);
        }

        // Insert new user_face record
        // UserFace::create([
        //     'user_id' => $empId,
        //     'file' => $fileName,
        //     'encode' => $faceDescriptor,
        //     'status' => 'active',
        //     'c_by' => auth()->id() ?? 0, // adjust as needed
        //     'created_at' => $currentTime,
        //     'updated_at' => $currentTime,
        // ]);

        // Insert into m_file
        // M_file::create([
        //     'f_id' => $empId,
        //     'cat' => 'image',
        //     'file' => $fileName,
        //     'status' => 'active', // adjust if needed
        //     'c_by' => auth()->id() ?? 0, // adjust as needed
        // ]);

        Session::put('photo_updated', true);
        return redirect()->route('camera_web', ['emp_id' => $empId]);
    }
}
