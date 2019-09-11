<?php

namespace App\Http\Controllers;

use App\File;
use App\User;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use App\Http\Traits\FileProvider;
use App\Http\Traits\StorageProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class FilesController extends Controller
{
    use StorageProvider;
    use FileProvider;
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
       // $files = File::select('user_id')->distinct()->get();
        // ->orderBy('created_at', 'desc')->paginate(5);
        if(!Auth::guest()) $files = User::where('is_public_dir', true)->orWhere('id', Auth::user()->id)->paginate(5);
        else $files = User::where('is_public_dir', true)->paginate(5);

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
    public function show(Request $request, int $id)
    {
        if(Auth::guest()){
            return redirect('/login')->with('error', 'Enter to accaunt');
        }

        $selectedFile = $id;
        if (!$selectedFile) {
            $selectedFile = $request->id;
        }

        $user = User::find($selectedFile);

        if($user && ((Auth::user()->id == $selectedFile) || ($user->password_dir == $request->password))) {
            $files = File::where('user_id', $selectedFile)->orderBy('created_at','desc')->paginate(5);

            foreach ($files as $file) {
                $file->size = Storage::size($this->getRelativeFilesStorage($selectedFile).DIRECTORY_SEPARATOR.$file->files_path);
            }

            $data = array(
                'files' => $files,
                'userId' => $selectedFile
            );
            return view('files.show')->with($data);
            }

        return redirect('/files')->with('error', 'Failed password');
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
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            // 'title' => 'required',
        ]);
        $file = File::find($id);

        if($request->hasFile('files_path')){
            $fileData = $this->getFileData($request->file('files_path'), $this->getRelativeFilesStorage());

            try{
                Storage::delete($fileData->directory.DIRECTORY_SEPARATOR.$file->files_path);
                Storage::putFileAs($fileData->directory, $request->files_path, $fileData->processedName);
            }catch(Exception $ex){
                return redirect('/files')->with('error', 'Dont worry be happy');
            }


            $file->title = $fileData->name;
            $file->files_path = $fileData->processedName;
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

        $fileData = $this->getRelativeFilesStorage($file->user_id);

        try{
            Storage::delete($fileData.DIRECTORY_SEPARATOR.$file->files_path);
        }catch(Exception $ex){
            return redirect('/files')->with('error', 'Dont worry be happy');
        }

        $file->delete();
        return redirect('/files')->with('success', 'Directory Removed');
    }



}
