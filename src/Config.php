<?php

namespace Phlide;

class Config
{
    public function joinPath(string ...$paths) : string
    {
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    public function getRootPath() : string
    {
        return ROOT_PATH;
    }

    public function getExportPath() : string
    {
        return $this->joinPath($this->getRootPath(), 'exports');
    }

    public function getPresentationPath() : string
    {
        return $this->joinPath($this->getRootPath(), 'presentations');
    }

    public function getStubPath() : string
    {
        return $this->joinPath($this->getRootPath(), 'src', 'Stub');
    }

    public function getViewPaths() : array
    {
        return [
            'view' => [
                'paths' => [
                    $this->getPresentationPath(),
                    $this->joinPath($this->getRootPath(), 'resources', 'views')
                ],
                'compiled' => $this->joinPath($this->getRootPath(), 'cache')
            ]
        ];
    }

}