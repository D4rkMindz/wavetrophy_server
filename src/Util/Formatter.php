<?php


namespace App\Util;

/**
 * Class Formatter
 */
class Formatter
{
    /**
     * Format event.
     *
     * @param array $event
     * @return array
     */
    public static function formatEvent(array $event): array
    {
        $tmp = [];
        $tmp['hash'] = $event['hash'];
        $tmp['day'] = $event['day'];
        $tmp['start'] = $event['start'];
        $tmp['title'] = $event['title'];
        $tmp['description'] = $event['description'];
        return $tmp;
    }

    /**
     * Format location.
     *
     * @param array $location
     * @return array
     */
    public static function formatLocation(array $location): array
    {
        $tmp = [];
        $tmp['hash'] = $location['hash'];
        $tmp['title'] = $location['title'];
        $tmp['description'] = $location['description'];
        $tmp['address'] = [
            'lat' => $location['address_lat'],
            'lon' => $location['address_lon'],
            'url' => [
                'android' => $location['address_url_android'],
                'ios' => $location['address_url_ios'],
            ],
            'text' => [
                'zip' => $location['address_zip'],
                'city' => $location['address_city'],
                'street' => $location['address_street'],
                'comment' => $location['address_comment'],
            ]
        ];
        return $tmp;
    }
}
