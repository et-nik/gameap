<?php

namespace Gameap\Providers;

use ECSPrefix20211002\Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
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
