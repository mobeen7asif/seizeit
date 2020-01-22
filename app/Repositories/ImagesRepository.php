<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Image;
use App\Models\FranchiseInfo;
use App\Uni;
use App\User;
use Illuminate\Support\Facades\DB;

class ImagesRepository extends Repository
{
    public function __construct(Image $image)
    {
        $this->setModel($image);
    }
}
