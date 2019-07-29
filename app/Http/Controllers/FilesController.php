<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\File;

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
           'files' => File::orderBy('created_at','desc')->paginate(10)
           
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
            'title' => 'required',
           
        ]);

        if($request->hasFile('files_path') || true){
            $files = $request->file('files_path');
            foreach($files as $key => $file){
                $filenameWithExt = $file->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $file->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                //Upload File
                $path_arr[$key] = $file->storeAs('public/files_paths',$fileNameToStore);
            }
        }

        $file = new File;
        $file->title = $request->input('title');
        $file->user_id = auth()->user()->id;
        $file->files_path = json_encode($path_arr);
        $file->save();
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
        $data = array(
            'file' => File::find($id)
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
        
        if($request->hasFile('files_path') || true){
            $files = $request->file('files_path');
            foreach($files as $key => $file){
                $filenameWithExt = $file->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $file->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                //Upload File
                $path_arr[$key] = $file->storeAs('public/files_paths',$fileNameToStore);
            }
        }

        $file = File::find($id);
        if(auth()->user()->id !== $file->user_id){
            return redirect('/files')->with('error', 'Unauthorized Page');
        }
        $file->title = $request->input('title');
        //Concatenate old and new files_path
        $files_path = array_merge(json_decode($file->files_path), $path_arr);
        $file->files_path = json_encode($files_path);

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
        $files_path = json_decode($file->files_path);

        foreach($files_path as $file_item){
            Storage::delete($file_item);
        }
        $file->delete();
        return redirect('/files')->with('success', 'Directory Removed');        
    }
}
