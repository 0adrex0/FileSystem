<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\File;
use App\User;

class FilesController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function index()
    {
  
        $data = [
            //'files' => $files->orderBy('created_at','desc')->paginate(5),
            'files' => File::select('user_id')->distinct()->orderBy('created_at','desc')->paginate(5),    
        ];
        
        return view('files.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'title' => 'required',
           
        ]);
        
        if($request->hasFile('files_path')){
            $files = $request->file('files_path');
            // Puth directory
            $file_path = 'public/files_paths';
            foreach($files as $key => $f){
                $filenameWithExt = $f->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $f->getClientOriginalExtension();
                //Filename to store
                $file_time = time();
                $fileNameToStore = $filename.'_'.$file_time.'.'.$extension;
                $file = new File;
                $file->title = $filename;
                $file->files_path = $f->storeAs($file_path, $fileNameToStore);
                $file->user_id = auth()->user()->id;
                $file->save();
                
            }
        }else{
            $path_arr = '';
        }
        
        return redirect('/files')->with('success', 'Directory Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     
       $files = File::where('user_id', $id)->get();
        
        $data = array(
            'files' => $files,
        );
        
        return view('files.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $file = File::find($id);
        $data = array(
            'file' => $file
        );

        if(auth()->user()->id !== $file->user_id){
            return redirect('/files')->with('error', 'Unauthorized Page');
        }
        return view('files.edit')->with($data);

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
        
        $this->validate($request, [
            'title' => 'required',
        ]);
        $file = File::find($id);
        if($request->hasFile('files_path')){
            $files = $request->file('files_path');
            // Puth directory
            $file_path = 'public/files_paths';
            
            $filenameWithExt = $files->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            $extension = $files->getClientOriginalExtension();
            //Filename to store
            $file_time = time();
            $fileNameToStore = $filename.'_'.$file_time.'.'.$extension;

            
            $file->title = $filename;
            Storage::delete($file->files_path);
            $file->files_path = $files->storeAs($file_path, $fileNameToStore);
            $file->user_id = auth()->user()->id;
            
        }else{
            if($request->input('title') != $file->title){
                $file->title = $request->input('title');
            }
        }
        $file->save();
        return redirect('/files')->with('success', 'Directory Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::find($id);
        if(auth()->user()->id !== $file->user_id){
            return redirect('/files')->with('error', 'Unauthorized Page');
        }
        
       
        Storage::delete($file->files_path);
        
        
        $file->delete();
        return redirect('/files')->with('success', 'Directory Removed');        
    }
}
