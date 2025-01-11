<?php

namespace App\Shop\Cart\Storage;

interface StorageInterface
{
    function get();

    function set($products);

    function clear();
}