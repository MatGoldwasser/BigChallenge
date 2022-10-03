<?php

namespace App\Transformers;

use App\Submission;
use Flugg\Responder\Transformers\Transformer;

class SubmissionTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Submission $submission
     * @return array<mixed>
     */
    public function transform(Submission $submission): array
    {
        return [
            'id' => (int) $submission->id,
            'title' => $submission->title,
            'symptoms' => $submission->symptoms,
            'other_info' => $submission->other_info,
            'phone' => $submission->phone,
            'status' => $submission->status
        ];
    }
}
