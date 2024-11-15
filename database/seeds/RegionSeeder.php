<?php

use Illuminate\Database\Seeder;
use App\Region;
use App\Province;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "NCR",
            "CAR",
            "Region 1",
            "Region 2",
            "Region 3",
            "Region 4",
            "Region 5",
            "Region 6",
            "Region 7",
            "Region 8",
            "Region 9",
            "Region 10",
            "Region 11",
            "Region 12",
            "Region 13",
            "BARMM",
        ];
        foreach($data as $row) {
            $region = new Region();
            $region->description = $row;
            $region->save();
        }

        Province::query()->update([
            "region_id" => 9
        ]);
    }
}
