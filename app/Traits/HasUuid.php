<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

trait HasUuid
{
    /**
     * This trait his heavily inspired by and based on the following implementations of UUID generation traits:
     *
     * Laravel-UUID: https://github.com/binarycabin/laravel-uuid
     * UuidModel Trait: https://gist.github.com/danb-humaan/b385ef92ed2336fd5d12
     * The mysterious “Ordered UUID” by
     *      Italo Baeza Cabrera: https://itnext.io/laravel-the-mysterious-ordered-uuid-29e7500b4f8
     */

    public static function boot()
    {
        parent::boot();

        /**
         * Listens for a model creation event and generates a UUID for the desired UUID column
         */
        static::creating(function ($model) {
            $uuidFieldName = 'id';
            $useTimeOrderedUuid = false;

            if (empty($model->{$uuidFieldName})) {
                if (App::environment(['local', 'testing'])) {
                    $model->{$uuidFieldName} = static::generateReadableUuidForTesting($model);
                } else {
                    $model->{$uuidFieldName} = ($useTimeOrderedUuid) ?
                        static::generateTimeOrderedUuid()
                        :
                        static::generateUuid();
                }
            }
        });

        /**
         * Listens for a model saving event to prevent a UUID from being changed.
         * TODO: TEST TO SEE WHETHER THIS OBSTRUCTS IF A MODEL IS SAVED MANUALLY RATHER THAN BEING CREATED
         */
        static::saving(function ($model) {
            $uuidFieldName = $model->getUuidFieldName();
            $originalUuid = $model->getOriginal($uuidFieldName);

            if (!empty($originalUuid)) {
                if ($originalUuid !== $model->{$uuidFieldName}) {
                    $model->{$uuidFieldName} = $originalUuid;
                    Log::warning('Attempt to change existing UUID blocked');
                }
            }
        });
    }

    /**
     * Static call to search for a record via the UUID
     *
     * @param $uuid
     *
     * @return mixed
     */
    public static function findByUuid($uuid)
    {
        return static::byUuid($uuid)->first();
    }

    /**
     * Generates a test UUID with the model name as a prefix for easy distinction when testing
     *
     * @param $model
     *
     * @return string
     */
    public static function generateReadableUuidForTesting($model): string
    {
        $className = strtolower(class_basename($model)) . '-';

        $numToRemove = strlen($className);
        $remaining = (36 - (int) $numToRemove);

        return $className . Str::substr(static::generateUuid(), $numToRemove, $remaining);
    }

    /**
     * Generates a "Time Ordered" UUID which is generated in conjunction with the server timestamp.  Less unique, but
     * useful if ordering by time is important
     *
     * @return string
     */
    public static function generateTimeOrderedUuid(): string
    {
        return (string) Str::orderedUuid();
    }

    /**
     * Generates a standard version 4 UUID
     *
     * @return string
     */
    public static function generateUuid(): string
    {
        return (string) Str::uuid();
    }

    /**
     * Checks to see if "Time Ordered" UUIDs have been specified
     *
     * @return bool
     */
    public function getUseTimeOrderedUuid(): bool
    {
        if ($this->useTimeOrderedUuid) {
            return true;
        }

        return false;
    }

    /**
     * Check to see if a specific column name has been specified for the UUID
     *
     * @return string
     */
    public function getUuidFieldName(): string
    {
        if ($this->primaryKeyIsUuid) {
            return $this->getKeyName();
        }

        if (!empty($this->uuidFieldName)) {
            return $this->uuidFieldName;
        }

        return 'uuid';
    }

    /**
     *  Scoping method to search for a record via the UUID
     *
     * @param $query
     * @param $uuid
     *
     * @return mixed
     */
    public function scopeByUuid($query, $uuid)
    {
        return $query->where($this->getUuidFieldName(), $uuid);
    }
}
