<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaluationRequest;
use App\Http\Resources\EvaluationResource;
use App\Models\Evaluation;
use App\Services\CompanyService;

class EvaluationController extends Controller
{
    private $repository;
    private $companyService;

    public function __construct(Evaluation $model, CompanyService $companyService)
    {
        $this->repository = $model;
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string $uuid
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(string $uuid)
    {
        $evaluations = $this->repository->where('company_uuid', $uuid)->get();

        return EvaluationResource::collection($evaluations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EvaluationRequest  $request
     * @param  string  $uuid
     * @return \App\Http\Resources\EvaluationResource|\Illuminate\Http\Response
     */
    public function store(EvaluationRequest $request, string $uuid)
    {
        $response = $this->companyService->getByUuid($uuid);

        if (!$response->ok())
            return response(null, $response->status());

        $evaluation = $this->repository->create($request->validated());

        return new EvaluationResource($evaluation);
    }
}
