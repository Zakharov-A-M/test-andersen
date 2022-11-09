<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Exception\PublicExceptionInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    public const JSON_FORMAT
        = 'json';

    protected SerializerInterface $serializer;





    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return array<mixed>
     */
    protected function serialize(
        mixed $data,
        string $format = self::JSON_FORMAT,
        SerializationContext $context = null
    ): array {
        $serialized = $this->serializer->serialize($data, $format, $context);

        return json_decode($serialized, true);
    }

    protected function deserialize(
        string $data,
        string $type,
        string $format = self::JSON_FORMAT,
        DeserializationContext $context = null
    ): mixed {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }

    protected function handleException(PublicExceptionInterface $e): JsonResponse
    {
        return $this->json(
            $e->getData(),
            $e->getCode()
        );
    }

    protected function json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        $data = [
            'success' => $status < 400,
            'data' => $data,
        ];

        return parent::json($data, $status, $headers, $context);
    }
}
