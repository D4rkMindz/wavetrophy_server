<?php


namespace App\Factory;


class MapURLFactory
{
    /**
     * Create URL for android devices
     *
     * @param string $lat
     * @param string $lon
     * @param array $additionalStops structured like ['position' => 1, 'lat' => 'blabla', 'lon' => 'blaalb']
     * @return string
     */
    public static function createForAndroid(string $lat, string $lon, $additionalStops = []): string
    {
        // https://maps.google.com/?daddr=47.388789,8.676881+to:47.500412,8.676881
        $url = "https://maps.google.com/?daddr={$lat},{$lon}";
        if (empty( $to)) {
            return $url;
        }

        usort($additionalStops, function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        foreach ($additionalStops as $stop) {
            $url .= "+to:{$stop['lat']},{$stop['lon']}";
        }
        return $url;
    }

    /**
     * Create URL for iOS devices
     *
     * @param string $lat
     * @param string $lon
     * @param array $additionalStops structured like ['position' => 1, 'lat' => 'blabla', 'lon' => 'blaalb']
     * @return string
     */
    public static function createForiOS(string $lat, string $lon, $additionalStops = []): string
    {
        // https://maps.apple.com/?daddr=47.388789,8.676881+to:47.500412,8.676881
        $url = "https://maps.apple.com/?daddr={$lat},{$lon}";
        if (empty( $to)) {
            return $url;
        }

        usort($additionalStops, function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        foreach ($additionalStops as $stop) {
            $url .= "+to:{$stop['lat']},{$stop['lon']}";
        }
        return $url;
    }
}
