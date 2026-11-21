<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'project_id' => $this->project_id,
            'author_id' => $this->author_id,
            'assigned_to' => $this->assigned_to,
            'due_date' => $this->due_date,

            'project' => new ProjectResource(
                $this->whenLoaded('project')
            ),

            'comments' => CommentResource::collection(
                $this->whenLoaded('comments')
            ),

            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
