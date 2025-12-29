<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OmsetTurunDetected
{
    use Dispatchable, SerializesModels;

    public float $omsetHariIni;
    public float $avgOmset7Hari;
    public float $persentaseTurun;

    /**
     * Create a new event instance.
     */
    public function __construct(float $omsetHariIni, float $avgOmset7Hari, float $persentaseTurun)
    {
        $this->omsetHariIni = $omsetHariIni;
        $this->avgOmset7Hari = $avgOmset7Hari;
        $this->persentaseTurun = $persentaseTurun;
    }
}

