<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LType;
use App\Models\Magazine;
use App\Models\Officer;
use App\Models\Record;
use App\Models\Weapon;
use App\Models\WeaponType;

class TotalController extends Controller
{
    public function Total(){
        $total = [
            'license_types' => LType::count(),
            'magazines' => Magazine::count(),
            'officers' => Officer::count(),
            'records' => Record::count(),
            'weapons' => Weapon::count(),
            'weapon_types' => WeaponType::count(),
        ];

        return response()->json([
            'status' => 'success',
            'data'=>$total,
        ],200);
    }
}
