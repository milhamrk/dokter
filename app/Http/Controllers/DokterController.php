<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PemeriksaanFisik;



class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data(){
        $dokter = Dokter::all();
        return datatables()->of($dokter)
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group btn-group-sm">';
            $btn .= '<a href="'.route('dokter.edit',$row->id).'" type="button" id="btn-edit" class="btn btn-warning btn-icon"><i class="lni lni-pencil-alt "></i></a>';
            $btn .= '<button title="Delete" id="btn-delete" class="delete-modal btn btn-danger btn-icon"><i class="lni lni-trash"></i></button>';
            
            $btn .= '</div>';
            return $btn;
        })
        ->rawColumns(['action'])->addIndexColumn()->make(true);
    }
    public function index()
    {
        
        return view('admin.dokter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dokter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'NIK.required' => 'NIK wajib diisi.',
            'NIK.unique' => 'NIK tidak boleh sama.',
            'NIK.min' => 'NIK harus 16 digit.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 huruf.',
            'jenis_kelamin.required' => 'Jenis Kelamin harus diisi.',
            'Tempat_lahir.required' => 'Tempat lahir harus diisi',
            'Tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terpakai.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 4 karaketer.',
            'no_telp.required' => 'No telepon wajib diisi.',
            'id_kecamatan.required' => 'Kecamatan wajib diisi.',

        ];
        $validator = $request->validate([
            // 'NIK' => ['required', 'min:16',
            //             Rule::unique('dokter', 'NIK')],
            // 'nama' => 'required|min:3',
            // 'email' => ['required', 'email',
            //             Rule::unique('users', 'email')],
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
        $user->role ="dokter";
        $user->save();
        
            $dokter = new Dokter();
            $dokter->id_users=$user->id;
            $dokter->id_kecamatan = $request->kecamatan;
            $dokter->nik = $request->nik;
            $dokter->nama = $request->nama;
            $dokter->jenis_kelamin = $request->jenis_kelamin;
            $dokter->tempat_lahir = $request->tempat_lahir;
            $dokter->tanggal_lahir = $request->tanggal_lahir;
            $dokter->no_telp = $request->no_telp;
            $dokter->no_str= $request->no_str;
            $dokter->save();
                  
            
            DB::commit();
            return redirect()->route('dokter.index');
        
        }catch(\Exception $e){
        DB::rollback();
        return redirect()->route('dokter.create')->with('error','Gagal menambahkan data');
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
        $dokter = Dokter::find($id);
    
        return view('admin.dokter.edit',compact('dokter'));
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
        $dokter = Dokter::find($id);
        $user = User::where('id', $dokter->id_users)->update([
            
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => "dokter"
        ]);
        
        
        if($user){
            $dokter = $dokter->update([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telp' => $request->no_telp,
            'no_str' => $request->no_str

            ]);
            return redirect()->route('dokter.index');
            
        }


    }
    public function viewDashboard()
    {
        return view('dokter.dashboard');
    }

    public function profil()
    {
        return view('dokter.profil');
    }
    public function profil_edit($id)
    {   
        $logdokter = Auth::user()->dokter;
        $dokter = $logdokter->find($id);
        return view('dokter.profil-edit',compact('dokter'));
    }
    public function profil_update(Request $request, $id)
    {
 
        $logdokter = Auth::user()->dokter;
        $dokter = $logdokter->find($id);
        $dokter->nik = $request->nik;
        $dokter->nama =$request->nama;
        $dokter->jenis_kelamin = $request->jenis_kelamin;
        $dokter->tempat_lahir=  $request->tempat_lahir;
        $dokter->tanggal_lahir= $request->tanggal_lahir;
        $dokter->no_telp = $request->no_telp;
        $dokter->no_str= $request->no_str;
        if($request->hasfile('avatar'))
        {
            $destination = 'dokter/avatar/'.$dokter->avatar;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('avatar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('dokter/avatar/', $filename);
            $dokter->avatar = $filename;
        }
        if($request->hasfile('header'))
        {
            $destination = 'dokter/header/'.$dokter->header;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('header');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('dokter/header/', $filename);
            $dokter->header = $filename;
        }


        $dokter->save();
        return redirect()->route('dokter.profil');

    }
    public function pemeriksaan_ukgs(){
        //$kelurahan = Kelurahan::all();
        $user = Auth::user();
        $dokter = Dokter::Where('id_users', Auth::user()->id)->value('id_kecamatan');
        $kelurahan = Kelurahan::where('id_kecamatan', $dokter)->pluck('nama','id');
        $sekolah = Sekolah::pluck('nama','id');
        //$sekolah   = Sekolah::all();
        return view('dokter.pemeriksaanData.ukgs',[
            'kelurahan' => $kelurahan, 'sekolah '=> $sekolah,
        ]);
    }
    public function dropdown_sekolah_ukgs(Request $request){
        //$sekolah   = Sekolah::all();
        //$kel_sek  = Sekolah::where('id', $id)->get();
        $kel_sek  = Sekolah::where('id_kelurahan', $request->get('id'))
            ->pluck('nama', 'id');

        return response()->json($kel_sek);
    }
    public function dropdown_kelas_ukgs(Request $request){
        //$sekolah   = Sekolah::all();
        //$kel_sek  = Sekolah::where('id', $id)->get();
        $sek_kelas  = Kelas::where('id_sekolah', $request->get('id'))
            ->pluck('kelas', 'id');
        return response()->json($sek_kelas);
    }

    public function pemeriksaan_ukgm(){

        $kelurahan = Kelurahan::all();
        $sekolah   = Sekolah::all();
        return view('dokter.pemeriksaanData.ukgm');
    }
    
    public function pemeriksaan_ukgs_fetch(Request $request){
        
        // $logdokter = Auth::user()->dokter;
        // $dokter = $logdokter->find($id);
        // $sekolah = Sekolah::where('');
        $kelurahan = Kelurahan::all();
        $id_kelurahan = $request -> id;
        $sekolah = Sekolah :: where('id', $id)->get();
        foreach ($sekolah as $sekolah){

            echo "<option value='$sekolah->id'>$sekolah->type, $sekolah->nama</option>";

        }
    }
    public function pemeriksaan_data_ukgs(){
        return view ('dokter.pemeriksaanData.pemeriksaanDataUKGS');
    }

    public function pemeriksaan_data_ukgm(){
        return view ('dokter.pemeriksaanData.pemeriksaanDataUKGM');
    }
    public function rekap_ukgs(){
        $kelurahan = Kelurahan::all();
        return view('dokter.rekapData.ukgs', compact('kelurahan'));
    }

    public function rekap_ukgm(){
        return view('dokter.rekapData.ukgm');
    }
    public function rekap_detail_ukgs(){
        return view ('dokter.rekapData.rekapDataUKGS');
    }

    public function rekap_detail_ukgm(){
        return view ('dokter.rekapData.rekapDataUKGM');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $dokter = Dokter::find($id);
        $dokter ->delete();
        return response()->json(['data'=>'success delete data']);
    }

    public function listKelurahan(){
        $user = Auth::user();
        $dokter = Dokter::Where('id_users', Auth::user()->id)->value('id_kecamatan');
        $kelurahan = Kelurahan::where('id_kecamatan', $dokter)->get();
        return view('dokter.pemeriksaanData.ukgs');
        
    }

    public function listAnak(Request $request){
        $pemeriksaanfisik = PemeriksaanFisik::with('anak')->whereHas('anak',function($query) use($request) {$query->where('id_kelas',$request->id_kelas)->orderBy('id', 'DESC');})->latest();
        
        return datatables()->of($pemeriksaanfisik)
        ->addColumn('action', function($row){
            $btn = '';
            $btn .= '<a type="button" class="btn btn-primary btn-xs text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Rekap Data"><i class="mdi mdi-book-open-page-variant"></i></a> ';
            $btn .= '<a type="button" class="btn btn-info btn-xs text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Periksa" href="'.route('dokter.pemeriksaanDataUKGS').'">Periksa  <i class="mdi mdi-tooth"></i></a>';
            
            
            return $btn;
        })
        
        ->addColumn('tanggal', function($pemeriksaanfisik){
            return $tanggal = date('d-m-Y', strtotime($pemeriksaanfisik->waktu_pemeriksaan));
        })
        ->addColumn('waktu', function($pemeriksaanfisik){
            return $waktu = date('H:i', strtotime($pemeriksaanfisik->waktu_pemeriksaan));
        })
        ->addColumn('nama', function($pemeriksaanfisik){
            return $pemeriksaanfisik->anak->nama;
        })
        ->addColumn('kelas', function($pemeriksaanfisik){
            return $pemeriksaanfisik->anak->kelas->kelas;
        })
        ->addColumn('sekolah', function($pemeriksaanfisik){
            return $pemeriksaanfisik->anak->kelas->sekolah->nama;
        })
        ->addColumn('jenis_kelamin', function($pemeriksaanfisik){
            return $pemeriksaanfisik->anak->jenis_kelamin;
        })
        ->addIndexColumn()
       ->make(true);
        
    }

}
