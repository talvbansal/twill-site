<?php

namespace Talvbansal\TwillSite;

use Illuminate\Support\Str;

trait HasSeoItems
{
    private array $seoData = [];

    public function setImage(string $url) : self
    {
        $this->setSeoData([
            'og' => [
                'image' => [
                    'url' => $this->getFullUrl($url),
                ],
            ],
        ]);

        return $this;
    }

    public function setImageData(array $imageAsArray) : self
    {
        if (empty($imageAsArray)) {
            return $this;
        }

        $this->setSeoData([
            'og' => [
                'image' => [
                    'alt' => $imageAsArray['alt'],
                    'height' => $imageAsArray['height'],
                    'width' => $imageAsArray['width'],
                    'url' => $this->getFullUrl($imageAsArray['src']),
                ],
            ],
        ]);

        return $this;
    }

    public function setTitle(string $title = '') : self
    {
        $title = $title.' | '.config('app.name');

        $this->setSeoData([
            'title' => $title,
            'seo' => [
                'title' => $title,
            ],
            'og' => [
                'title' => $title,
            ],
        ]);

        return $this;
    }

    public function setDescription(string $description) : self
    {
        $this->setSeoData([
            'seo' => [
                'description' => $description,
            ],
        ]);

        return $this;
    }

    private function setSeoData(array $data = [])
    {
        $this->seoData = array_merge_recursive($this->seoData, $data);
    }

    public function getViewData(array $data = [])
    {
        $this->setSeoData([
            'seo' => [
                'urls' => [
                    'canonical' => url()->current(),
                ],
            ],
        ]);

        return array_merge($this->seoData, $data);
    }

    /**
     * @param string $url
     * @return string
     */
    private function getFullUrl(string $url): string
    {
        if (! Str::startsWith($url, 'http')) {
            $url = url($url);
        }

        return $url;
    }
}
