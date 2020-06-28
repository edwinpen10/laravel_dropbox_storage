<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Dropfile;

class DropController extends Controller
{
    public function __construct()
    {
        $this->dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
    }

    public function index()
    {
        //dd('oke');
         $files=Dropfile::all();
        return view('pages.drop-index', compact('files'));
    }

    public function store(Request $request)
    {
        try {
            if($request->hasFile('file')){
                $files = $request->file('file');

                foreach ($files as $file) {
                    $fileExtension = $file->getClientOriginalExtension();
                    $mimeType = $file->getClientMimeType();
                    $fileSize = $file->getSize();
                    $newName = uniqid().'.'.$fileExtension;

                    Storage::disk('dropbox')->putFileAs('/', $file, $newName);
                    $this->dropbox->createSharedLinkWithSettings('/'. $newName);

                    DropFile::create([
                        'file_title' => $newName,
                        'file_type' => $mimeType,
                        'file_size' => $fileSize
                    ]);

                    return redirect('dropbox');
                }
            }
        } catch (\Exception $e) {
            return "Message: {$e->getMessage()}";
        }
    }

    public function show($fileTitle)
    {
        try {
            $link = $this->dropbox->listSharedLinks('/'.$fileTitle);
            $raw = explode("?", $link[0]['url']);
            $path =$raw[0]. "?raw=1";
            $temp_path= tempnam(sys_get_temp_dir(), $path);
            $copy = copy($path, $temp_path);
            return response()->file($temp_path);
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function download($fileTitle)
    {
        try {
            return Storage::disk('dropbox')->download('/'.$fileTitle);
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function destroy($id)
    {

        try {
            $file = Dropfile::find($id);
            //echo $file;
           //echo $file->file_title;
           Storage::disk('dropbox')->delete('/'.$file->file_title);
            $file->delete();

            return redirect('dropbox');

        } catch (\Exception $e) {
            return abort(404);
        }
    }

}
