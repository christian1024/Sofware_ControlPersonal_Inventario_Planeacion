<?php

namespace database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
//use Caffeinated\Shinobi\Models\Permission;
use App\User;
//use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Seeder;

class NovedadesYajustes extends Seeder
{
    use WithoutModelEvents;
    public function run()
    {
        User::create([
            'id_Empleado' => 1616,
            'username' => 'aaa',
            'email' => 'aaaa@darwinperennials.com',
            'password' => Hash::make('Crodriguez2025.*'),
        ]);
        
    }
}