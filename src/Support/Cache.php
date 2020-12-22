<?php

namespace PrettyRoutes\Support;

use Illuminate\Support\Facades\Artisan;

final class Cache
{
    protected $when = true;

    public function when($value): self
    {
        $this->when = (bool) $value;

        return $this;
    }

    public function routeClear(): bool
    {
        return $this->when && $this->clear('route:clear');
    }

    protected function clear(string $command): bool
    {
        Artisan::call($command);

        return true;
    }
}
