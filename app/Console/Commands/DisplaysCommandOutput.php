<?php

namespace App\Console\Commands;

use Symfony\Component\Process\Process;

trait DisplaysCommandOutput
{
    /**
     * Get a function used to ensure output is shown when running a command using a Symfony Process instance
     *
     * @return \Closure
     */
    public function mustRunOutput()
    {
        return function($type, $buffer) {
            if(Process::ERR === $type) {
                $this->error($buffer);
            }
            else {
                $this->comment($buffer);
            }
        };
    }

//    /**
//     * Say the "Done" message
//     *
//     * @param string $done_message
//     */
//    private function sayDoneMessage($done_message = "Done!")
//    {
//        $this->comment($done_message . PHP_EOL);
//    }
}
