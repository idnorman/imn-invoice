<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::all();
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {

        $rules = [
            'nama'                  => 'required',
            'inisial'               => 'required',
            'email'                 => 'required|email|unique:users',
            'jabatan'               => 'required',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required'
        ];

        $messages = [
            'nama.required'                      => 'Nama tidak boleh kosong',
            'inisial.required'                   => 'Inisial tidak boleh kosong',
            'email.required'                     => 'Email tidak boleh kosong',
            'email.email'                        => 'Email tidak valid',
            'email.unique'                       => 'Email telah terdaftar',
            'jabatan.required'                   => 'Jabatan tidak boleh kosong',
            'password.required'                  => 'Password tidak boleh kosong',
            'password.confirmed'                 => 'Password dan konfirmasi password tidak sama',
            'password_confirmation.required'     => 'Konfirmasi password tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        $data['password']   = Hash::make($request->password);

        $data = [
            'nama' => $request->nama,
            'inisial' => $request->inisial,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'jabatan' => $request->jabatan,
            'is_superadmin' => $request->is_superadmin,
            'password' => Hash::make($request->password)
        ];

        User::insert($data);
        
        return redirect()->route('users.index')->with('success', 'Data Pengguna Berhasil di Tambah');
    }

    public function show($id)
    {
        $user = User::find($id);

    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.user.edit', compact('user'));
    }

    public function update(Request $request)
    {

        $user = User::find($request->id);

        if($user->email == $request->email){
            $emailRules = 'required|email';
        }else{
            $emailRules = 'required|email|unique:users';
        }

        if($request->password){
            $passwordRules = 'required|confirmed';
            $passwordConfirmationRules = 'required';
        }else{
            $passwordRules = '';
            $passwordConfirmationRules = '';
        }

        $rules = [
            'nama'                  => 'required',
            'email'                 => $emailRules,
            'inisial'               => 'required',
            'jabatan'               => 'required',
            'password'              => $passwordRules,
            'password_confirmation' => $passwordConfirmationRules
        ];

        $messages = [
            'nama.required'                      => 'Nama tidak boleh kosong',
            'email.required'                     => 'Email tidak boleh kosong',
            'email.email'                        => 'Email tidak valid',
            'email.unique'                       => 'Email telah terdaftar',
            'inisial.required'                   => 'Inisial tidak boleh kosong',
            'jabatan.required'                   => 'Jabatan tidak boleh kosong',
            'password.required'                  => 'Password tidak boleh kosong',
            'password.confirmed'                 => 'Password dan konfirmasi password tidak sama',
            'password_confirmation.required'     => 'Konfirmasi password tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nama' => $request->nama,
            'inisial' => $request->inisial,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'jabatan' => $request->jabatan,
            'is_superadmin' => $request->is_superadmin
        ];
        
        $data['password'] = $user->password;
        if($request->password){
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return redirect()->route('users.index')->with('success', 'Data Berhasil di Ubah');
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        if($user->tanda_tangan){
            unlink(public_path('/_images/tanda_tangan/' . $user->tanda_tangan));
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna Berhasil di Hapus');
    }

    public function profileEdit(){
        $user = User::find(auth()->user()->id);
        return view('pages.user.profileEdit', compact('user'));
    }

    public function profileUpdate(Request $request){
        $user = User::find(auth()->user()->id);

        if($user->email == $request->email){
            $emailRules = 'required|email';
        }else{
            $emailRules = 'required|email|unique:users';
        }

        if($request->password){
            $passwordRules = 'required|confirmed';
            $passwordConfirmationRules = 'required';
        }else{
            $passwordRules = '';
            $passwordConfirmationRules = '';
        }

        $rules = [
            'nama'                  => 'required',
            'email'                 => $emailRules,
            'inisial'               => 'required',
            'password'              => $passwordRules,
            'password_confirmation' => $passwordConfirmationRules
        ];

        $messages = [
            'nama.required'                      => 'Nama tidak boleh kosong',
            'email.required'                     => 'Email tidak boleh kosong',
            'email.email'                        => 'Email tidak valid',
            'email.unique'                       => 'Email telah terdaftar',
            'inisial.required'                   => 'Inisial tidak boleh kosong',
            'password.required'                  => 'Password tidak boleh kosong',
            'password.confirmed'                 => 'Password dan konfirmasi password tidak sama',
            'password_confirmation.required'     => 'Konfirmasi password tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);

        $data = [
            'nama' => $request->nama,
            'inisial' => $request->inisial,
            'email' => $request->email,
            'telepon' => $request->telepon
        ];

        

        $data['tanda_tangan'] = $user->tanda_tangan;
        if($request->tanda_tangan){
            $tanda_tangan         = $request->tanda_tangan;
            $fileName          = Str::random(8) . '_' . $tanda_tangan->getClientOriginalName();
            $tanda_tangan         = $tanda_tangan->move(public_path() . '/_images/tanda_tangan/', $fileName);
            $data['tanda_tangan']  = $fileName;
        }
        
        $data['password'] = $user->password;
        if($request->password){
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return back()->with('success', 'Data Berhasil di Ubah');

    }
}
