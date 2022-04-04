<?php

namespace App\System;

interface Logger
{
    public function log(string $message): void;
}