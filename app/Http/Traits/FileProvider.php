<?php

namespace App\Http\Traits;

use App\File;
use App\User;
use Illuminate\Http\Request;

trait FileProvider {
    public function download(int $id){
        $file = File::find($id)->firstOrFail();

        return response()->download($this->getFilesStorage().DIRECTORY_SEPARATOR.$file->files_path, $file->title.'.'.$file->extension);
    }

    public function search(Request $request){
        $files = File::where('title', 'like', '%' . $request->search . '%')->where('user_id', $request->userId)->orderBy('created_at', 'desc')->paginate(5);
        return view('files.show', [
            'files' => $files,
            'userId' => $request->userId
        ]);
    }


}
