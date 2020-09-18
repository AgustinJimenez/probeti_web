<?php namespace Modules\Clientes\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Faker\Factory as Faker;

class populateAllSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//composer require fzaninotto/faker
		
		// $this->call("OthersTableSeeder");
		
		Model::unguard();
		
		$faker = Faker::create();

		for ($i=0; $i < 10000; $i++) 
		{
			DB::table('clientes__clientes')->insert([
			'nombre'=> $faker->name,
			'ruc'=> $faker->numberBetween($min = 1000, $max = 90000),
			'telefono'=>  $faker->numberBetween($min = 1000, $max = 9000000),
			'celular'=>  $faker->numberBetween($min = 1000, $max = 9000000),
			'email'=>  $faker->unique()->email,
			'direccion'=>  $faker->address,
		    'contacto'=> $faker->text($maxNbChars = 200) ,
		    'razon_social'=> $faker->text($maxNbChars = 200) ,

			]);
		}
	}

}