<?php

namespace App\Service\Upload;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadService
{
    private $targetDirectory;

    /**
     * @var SluggerInterface
     */
    private $slugger;

    public function __construct(SluggerInterface $slugger, $targetDirectory)
    {
        $this->slugger = $slugger;
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @param UploadedFile|null $file
     * @return String|null
     */
    public function processFile(?UploadedFile $file)
    {
        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            try {
                $file->move($this->getTargetDirectory(), $newFilename);
            } catch (FileException $e) {
                throw new \Exception($e->getMessage());
            }
            return $newFilename;
        }
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
