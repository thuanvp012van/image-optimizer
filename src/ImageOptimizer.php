<?php

namespace Thuanvp012van\ImageOptimizer;

use Thuanvp012van\ImageOptimizer\Webp\WebpDecoder;
use Thuanvp012van\ImageOptimizer\Webp\WebpEncoder;

class ImageOptimizer
{
    /**
     * @var OptimizerInterface[]
     */
    protected array $optimizers = [];

    public function optimize(string $input, string $output): bool
    {
        $input = is_dir(dirname($input)) ? $input : getcwd() . '/' . $input;
        $output = is_dir(dirname($output)) ? $output : getcwd() . '/' . $output;

        $currentOutput = null;
        foreach ($this->optimizers as $index => $optimizer) {
            if ($index === array_key_last($this->optimizers)) {
                return $optimizer->setInput($input)->optimizer($output);
            }

            $currentOutput = $this->generateOuput($optimizer);
            if ($optimizer->setInput($input)->optimizer($currentOutput)) {
                if ($index > 0) unlink($input);
                $input = $currentOutput;
            }
        }
    }

    public function addOptimizer(OptimizerInterface $optimizer): static
    {
        $this->optimizers[] = $optimizer;
        return $this;
    }

    protected function generateOuput(OptimizerInterface $optimizer): string
    {
        $extensions = [
            WebpDecoder::class => 'webp',
            WebpEncoder::class => 'webp',
        ];
        $ext = $extensions[get_class($optimizer)];
        return sprintf('%d_%d.%s', time(), rand(), $ext);
    }
}