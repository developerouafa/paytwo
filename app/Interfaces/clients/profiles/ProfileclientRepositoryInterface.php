<?php
namespace App\Interfaces\Clients\Profiles;


interface ProfileclientRepositoryInterface
{

    //* get All Profile Client
    public function edit($request);

    //* Patch Update Profile Client
    public function update($request);

    //* delete Profile Client
    public function destroy($request);

}
