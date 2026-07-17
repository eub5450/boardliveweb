<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BrotliCompression
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only compress successful HTML/text responses
        if (
            extension_loaded('brotli') &&
            $response->isSuccessful() &&
            $this->isCompressible($response)
        ) {
            $content = $response->getContent();
            if (!empty($content)) {
                $compressed = brotli_compress($content, 11); // Compression level 0-11
                if ($compressed !== false) {
                    $response->setContent($compressed);
                    $response->headers->set('Content-Encoding', 'br');
                    $response->headers->set('Content-Length', strlen($compressed));
                }
            }
        }

        return $response;
    }

    /**
     * Check if response is compressible.
     */
    protected function isCompressible(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type');
        return $contentType && (
            str_contains($contentType, 'text/html') ||
            str_contains($contentType, 'text/plain') ||
            str_contains($contentType, 'application/javascript') ||
            str_contains($contentType, 'text/css') ||
            str_contains($contentType, 'application/json')
        );
    }
}
