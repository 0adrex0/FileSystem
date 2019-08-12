<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\StorageProvider;
use App\File;
use App\User;

class FilesController extends Controller
{
    use StorageProvider;

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
        $files = File::select('user_id')->distinct()->orderBy('created_at', 'desc')->paginate(5);
        
        return view('files.index',compact('files'));
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
            
            foreach($files as $value){
                $file = $this->getFileData($value, $this->getRelativeFilesStorage());

                try {
                    Storage::putFileAs($file->directory, $value, $file->processedName);
                } catch (Exception $exception) {
                    return redirect('/files')->with('error', 'Failed while writting file');
                }

                $newFile = new File;
                $newFile->title = $file->name;
                $newFile->files_path = $file->processedName;
                $newFile->user_id = auth()->user()->id;
                $newFile->extension = $file->extension;
                $newFile->save();
            }
        }
        
        return redirect('/files')->with('success', 'Directory Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $files = File::where('user_id', $id)->orderBy('created_at','desc')->paginate(5);

        foreach ($files as $file) {
            $file->size = Storage::size($this->getRelativeFilesStorage().DIRECTORY_SEPARATOR.$file->files_path);
        }

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
    public function update(Request $request, File $file)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        if($request->hasFile('files_path')){
            $fileData = $this->getFileData($request->file('files_path'), $this->getFilesStorage());

            $file->title = $fileData->name;
            Storage::delete($file->files_path);
            $file->storeAs($fileData->directory);
            $file->files_path = $fileData->directory;
            $file->user_id = auth()->user()->id;
            $file->extension = $fileData->extension;
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

    public function download(int $id){
        $file = File::find($id)->firstOrFail();
        return response()->download($this->getFilesStorage().DIRECTORY_SEPARATOR.$file->files_path, $file->title);
    }
    public function search(Request $request){
        $files = File::where('title', 'like', '%' . $request->search . '%')->orderBy('created_at', 'desc')->paginate(5);
        return view('files.show',compact('files'));
    }
}
