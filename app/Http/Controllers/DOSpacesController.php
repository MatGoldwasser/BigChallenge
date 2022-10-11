<?php

namespace App\Http\Controllers;

use App\Http\Requests\DigitalOceanDeleteRequest;
use App\Http\Requests\DigitalOceanStoreRequest;
use App\Http\Requests\DigitalOceanUpdateRequest;
use App\Services\CdnService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DOSpacesController extends Controller
{
    private $cdnService;

    public function __construct(CdnService $cdnService)
    {
        $this->cdnService = $cdnService;
    }

    public function store(DigitalOceanStoreRequest $request)
    {
        $file = $request->asFile('doctorPrescription');
        $fileName = (string) Str::uuid();
        $folder = config('filesystems.disks.do.folder');

        Storage::put(
            "{$folder}/{$fileName}",
            file_get_contents($file)
        );

        return response()->json(['message' => 'File uploaded'], 200);
    }

    public function delete(DigitalOceanDeleteRequest $request)
    {
        $fileName = $request->validated()['doctorPrescriptionName'];
        $folder = config('filesystems.disks.do.folder');

        Storage::delete("{$folder}/{$fileName}");
        $this->cdnService->purge($fileName);

        return response()->json(['message' => 'File deleted'], 200);
    }

    public function update(DigitalOceanUpdateRequest $request)
    {
        $file = $request->asFile('doctorPrescription');
        $fileName = $request->validated()['doctorPrescriptionName'];
        $folder = config('filesystems.disks.do.folder');

        Storage::put(
            "{$folder}/{$fileName}",
            file_get_contents($file)
        );
        $this->cdnService->purge($fileName);

        return response()->json(['message' => 'File updated'], 200);
    }
}
