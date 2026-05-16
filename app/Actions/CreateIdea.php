<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateIdea
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        // throw new \Exception('Not implemented');
    }

    public function handle(array $attributes): void
    {

        // dd($attributes);

        // dd($request->safe()->except('steps'));
        // Auth::user()->ideas()->create($request->validated());

        $data = collect($attributes)->only([
            'title', 'description', 'status', 'links',
        ])->toArray();

        if ($attributes['image'] ?? false) {
            $data['image_path'] = $attributes['image']->store('ideas', 'public');
        }

        DB::transaction(function () use ($data, $attributes) {

            $idea = $this->user->ideas()->create($data);

            // $steps = collect($attributes['steps'] ?? [])->map(fn ($step) => ['description' => $step]);

            // $idea->steps()->createMany($steps);
            $idea->steps()->createMany($attributes['steps'] ?? []);

        });

    }
}
