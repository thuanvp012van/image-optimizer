<?php

namespace Thuanvp012van\ImageOptimizer;

interface OptimizerInterface
{
    public static function create(): static;

    public function setInput(string $input): static;

    public function optimizer(string $output): bool;
}