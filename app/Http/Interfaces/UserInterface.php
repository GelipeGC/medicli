<?php

namespace App\Http\Interfaces;

use App\Http\Interfaces\ResourceInterface;


interface UserInterface 
{
    
    public function all(array $request);

    public function create(Array $request);

    public function update(Array $request, int $id);

    public function delete($id);
}
