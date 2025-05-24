<?php

namespace Modules\Template\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Template\Repositories\Api\TemplateRepository;
use Modules\Template\Transformers\Api\TemplateResource;


class TemplateController extends ApiController
{
    public function __construct(TemplateRepository $template)
    {
        $this->template = $template;
    }
    public function index(Request $request) {
        $packages = $this->template->getAllActive($request);
        return $this->responsePaginationWithData(TemplateResource::collection($packages));
    }

    public function show(Request $request,$id) {
        $package   = $this->template->findById($id);
        if(!$package){
            return $this->error(__('package::dashboard.invalid_package'));
        }

        return $this->response(new TemplateResource($package));
    }
}
