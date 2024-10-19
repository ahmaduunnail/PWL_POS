<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'name', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id 
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()  // menambahkan kolom index / no urut (default name kolom: DT_RowIndex)  
            ->addColumn('aksi', function ($user) {  // menambahkan kolom aksi  
                /* $btn  = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';  
        $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';  
        $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">'  
                . csrf_field() . method_field('DELETE') .   
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';*/
                $btn  = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html  
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'level' => $level]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'name' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        // Prepare the new request data
        $newReq = [
            'level_id' => $request->level_id,
            'username' => $request->username,
            'name'     => $request->name,
            'password' => $request->password, // hash the password
        ];

        // Handle profile image file upload
        $fileExtension = $request->file('file_profil')->getClientOriginalExtension();
        $fileName = 'profile_' . Auth::user()->user_id . '.' . $fileExtension;

        // Check if an existing profile picture exists and delete it
        $oldFile = 'profile_pictures/' . $fileName;
        if (Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        // Store the new file with the user id as the file name
        $path = $request->file('file_profil')->storeAs('profile_pictures', $fileName, 'public');
        session(['profile_img_path' => $path]);

        // Add the profile file name to the new request data
        $newReq['image_profile'] = $path;

        // Create the new user record in the database
        UserModel::create($newReq);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user';

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'name' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        $newReq = [
            'level_id' => $request->level_id,
            'username' => $request->username,
            'name'     => $request->name,
        ];

        $check = UserModel::find($id);
        if ($check) {
            // If password is provided, add it to the update request
            if ($request->filled('password')) {
                $newReq['password'] = $request->password; // hash the password
            }

            // Handle profile image file upload
            if ($request->hasFile('file_profil')) {
                // Define the file name using the user's id and the file extension
                $fileExtension = $request->file('file_profil')->getClientOriginalExtension();
                $fileName = 'profile_' . Auth::user()->user_id . '.' . $fileExtension;

                // Check if an existing profile picture exists and delete it
                $oldFile = 'profile_pictures/' . $fileName;
                if (Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                // Store the new file with the user id as the file name
                $path = $request->file('file_profil')->storeAs('profile_pictures', $fileName, 'public');

                // Add file name to the update request
                $newReq['image_profile'] = $path;
            }

            // Update the user data in the database
            $check->update($newReq);
        }

        return redirect('/user')->with('success', "Data user berhasil diubah");
    }

    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function show_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        return view('user.show_ajax', ['user' => $user, 'level' => $level]);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id'   => 'required|integer',
                'username'   => 'required|string|min:3|unique:m_user,username',
                'name'       => 'required|string|max:100',
                'password'   => 'required|min:6',
                'file_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];

            // Validate the request
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Prepare the new request data
            $newReq = [
                'level_id' => $request->level_id,
                'username' => $request->username,
                'name'     => $request->name,
                'password' => $request->password, // hash the password
            ];

            // Handle profile image file upload
            $fileExtension = $request->file('file_profil')->getClientOriginalExtension();
            $fileName = 'profile_' . Auth::user()->user_id . '.' . $fileExtension;

            // Check if an existing profile picture exists and delete it
            $oldFile = 'profile_pictures/' . $fileName;
            if (Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            // Store the new file with the user id as the file name
            $path = $request->file('file_profil')->storeAs('profile_pictures', $fileName, 'public');
            session(['profile_img_path' => Auth::user()->image_profile]);

            // Add the profile file name to the new request data
            $newReq['image_profile'] = $path;

            // Create the new user record in the database
            UserModel::create($newReq);

            return response()->json([
                'status'  => true,
                'message' => 'Data user berhasil disimpan',
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {

            $rules = [
                'level_id'   => 'required|integer',
                'username'   => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'name'       => 'required|max:100',
                'password'   => 'nullable|min:6|max:20',
                'file_profil' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Prepare the request data
            $newReq = [
                'level_id' => $request->level_id,
                'username' => $request->username,
                'name'     => $request->name,
            ];

            $check = UserModel::find($id);
            if ($check) {
                // If password is provided, add it to the update request
                if ($request->filled('password')) {
                    $newReq['password'] = $request->password; // hash the password
                }

                // Handle profile image file upload
                if ($request->hasFile('file_profil')) {
                    // Define the file name using the user's id and the file extension
                    $fileExtension = $request->file('file_profil')->getClientOriginalExtension();
                    $fileName = 'profile_' . Auth::user()->user_id . '.' . $fileExtension;

                    // Check if an existing profile picture exists and delete it
                    $oldFile = 'profile_pictures/' . $fileName;
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }

                    // Store the new file with the user id as the file name
                    $path = $request->file('file_profil')->storeAs('profile_pictures', $fileName, 'public');
                    session(['profile_img_path' => Auth::user()->image_profile]);

                    // Add file name to the update request
                    $newReq['image_profile'] = $path;
                }

                // Update the user data in the database
                $check->update($newReq);

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        // return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);

            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
            return redirect('/');
        }
    }

    public function export_pdf()
    {
        $user = UserModel::select('level_id', 'username', 'name')
            ->get();

        $pdf = Pdf::loadView('user.export_pdf', ['user' => $user]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->render();

        return $pdf->stream('Data User' . date('Y-m-d H:i:s') . '.pdf');
    }
}
