<?php

namespace App\Services;

use App\Services\Traits\ConsumeExternalService;

class CompanyService
{
    use ConsumeExternalService;

    /**
     * @return mixed
     */
    public function getByUuid(string $uuid)
    {
        return $this->request('get', "/companies/{$uuid}");
    }
}
