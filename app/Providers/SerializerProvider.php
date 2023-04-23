<?php

namespace Gameap\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(SerializerInterface::class, function () {

            return new Serializer(
                [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter())],
                [new JsonEncoder()],
            );
        });
    }
}
