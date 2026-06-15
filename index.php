<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * Proxy index.php untuk shared hosting
 * File ini meneruskan semua request ke public/index.php
 */

// Arahkan ke public/index.php
require __DIR__.'/public/index.php';
