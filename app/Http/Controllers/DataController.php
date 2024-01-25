<?php

namespace App\Http\Controllers;

use App\Batch\BatchProcessor;

class DataController extends Controller
{
    public function processLargeData()
    {
        $data = asset('backend/brands.json');
        $batchSize = 1000; // Set your desired batch size

        $batchProcessor = new BatchProcessor();
        $batchProcessor->processInBatches($data, $batchSize);

        return "Batch processing started.";
    }
}
