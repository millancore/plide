<?php

namespace Plide\Support;

use FilesystemIterator;
use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Directory
{
    public function __construct(
        private readonly string $directory
    )
    {
        DirectoryValidator::start($directory)
            ->exist()
            ->isRootDir($directory)
            ->pass();
    }

    public static function create(string $directory ) : Directory
    {
        DirectoryValidator::start($directory)
            ->notExist()
            ->isParentWritable()
            ->pass();

        mkdir($directory);

        return new Directory($directory);
    }

    public function getPath() : string
    {
        return $this->directory;
    }


    public function isWritable() : bool
    {
        return is_writable($this->directory);
    }

    public function has(string $pathDirOrFile) : bool
    {
        return file_exists(
            $this->directory . DIRECTORY_SEPARATOR . $pathDirOrFile
        );
    }

    public function scanRecursive(
        int $mode = RecursiveIteratorIterator::SELF_FIRST
    ) : RecursiveIteratorIterator
    {
        $iterator = new RecursiveDirectoryIterator(
            $this->directory,
            FilesystemIterator::SKIP_DOTS
        );

        return new RecursiveIteratorIterator($iterator, $mode);
    }

    public function copyTo(
        Directory $target,
        callable $callback = null
    ) : void
    {

         if(!$target->isWritable()) {
             throw new InvalidArgumentException(
                 sprintf('Target directory %s is not writable',
                     $target->getPath()
                 ));
         }


        foreach ($this->scanRecursive() as $file) {

            // Replace origin with target
            $targetPath = str_replace($this->getPath(), $target->getPath(), $file);

            // If callback is provided, use it to modify the file
            if($callback) {
                $targetPath = $callback($targetPath);
            }

            $file->isDir() ? mkdir($targetPath) : copy($file, $targetPath);
        }

    }

    public function remove(): void
    {
        $files = $this->scanRecursive(RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file) {
            $file->isDir() ? rmdir($file) : unlink($file);
        }

        rmdir($this->directory);
    }

}