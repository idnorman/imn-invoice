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


        // $data               = $request->except('_token', 'password_confirmation', 'signature');
        $data['password']   = Hash::make($request->password);

        // if($request->signature){
        //     $signature         = $request->signature;
        //     $fileName          = Str::random(8) . '_' . $signature->getClientOriginalName();
        //     $signature         = $signature->move(public_path() . '/_images/signature/', $fileName);
        //     $data['signature']  = $fileName;
        // }
        
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
        
        return route('users.index')->with('success', 'Data Pengguna Berhasil di Tambah');
    }

    public function show($id)
    {
        $user = User::find($id);
        // $rentals = Rental::with(['car'])->where('user_id', $id)->paginate(4);
        // return view('pages.user.show', compact('user', 'rentals'));
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


        // $fileName = $user->signature;
        // if($request->signature){
        //     $oldfileName  = $fileName;

        //     $signature         = $request->signature;
        //     $fileName          = Str::random(8) . '_' . $signature->getClientOriginalName();
        //     $signature         = $signature->move(public_path() . '/_images/signature/', $fileName);

        //     if(!empty($oldfileName)){
        //         $oldfileName  = unlink(public_path('/_images/signature/' . $oldfileName));
        //     }
        // }

        // $data          = $request->except('_token', 'password_confirmation', 'signature');
        // $data['signature']  = $fileName;
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
        
        return back()->with('success', 'Data Berhasil di Ubah');
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        // if($user->signature){
        //     unlink(public_path('/_images/signature/' . $user->signature));
        // }
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
