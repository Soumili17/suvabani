<?php

if (!function_exists('youtubeEmbedUrl')) {

    function youtubeEmbedUrl($url)
    {
        if (!$url) return null;

        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([^?&]+)/',
            $url,
            $matches
        );

        $videoId = $matches[1] ?? null;

        return $videoId ? "https://www.youtube.com/embed/" . $videoId : null;
    }
}