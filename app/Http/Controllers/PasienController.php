<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Helpers\apiFormatter;
use Exception;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search_nama;
        $limit = $request->limit;
        $pasiens = Pasien::where('nama', 'LIKE', '%'.$search.'%')->limit($limit)->get();

        if ($pasiens){
            return apiFormatter::createApi(200, 'success', $pasiens);
        }else {
            return apiFormatter::createApi(400, 'failed');
        }
    }
    

    public function show($id)
    {
        try {
            $pasienDetail = Pasien::where('id', $id)->first();
            
            if($pasienDetail){
                return apiFormatter::createApi(200,'success',$pasienDetail);
            }else{
                return apiFormatter::createApi(400,'failed');
            }
        } catch(Exception $error){
            return apiFormatter::createApi(400,'failed',$error);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama'=> 'required|min:8',
                'alamat'=>'required',
                'nomor'=>'required|max:13',
                'JK'=>'required',
            ]);

            $pasien = Pasien::create([
                'nama'=> $request->nama,
                'alamat'=>$request->alamat,
                'nomor'=>$request->nomor,
                'JK'=>$request->JK,
            ]);

            $getDataSaved = Pasien::where('id', $pasien->id)->first();
            
            if ($getDataSaved){
                return apiFormatter::createApi(200,'success', $getDataSaved);
            }else {
                return apiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error){
            return apiFormatter::createApi(400,'failed', $error);
        }
    }

    public function createToken(){
        return csrf_token();
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama'=> 'required|min:8',
                'alamat'=>'required',
                'nomor'=>'required|max:13',
                'JK'=>'required',
            ]);

            $pasien = Pasien::findOrFail($id);

            $pasien->update([
                'nama'=> $request->nama,
                'alamat'=>$request->alamat,
                'nomor'=>$request->nomor,
                'JK'=>$request->JK,
            ]);

            $updatedPasien = Pasien::where('id', $pasien->id)->first();

            if($updatedPasien){
                return apiFormatter::createApi(200,'success', $updatedPasien);
            }else{
                return apiFormatter::createApi(400,'failed');
            }
        }catch(Exception $error){
            return apiFormatter::createApi(400,'failed', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $pasien = Pasien::findOrFail($id);
            $proses = $pasien->delete();

            if ($proses){
                return apiFormatter::createApi(200, 'succes delete data');
            }else {
                return apiFormatter::createApi(400, 'failed');
            }
        } catch(Exception $error){
            return apiFormatter::createApi(400, 'failed', $error);
        }
    }

    public function trash(){
        try{
            $pasiens = Pasien::onlyTrashed()->get();
            if ($pasiens){
                return apiFormatter::createApi(200,'success', $pasiens);
            } else{
                return apiFormatter::createApi(400,'failed');
            }
        }catch(Exception $error){
            return apiFormatter::createApi(400,'failed',$error->getMessage());
        }
    }

    public function restore($id){
        try{
            $pasien = Pasien::onlyTrashed()->where('id', $id);
            $pasien->restore();
            $dataRestore = Pasien::where('id', $id)->first();
            if($dataRestore){
                return apiFormatter::createApi(200,'succes',$dataRestore);
            }else {
                return apiFormatter::createApi(400, 'failed');
            }
        }catch(Exception $error){
            return apiFormatter::createApi(400, 'failed', $error->getmessage());
        }
    }

    public function permanentDelete($id){
        try{
            $pasien = Pasien::onlyTrashed()->where('id', $id);
            $proses = $pasien->forceDelete();
            if($proses){
                return apiFormatter::createApi(200,'succes', 'data dihapus permanen');
            }else {
                return apiFormatter::createApi(400, 'failed');
            }
        } catch(Exception $error){
            return apiFormatter::createApi(400,'failed', $error->getMessage());
        }
    }
}
