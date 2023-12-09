<?php

namespace Tests\Traits;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait UsesDatabase
{
    use RefreshDatabase {
        refreshTestDatabase as parentRefreshTestDatabase;
    }

    /** @throws Exception */
    protected function refreshTestDatabase(): void
    {
        try {
            $this->parentRefreshTestDatabase();
        } catch (Exception $exception) {
            if (!$this->connectionError($exception)) {
                throw $exception;
            }

            sleep(5);

            $this->refreshTestDatabase();
        }
    }

    protected function connectionError(Exception $exception): bool
    {
        return str_contains($exception->getMessage(), 'SQLSTATE[08006] [7] could not connect to server: Connection refused')
            || str_contains($exception->getMessage(), 'SQLSTATE[HY000] [2002] Connection refused');
    }
}
