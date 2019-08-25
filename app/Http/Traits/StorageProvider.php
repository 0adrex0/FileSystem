<?php

namespace App\Http\Traits;

use App\User;

trait StorageProvider {
    private function getFilesStorage(int $userId = null): string {
        $email = User::getUserEmailById($userId);
        return storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'files_paths'.DIRECTORY_SEPARATOR.$email);
    }

    private function getRelativeFilesStorage(int $userId = null): string {
        $email = User::getUserEmailById($userId);
        return 'public'.DIRECTORY_SEPARATOR.'files_paths'.DIRECTORY_SEPARATOR.$email;
    }

    private function getFileData($files, string $path) {
        $filenameWithExt = $files->getClientOriginalName();

        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        //Get just ext
        $extension = $files->getClientOriginalExtension();

        //Filename to store
        $file_time = time();
        $fileNameToStore = $filename.'@'.$file_time.'.'.$extension;

        return new class($path, $filenameWithExt, $filename, $extension, $fileNameToStore) {
            public $directory;
            public $fullName;
            public $name;
            public $extension;
            public $processedName;

            function __construct($path, $filenameWithExt, $filename, $extension, $fileNameToStore) {
                $this->directory = $path;
                $this->fullName = $filenameWithExt;
                $this->name = $filename;
                $this->extension = $extension;
                $this->processedName = $fileNameToStore;
            }
        };
    } 
}