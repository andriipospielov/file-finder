<?php

/**
 * Class FileFinder
 */
class FileFinder implements FileFinderInterface
{

    /**
     * Directories to be looked into
     * @var array
     */
    public $searchDirs = array();


    /**
     * Output files only, if equals $dirsOnly both files and directories are to be outputted
     * @var bool
     */
    public $filesOnly = false;
    /**
     * utput dirs only, if equals $filesOnly both files and directories are to be outputted
     * @var bool
     */
    public $dirsOnly = false;

    /**
     * Array of regexps
     * @var
     */
    public $regExpsArray;

    /**
     * Find only files
     * @return FileFinder
     */
    public function isFile()
    {
        $this->filesOnly = true;
        return $this;
    }


    /**
     * Find only directories
     * @return FileFinder
     */
    public function isDir()
    {
        $this->dirsOnly = true;
        return $this;
    }


    /**
     * Search in directory $dir
     * @param string $dir
     * @return FileFinder
     */
    public function inDir($dir)
    {
        $this->searchDirs[] = $dir;
        return $this;
    }


    /**
     * Filter by regular expression on path
     * @param string $regularExpression
     * @return FileFinder
     */
    public function match($regularExpression)
    {
        $this->regExpsArray[] = $regularExpression;
        return $this;
    }


    /**
     * Returns items in given directory
     * @param $dir
     * @return array
     * @throws Exception
     */
    public function lookupInOneDir($dir)
    {
        $res = array();
if (! $scanRes = scandir($dir))
    throw new Exception('No directories found!');


        foreach ($scanRes as $item) {

            if (
                ($this->dirsOnly xor $this->filesOnly) and
                ($this->dirsOnly xor is_dir($dir . '/' . $item))
                )
                continue;


            if ($this->regExpsArray) {
                foreach ($this->regExpsArray as $regexp) {
                    if (preg_match($regexp, $item))
                        $res[] = $item;
                }
            } else $res[] = $item;
        }
        return $res;
    }

    /**
     * Returns array of all found files/dirs (full path)
     * @return string[]
     * @throws Exception
     */
    public function getList()

    {
        if ($this->searchDirs == null)
            throw new Exception('No directory provided!');

        $result = array();

        foreach ($this->searchDirs as $searchdir) {
            $result[] = '['.$searchdir.']: ';
            $buffer = $this->lookupInOneDir($searchdir);
            $result = array_merge($result, $buffer);
        }
        return $result;
    }
}