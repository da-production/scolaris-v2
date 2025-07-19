<?php

namespace App\Helpers;

class JobPayloadParser
{
    public static function parse(string $payloadJson): array
    {
        $parsed = [];

        try {
            $payload = json_decode($payloadJson, true);

            $command = unserialize($payload['data']['command'] ?? '');

            $parsed['command_class'] = get_class($command);
            $parsed['command_data'] = self::flattenObject($command);
        } catch (\Throwable $e) {
            $parsed['error'] = 'Erreur de parsing : ' . $e->getMessage();
        }

        return $parsed;
    }

    // Convertit récursivement un objet en tableau lisible
    protected static function flattenObject($object, $depth = 0)
    {
        if ($depth > 3) return '...'; // Pour éviter trop de récursion

        if (is_array($object)) {
            return array_map(fn($item) => self::flattenObject($item, $depth + 1), $object);
        }

        if (is_object($object)) {
            $data = [];
            foreach (get_object_vars($object) as $key => $value) {
                $data[$key] = self::flattenObject($value, $depth + 1);
            }
            return $data;
        }

        return $object;
    }
}
