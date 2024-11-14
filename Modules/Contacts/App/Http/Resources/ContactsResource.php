<?php

namespace Modules\Contacts\App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactsResource extends JsonResource
{

    protected $isMinimal;

    public function __construct($resource, $isMinimal = false)
    {
        $this->isMinimal = $isMinimal;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            $this->mergeWhen(!$this->isMinimal,[
                'type' => $this->type
            ]),
        ];
    }
}
