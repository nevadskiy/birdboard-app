<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    protected $oldAttributes = [];

    public static function bootRecordsActivity()
    {
        foreach (static::recordableEvents() as $event) {
            static::$event(function (Model $model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function (Model $model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    protected function activityDescription($description)
    {
        return strtolower(class_basename($this)) . "_{$description}";
    }

    protected static function recordableEvents()
    {
        return ['created', 'updated', 'deleted'];
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity(string $description)
    {
        return $this->activity()->create([
            'user_id' => $this->activityOwner()->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }

    protected function activityChanges()
    {
        if (!$this->wasChanged()) {
            return null;
        }

        return [
            'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
            'after' => Arr::except($this->getChanges(), 'updated_at'),
        ];
    }
}
