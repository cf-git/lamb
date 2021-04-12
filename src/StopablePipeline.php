<?php
/**
 * @author Shubin Sergei <is.captain.fail@gmail.com>
 * 12.04.2021 2021
 */

namespace CFGit\Lamb;

use Illuminate\Pipeline\Pipeline;

class StopablePipeline extends Pipeline {
    /**
     * Run the pipeline with a final destination callback.
     *
     * @param  \Closure  $destination
     * @return mixed
     */
    public function then(\Closure $destination)
    {
        $pipes = array_reverse($this->pipes());

        $pass = $this->prepareDestination($destination);
        while ($pass && ($pipe = array_shift($pipes))) {
            $pass = call_user_func($this->carry(), $pass, $pipe);
        }
        return $pass($this->passable);
    }
}
