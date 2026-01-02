<?php

namespace App\Observers;

class GeneralObserver
{
    /**
     * Handle the model "created" event.
     */
    public function created($model): void
    {
        $this->logActivity('create', $model);
    }

    /**
     * Handle the model "updated" event.
     */
    public function updated($model): void
    {
        // Avoid logging if no meaningful changes (or specific ignored fields)
        if ($model->wasChanged()) {
            $this->logActivity('update', $model);
        }
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted($model): void
    {
        $this->logActivity('delete', $model);
    }

    protected function logActivity($action, $model)
    {
        // Don't log activity logs themselves to prevent recursion
        if ($model instanceof \App\Models\ActivityLog) {
            return;
        }

        $className = class_basename($model);
        $subjectType = strtolower($className);
        $description = "User performed {$action} on {$className} #{$model->id}";

        // Custom descriptions based on model type can be added here
        if ($action === 'update') {
            $changes = $model->getChanges();
            unset($changes['updated_at']); // Ignore timestamp updates
            if (empty($changes))
                return;
            $description .= " (Changed: " . implode(', ', array_keys($changes)) . ")";
        }

        \App\Helpers\ActivityLogger::log(
            $action,
            $description,
            $subjectType,
            $model->id,
            'low'
        );
    }
}
