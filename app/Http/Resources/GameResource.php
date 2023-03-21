<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //Parsing reultWin to String
        if ($this->resultWin) {
            $resultString = "Won";
        } else $resultString = "Lost";

        return [
            'Game Number' => $this->id,
            'Dice 1' => $this->dice1Value,
            'Dice 2' => $this->dice2Value,
            'Result' => $resultString,
        ];
    }
}
