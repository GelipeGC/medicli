<?php

use App\Http\Repositories;
use App\Http\Interfaces;

/**
 * Here are all repository interface registered in the project
 */

 return [
  App\Http\Interfaces\UserInterface::class => App\Http\Repositories\UserRepository::class,
 ];