<?php 
// src/Service/TokenGeneratorInterface.php

namespace App\Service;

interface TokenGeneratorInterface
{
    public function generateToken(): string;
}