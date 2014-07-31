<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\PostProvider\PostProviderFactory;

class CompleteCommand extends CommandAbstract
{
    public static $usage = '<command to complete>';

    protected $name = 'complete';

    protected $completeType;

    protected $completeString;

    protected $ignoreEmptyArgs = false;

    /**
     * Execute complete command and return the response
     *
     * @return array Response
     */
    public function executeCommand()
    {
        $argCount = count($this->arguments);
        if ($argCount > 1) {
            $asd = $this->findPostsStartingWith($this->arguments[$argCount - 1]);
        } elseif ($argCount == 0) {
            $asd = $this->findCommandsStartingWith('');
        } else {
            $asd = $this->findCommandsStartingWith($this->arguments[0]);
        }

        if (!is_array($asd)) {
            return array(
                'complete' => $asd,
            );
        }

        return array(
            'list' => $asd,
        );
    }

    protected function findPostsStartingWith($string)
    {
        $postProvider = PostProviderFactory::make();
        $postList = array();
        foreach ($postProvider as $post) {
            $postList[] = $post->postname;
        }

        return $this->matchBeginning($string, $postList);
    }

    protected function findCommandsStartingWith($string)
    {
        $commandList = CommandFactory::$commandList;

        return $this->matchBeginning($string, $commandList);
    }

    protected function matchBeginning($string, $haystack)
    {
        $emptyString = strlen($string) == 0;

        $matchedList = array();
        foreach ($haystack as $name) {
            if ($emptyString || strpos($name, $string) === 0) {
                $matchedList[] = $name;
            }
        }

        if (count($matchedList) == 1) {
            return substr($matchedList[0], strlen($string));
        }

        return $matchedList;
    }

    /**
     * Removes empty arguments until a non-empty argument is reached
     */
    protected function checkArgumentsValid()
    {
        foreach ($this->arguments as $index => $arg) {
            if (strlen($arg) > 0) {
                array_splice($this->arguments, 0, $index);
                return;
            }
        }

        // If no non-empty argument found
        $this->arguments = array();
    }
}