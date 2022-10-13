<?php

namespace App\Http\Controllers;

use App\Http\Requests\DigitalOceanDeleteRequest;
use App\Http\Requests\DigitalOceanStoreRequest;
use App\Http\Requests\DigitalOceanUpdateRequest;
use App\Models\Submission;
use App\Services\CdnService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DOSpacesController extends Controller
{
    private $cdnService;

    public function __construct(CdnService $cdnService)
    {
        $this->cdnService = $cdnService;
    }

    public function store(DigitalOceanStoreRequest $request, Submission $submission)
    {
        $file = $request->file('doctorPrescription');
        $name = (string) Str::uuid();
        $fileName = $name . '.txt';
        $submission->prescription = $fileName;
        $submission->save();
        $folder = config('filesystems.disks.do.folder');

        Storage::putFileAs($folder, $file, $fileName, 'public');

        return response()->json(
            ['message' => 'File uploaded',
             'url' => Storage::url($fileName)], 200);
    }

    public function show(Submission $submission)
    {
        $fileName = $submission->prescription;
        $folder = config('filesystems.disks.do.folder');
        $path = $folder .'/'. $fileName;
        $file = Storage::get($path);
        if(!$file){
            return responder()->error()->respond();
        }
        $headers = [
            'Content-type' => 'application/txt'
        ];
        return response($file, 200, $headers);
    }

    public function delete(Submission $submission)
    {
        $fileName = $submission->prescription;
        $folder = config('filesystems.disks.do.folder');

        $path = $folder .'/'. $fileName;

        Storage::delete($path);

        return response()->json(['message' => 'File deleted'], 200);
    }
}
