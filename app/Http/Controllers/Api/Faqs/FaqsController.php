<?php

namespace App\Http\Controllers\Api\Faqs;

use App\Models\Admin\Faqs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqsController extends Controller
{
    //
    public function getFaqs()
    {
        $faqs = Faqs::all(['id', 'question', 'answer']);

        if (count($faqs)) {
            return $this->prepareResult(200, ['faqs' => $faqs], 'Records found', null);
        } else {

            return $this->prepareResult(204, null, 'no Records found', null);

        }

    }
}
