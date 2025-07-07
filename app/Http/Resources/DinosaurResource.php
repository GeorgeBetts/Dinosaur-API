<?php

namespace App\Http\Resources;

use App\Models\Dinosaur;
use Gbetts\AncientDates\AncientDate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Dinosaur
 */
class DinosaurResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...$this->resource->toArray(),
            'images' => $this->whenLoaded('images'),
            'articles' => $this->whenLoaded('articles'),
            $this->mergeWhen($this->period_start !== null, function () {
                if ($this->period_start === null) {
                    return [];
                }

                try {
                    $startPeriod = new AncientDate($this->period_start);
                } catch (\Exception $e) {
                    return [];
                }

                return [
                    'period_start_human_readable' => $startPeriod->toBceString(),
                    'period_start_years_ago' => $startPeriod->yearsAgo(),
                    'period_start_period' => $startPeriod->period(),
                ];

            }),
            $this->mergeWhen($this->period_end !== null, function () {
                try {
                    if ($this->period_end === null) {
                        return [];
                    }

                    $endPeriod = new AncientDate($this->period_end);

                    return [
                        'period_end_human_readable' => $endPeriod->toBceString(),
                        'period_end_years_ago' => $endPeriod->yearsAgo(),
                        'period_end_period' => $endPeriod->period(),
                    ];
                } catch (\Exception $e) {
                    return [];
                }
            }),
        ];
    }
}
