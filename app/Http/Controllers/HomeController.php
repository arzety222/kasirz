<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Role;
use App\Models\Admin;
use Validator;

class HomeController extends Controller
{
    public function index(){
        if(session('admin_id') == null){
            return redirect('');
        }

        return view('home');
    }

    public function index_penjualan(){
        
        $data = DB::select("
            SELECT 
                pe.*,
                pr.nama_produk,
                pr.stok
            FROM penjualan pe
            JOIN produk pr ON pr.produk_id = pe.produk_id
            ORDER BY pe.penjualan_id desc
        ");

        return view('penjualan', compact('data'));
    }

    public function form_add(){
        if(session('admin_id') == null){
            return redirect('');
        }
        
        $produk = Produk::all();

        return view('form_add', compact('produk'));
    }

    public function simpan(Request $request){
        $validator = Validator::make($request->all(),[
            'iproduk_id'     => 'required',
            'iquantity'     => 'required|numeric|min:1',
        ],[
            'iproduk_id.required' => "Nama Produk wajib diisi",
            'iquantity.required'  => "Quantity wajib diisi",
            'iquantity.min'  => "Quantity minimal 1"
        ]);

        if($validator->fails()){
            return redirect()->route('form_add')->with('error',  implode(" | ",$validator->errors()->all()));
        }

        $produk = Produk::find($request->iproduk_id);

        if($request->iquantity > $produk->stok){
            return redirect()->back()->with('error', 'Quantity melebihi stok yang ada');
        }

        ///////////// ELOQUENT INSERT
        $create = new Penjualan();
        $create->keterangan         = $request->iketerangan;
        $create->produk_id          = $request->iproduk_id;
        $create->quantity_terjual   = $request->iquantity;
        $create->harga_terjual      = $produk->harga;
        $create->save();
        ///////////////

        // UPDATE STOK di TABEL PRODUK
        $stok_baru = $produk->stok - $request->iquantity;

        $produk->stok = $stok_baru;
        $produk->update();

        return redirect()->route('daftar_penjualan')->with('success', 'Penjualan berhasil disimpan!');
    }

    public function form_edit($id){
        if(session('admin_id') == null){
            return redirect('');
        }
        // $parse = [];
        // $sql = "
        //     SELECT 
        //         *
        //     FROM penjualan
        //     WHERE produk_id = ?
        // ";

        // array_push($parse, $id);

        // $detail = collect(DB::select($sql, $parse))->first();

        $detail = Penjualan::find($id);
        // $detail = Penjualan::where('penjualan_id', $id)->first();

        // $produk = DB::select("
        //     SELECT 
        //         *
        //     FROM produk
        // ");

        $produk = Produk::all();

        return view('form_edit', compact('detail', 'produk'));
    }

    public function rubah(Request $request){
        $validator = Validator::make($request->all(),[
            'iproduk_id'     => 'required',
            'ipenjualan_id'    => 'required',
            'iquantity'     => 'required|numeric|min:1',
        ],[
            'iproduk_id.required' => "Nama Produk wajib diisi",
            'ipenjualan_id.required' => "Penjualan wajib diisi",
            'iquantity.required'  => "Quantity wajib diisi",
            'iquantity.min'  => "Quantity minimal 1"
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error', implode(" | ",$validator->errors()->all()));
        }
        
        $produk = Produk::find($request->iproduk_id);

        $penjualan = Penjualan::find($request->ipenjualan_id);

        if($request->iquantity > $produk->stok){
            return redirect()->back()->with('error', 'Quantity melebihi stok yang ada');
        }

        $penjualan->quantity_terjual = $request->iquantity;
        $penjualan->keterangan       = $request->iketerangan;
        $penjualan->update();


        // UPDATE STOK di TABEL PRODUK
        // stok sisa = stok sisa existing - (qty penjualan baru - penjualan lama )
        $stok_baru = $produk->stok - ($request->iquantity - $penjualan->quantity_terjual);

        $produk->stok = $stok_baru;
        $produk->update();

        return redirect()->route('daftar_penjualan')->with('success', 'Penjualan berhasil dirubah!');
    }

    public function hapus($id){
        $penjualan = Penjualan::find($id);

        $produk = Produk::where('produk_id', $penjualan->produk_id)->first();

        // kembalikan stok 
        // jika penjualan dihapus, maka stok harus kembali ke semula
        // stok baru = stok sisa + qty penjualan 
        $stok_baru = $produk->stok + $penjualan->quantity_terjual;

        $produk->stok = $stok_baru;
        $produk->update();

        $penjualan->delete();

        return redirect()->route('daftar_penjualan')->with('success', 'Penjualan berhasil dihapus!');

    }

    public function form_register(){
        if(session('admin_id') == null){
            return redirect('');
        }

        if(session('role_id') != 1 ){
            return redirect('');
        }
        
        $role = Role::all();

        return view('form_register', compact('role'));
    }
    public function simpan_register(Request $request){
        $validator = Validator::make($request->all(),[
            'irole_id'     => 'required',
            'iusername'  => 'required',
            'ipassword'     => 'required',
        ],[
            'irole_id.required' => "Role wajib diisi",
            'iusername.required' => "Username wajib diisi",
            'ipassword.required'  => "Password wajib diisi"
        ]);

        if($validator->fails()){
            return redirect()->route('index')->with('error',  implode(" | ",$validator->errors()->all()));
        }

        $cek = Admin::whereRaw('lower(username) = ?', strtolower(ltrim(rtrim($request->iusername))))
        ->first();

        if($cek){
            return redirect()->route('form_register')->with('error',  'Username sudah ada');
        }

        $create = new Admin();
        $create->role_id         = $request->irole_id;
        $create->username          = ltrim(rtrim($request->iusername));
        $create->password   = $request->ipassword;
        $create->save();

        return redirect()->route('index')->with('success',  'Register berhasil disimpan!');
    }

    public function form_login(){
        return view('form_login');
    }

    public function cek_login(Request $request){
        $validator = Validator::make($request->all(),[
            'iusername'     => 'required',
            'ipassword'    => 'required',
        ],[
            'iusername.required' => "Username wajib diisi",
            'ipassword.required' => "Password wajib diisi"
        ]);
        
        if($validator->fails()){
            return redirect()->route('login')->with('error',  implode(" | ",$validator->errors()->all()));
        }
        
        $username = ltrim(rtrim($request->iusername));

        $admin = Admin::whereRaw('lower(username) = ?', strtolower($username))
        ->where('password', $request->ipassword)
        ->first();
        
        if(!$admin){
            return redirect()->route('login')->with('error', 'Akun tidak ditemukan!');
        }

        session(['admin_id' => $admin->admin_id]);
        session(['role_id' => $admin->role_id]);
        session(['username' => $admin->username]);

        $generateToken = bin2hex(random_bytes(40));

        $admin->token       = $generateToken;
        $admin->update();
        \Log::Info("homeee");
        return redirect('home');
    }

    public function proses_logout() {
        $admin = Admin::find(session('admin_id'));

        if($admin){
            $admin->token = "";
            $admin->update();
        }

        session()->flush();

        return redirect('');
    }
    public function index_produk(){
        
        $data = Produk::orderBy('produk_id','DESC')->get();

        return view('produk', compact('data'));
    }
    public function form_add_produk(){
        if(session('admin_id') == null){
            return redirect('');
        }
        return view('form_add_produk');
    }
    public function simpan_produk(Request $request){
        $validator = Validator::make($request->all(),[
            'inamaproduk'     => 'required',
            'iharga'    => 'required|numeric|min:1',
            'istok'     => 'required',
        ],[
            'inamaproduk.required' => "Nama Produk wajib diisi",
            'iharga.required' => "Harga wajib diisi",
            'iharga.min' => "Harga minimal 1",
            'istok.required'  => "Stok wajib diisi"
        ]);

        if($validator->fails()){
            return redirect()->route('form_add_produk')->with('error',  implode(" | ",$validator->errors()->all()));
        }

        $cek = Produk::whereRaw('lower(nama_produk) = ?', strtolower(ltrim(rtrim($request->inamaproduk))))
        ->first();

        if($cek){
            return redirect()->route('form_add_produk')->with('error',  'Nama Produk sudah ada');
        }

        $create = new Produk();
        $create->nama_produk        = ltrim(rtrim($request->inamaproduk));
        $create->harga          = $request->iharga;
        $create->stok   = $request->istok;
        $create->save();
        return redirect()->route('index_produk')->with('success',  'Produk berhasil disimpan!');
    }
    public function form_edit_produk($id){
        if(session('admin_id') == null){
            return redirect('');
        }
        
        $detail = Produk::find($id);

        return view('form_edit_produk', compact('detail'));
    }
    public function rubah_produk(Request $request){
        $validator = Validator::make($request->all(),[
            'inamaproduk'     => 'required',
            'iharga'    => 'required|numeric|min:1',
            'istok'     => 'required',
        ],[
            'inamaproduk.required' => "Nama Produk wajib diisi",
            'iharga.required' => "Harga wajib diisi",
            'iharga.min' => "Harga minimal 1",
            'istok.required'  => "Stok wajib diisi"
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error', implode(" | ",$validator->errors()->all()));
        }

        $produk = Produk::find($request->iproduk_id);

        if(!$produk){
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $cek = Produk::whereRaw('lower(nama_produk) = ?', strtolower(ltrim(rtrim($request->inamaproduk))))
        ->where('produk_id', '!=', $request->iproduk_id)
        ->first();

        if($cek){
            return redirect()->back()->with('error', 'Nama Produk sudah ada');
        }

        $produk->nama_produk = $request->inamaproduk;
        $produk->harga      = $request->iharga;
        $produk->stok       = $request->istok;
        $produk->update();

        return redirect()->route('index_produk')->with('success', 'Produk berhasil dirubah!');
    }

    public function hapus_produk($id){
        $produk = Produk::find($id);
        
        if(!$produk){
            return redirect()->route('index_produk')->with('error', 'Produk tidak ditemukan');
        }
        
        $penjualan = Penjualan::where('produk_id', $produk->produk_id)->first();
        
        if($penjualan){
            return redirect()->route('index_produk')->with('error', 'Produk tidak bisa dihapus karena sudah terjual');
        }

        $produk->delete();

        return redirect()->route('index_produk')->with('success', 'Produk berhasil dihapus!');

    }


}
