<?php

namespace DeejayFilesOrganizerBundle\Organizer;


use Symfony\Component\Filesystem\Filesystem;

class MoveInstruction
{
    /** @var  \SplFileInfo */
    private $fsys;

    private $origin;

    private $finalPathFileParts = [];

    private $tagInfo;

    private $outPath;

    public function __construct($outPath, $file)
    {
        if (!is_file($file)) {
            throw new \Exception(sprintf('File %s not exist', $file));
        }
        $this->fsys = new \SplFileInfo($file);
        $this->setOrigin($file);
        $this->outPath = $outPath;

    }
    /**
     * @return mixed
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param mixed $origin
     * @return MoveInstruction
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
        return $this;
    }

    public function addPathPart($part)
    {
        $this->finalPathFileParts [] = trim($part);
    }
    /**
     * @param mixed $destination
     * @return MoveInstruction
     */
    public function getFinalDestination()
    {
        $destination = sprintf(
            '%s%s%s%s%s',
            $this->outPath,
            DIRECTORY_SEPARATOR,
            implode(DIRECTORY_SEPARATOR, $this->finalPathFileParts),
            DIRECTORY_SEPARATOR,
            $this->getFsys()->getBasename()
        );
        $pattern = '#('.DIRECTORY_SEPARATOR.')\1+#';
        $replacement = DIRECTORY_SEPARATOR;
        return preg_replace($pattern, $replacement, $destination);
    }

    public function getTagInfo()
    {
        if(!$this->tagInfo) {
            $id3 = new \getID3();
            $this->tagInfo = $id3->analyze($this->getOrigin())['tags'];
        }
        return $this->tagInfo;
    }

    /**
     * @return \SplFileInfo
     */
    public function getFsys()
    {
        return $this->fsys;
    }


}