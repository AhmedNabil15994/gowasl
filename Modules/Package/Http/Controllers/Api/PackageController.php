<?php

namespace Modules\Package\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Package\Repositories\Api\PackageRepository;
use Modules\Package\Transformers\Api\PackageResource;


class PackageController extends ApiController
{
    public function __construct(PackageRepository $package)
    {
        $this->package = $package;
    }
    public function index(Request $request) {
        $packages = $this->package->getAllActive($request);
        return $this->responsePaginationWithData(PackageResource::collection($packages));
    }

    public function show(Request $request,$id) {
        $package   = $this->package->findById($id);
        if(!$package){
            return $this->error(__('package::dashboard.invalid_package'));
        }

        return $this->response(new PackageResource($package));
    }
}
