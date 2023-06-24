<?php

namespace Thuanvp012van\ImageOptimizer\Webp;

use Symfony\Component\Process\Process;
use Thuanvp012van\ImageOptimizer\OptimizerInterface;

class Webp implements OptimizerInterface
{
    protected string $input;

    protected array $commands = [];

    protected string $execFile = '';

    public function __construct() {
        $dir = __DIR__;
        $os = PHP_OS;
        $pathCommand = join(DIRECTORY_SEPARATOR, [
            $dir, 'bin', $os, $this->execFile
        ]);

        if ($os === 'WINNT') {
            $pathCommand .= '.exe';
        } else {
            $pathCommand = './' . $pathCommand;
        }

        $this->commands[] = $pathCommand;
    }

    public static function create(): static
    {
        return new static;
    }

    public function setInput(string $input): static
    {
        $this->input = $input;
        return $this;
    }

    public function optimizer(string $output): bool
    {
        $this->commands[] = '-size';
        $this->commands[] = 1000;
        $this->commands[] = $this->input;
        $this->commands[] = '-o';
        $this->commands[] = $output;
        $process = new Process($this->commands, null, null, null, null);
        $process->mustRun();
        return true;
    }
}