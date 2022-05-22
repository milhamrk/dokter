<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Orangtua;
use App\Models\Anak;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class OrangtuaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(){
        $orangtua = Orangtua::all();
        return datatables()->of($orangtua)
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group btn-group-sm">';
            $btn .= '<a href="'.route('orangtua.edit',$row->id).'" type="button" id="btn-edit" class="btn btn-warning btn-icon"><i class="lni lni-pencil-alt "></i></a>';
            $btn .= '<button title="Delete" id="btn-delete" class="delete-modal btn btn-danger btn-icon"><i class="lni lni-trash"></i></button>';
            
            $btn .= '</div>';
            return $btn;
        })
        ->rawColumns(['action'])->addIndexColumn()->make(true);
    }
    public function index()
    {
        return view('admin.orangtua.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.orangtua.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = New User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role ="orangtua";
        if($user){
            $user->save();
        }
        if($user){
            $orangtua = new Orangtua();
            $orangtua->id_users=$user->id;
            $orangtua->nama = $request->nama;
            $orangtua->alamat = $request->alamat;
            $orangtua->pendidikan= $request->pendidikan;
            if($orangtua){
                $orangtua->save();
                return redirect('/');
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orangtua= Orangtua::find($id);

        return view('admin.orangtua.edit', compact('orangtua'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $orangtua = orangtua::find($id);
            $user = User::where('id', $orangtua->id_users)->update([
            
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => "orangtua"
        ]);
        
        
        if($user){
            $orangtua = $orangtua->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'pendidikan' => $request->pendidikan,
            ]);
            return redirect()->route('orangtua.index');
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orangtua = Orangtua::find($id);
        $user = User::where('id', $orangtua->id_users);
        $user->delete();
        $orangtua->delete();
        return response()->json(['data'=>'success delete data']);
    }
    public function registerUser(Request $request)
    {
        $messages = [
           
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',

        ];
        $validator = $request->validate([
            // 'NIK' => ['required', 'min:16',
            //             Rule::unique('dokter', 'NIK')],
            // 'nama' => 'required|min:3',
            'email' => ['required', 'email',
                        Rule::unique('users', 'email')],
            // 'password' => 'required',
            // 'no_telp' => 'required',
            // 'id_kecamatan' => 'required',
            // 'jenis_kelamin' => 'required',
            // 'tempat_lahir' => 'required',
            // 'tanggal_lahir' => 'required',
            // 'no_str' => 'required',
           
        ], $messages);
        DB::beginTransaction();
        try{

        
        $user = New User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role ="orangtua";
       
        $user->save();
       
        
            $orangtua = new Orangtua();
            $orangtua->id_users=$user->id;
            $orangtua->nama = $request->nama;
            $orangtua->id_kecamatan = $request->id_kecamatan;
            $orangtua->id_kelurahan = $request->id_kelurahan;
            $orangtua->tempat_lahir = $request->tempat_lahir;
            $orangtua->tanggal_lahir = $request->tanggal_lahir;
            $orangtua->alamat = $request->alamat;
            $orangtua->pendidikan= $request->pendidikan;
            
            $orangtua->save();
            DB::commit();
           
            Auth::loginUsingId($user->id);
            return redirect('/');
        }catch(Exception $e){
            DB::rollback();
            return redirect('/register')->with('error','Gagal menambahkan data');
        }
    }

    public function dataAnak(){
        $user = Auth::user();
        $orangtua = Orangtua::Where('id_users', Auth::user()->id)->value('id');
        $anak = Anak::Where('id_orangtua',$orangtua)->get();
        return datatables()->of($anak)
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group btn-group-sm">';
            $btn .= '<a href="'.route('anak.edit',$row->id).'" class="btn btn-warning btn-icon"><i class="lni lni-pencil-alt "></i></a>';
            $btn .= '<button title="Delete" id="btn-delete" class="delete-modal btn btn-danger btn-icon"><i class="lni lni-trash"></i></button>';
            
            $btn .= '</div>';
            return $btn;
        })
        ->addColumn('sekolah',function($row){
            return $row->sekolah->nama;
        })
        ->addColumn('kelas',function($row){
            return $row->kelas->kelas;
        })
        ->rawColumns(['action'])->addIndexColumn()->make(true);
    }

    public function viewDashboard(){
        return view('orangtua.dashboard.dashboard');
    }

    public function viewAnak()
    {
        return view('orangtua.anak.index');
    }
    public function viewTambahAnak()
    {
        return view ('orangtua.anak.create');
    }

    public function tambahAnak(Request $request)
    {
        $user = Auth::user();
        $orangtua = Orangtua::Where('id_users', Auth::user()->id)->value('id');

        $anak = new Anak();
        $anak->id_orangtua= $orangtua;
        $anak->nama = $request->nama;
        $anak->jenis_kelamin = $request->jenis_kelamin;
        $anak->tempat_lahir = $request->tempat_lahir;
        $anak->tanggal_lahir = $request->tanggal_lahir;
        $anak->id_sekolah = $request->sekolah;
        $anak->id_kelas = $request->kelas;

        $anak->save();
        return redirect()->route('viewanak');
    }
}
