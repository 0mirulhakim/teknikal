<?php

namespace App\Http\Controllers;
use App\Permohonan;
use App\Status_permohonan;
use Illuminate\Http\Request;
use DB;
class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('transaksi')
        
        ->select('*')
        ->get();
         return view('delete', compact('data'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permohonan=new Permohonan;
        $permohonan->no_fail=$request->input('no_fail');
        $permohonan->tarikh=$request->input('tarikh');
        $permohonan->no_rujukan=$request->input('no_rujukan');
        $permohonan->nama=$request->input('nama');
        $permohonan->no_pa=$request->input('no_pa');
        $permohonan->no_lot=$request->input('no_lot'); 
        $permohonan->mukim_id=$request->input('mukim_id');
        $permohonan->catatan=$request->input('catatan');
        $permohonan->status_id=$request->input('status_id');
       
        $permohonan->save();

        $post=new Status_permohonan;
        $post->permohonan_baru_id=$permohonan->id;
        $post->tarikh=$request->input('tarikh');
        $post->no_fail=$request->input('no_fail');
        $post->catatan=$request->input('catatan');
        $post->status=$request->input('status_id');
        
        $post->save(); 
        return redirect('/home')->with('success',"Permohonan telah berjaya");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
      // $permohonan=DB::table('status_permohonan')->find($id)     
      // ->join('status', 'status.id', '=', 'status_permohonan.status')
      // ->join('permohonan_baru', 'permohonan_baru.id', '=', 'status_permohonan.permohonan_baru_id')
      // ->where('status_permohonan.permohonan_baru_id', '=', $id )
      // ->select('status_permohonan.*','status.status_nama','permohonan_baru.no_fail')
      // ->get();
         $permohonan= Status_permohonan::select('id','nama_staff','catatan','status','tarikh')
         ->join('status', 'status.id', '=', 'status_permohonan.status')
         ->join('permohonan_baru', 'permohonan_baru.id', '=', 'status_permohonan.permohonan_baru_id')
         ->select('status_permohonan.*','status.status_nama','permohonan_baru.no_fail')
         ->where('status_permohonan.permohonan_baru_id', '=', $id )
         ->get();
         return view('baru.show',compact('permohonan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permohonan= Permohonan::find($id);
        $status_name = DB::table('status')
        ->select('id','status_nama')  
        ->get();
   
        return view ('baru.edit')->with('permohonan',$permohonan,$status_name);
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
