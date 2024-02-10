<?php

namespace Plide\Support;

use InvalidArgumentException;

class DirectoryValidator
{
    private array $tests = [];

    public function __construct(
        private readonly string $path
    )
    {
        //
    }

    public static function start(string $path) : DirectoryValidator
    {
        return new DirectoryValidator($path);
    }

    public function exist() : self
    {
        $this->tests['directoryExist'] = is_dir($this->path);
        return $this;
    }

    public function notExist() : self
    {
        $this->tests['directoryNotExist'] = !is_dir($this->path);
        return $this;
    }


    public function isRootDir(string $directory) : self
    {
        $this->tests['isRootDir'] = str_starts_with($directory, ROOT_PATH);
        return $this;
    }


    public function isWritable() : self
    {
        $this->tests['isWritable'] = is_writable($this->path);

        return $this;
    }

    public function isParentWritable() : self
    {
        $this->tests['isParentWritable'] = is_writable(dirname($this->path));

        return $this;
    }


    public function pass() : void
    {

        $isValid = !in_array(false, array_values($this->tests));

        if(!$isValid) {
            $failed = array_search(false, $this->tests);
            throw new InvalidArgumentException(sprintf(
                'Directory %s failed %s validation',
                $this->path,
                $failed
            ));
        }
    }







}