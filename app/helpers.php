<?php

if (!function_exists('youtubeEmbedUrl')) {

    function youtubeEmbedUrl($url)
    {
        if (!$url) return null;

        // Match different YouTube formats
        preg_match(
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&]+)/',
            $url,
            $matches
        );

        $videoId = $matches[1] ?? null;

        return $videoId ? "https://www.youtube.com/embed/" . $videoId : null;
    }
}