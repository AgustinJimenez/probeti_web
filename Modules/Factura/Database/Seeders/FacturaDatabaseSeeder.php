<?php namespace Modules\Factura\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;

class FacturaDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		DB::table('config_factura')->insert([
			'id'=>'1',
			'identificador'=>'nro_factura_1',
			'nombre'=>'factura_inicio',
			'valor'=>'001',
			'created_at'=>'0000-00-00 00:00:00',
			'updated_at'=>'0000-00-00 00:00:00'
			]);

		DB::table('config_factura')->insert([
			'id'=>'2',
			'identificador'=>'nro_factura_2',
			'nombre'=>'factura_medio',
			'valor'=>'001',
			'created_at'=>'0000-00-00 00:00:00',
			'updated_at'=>'0000-00-00 00:00:00'
			]);

		DB::table('config_factura')->insert([
			'id'=>'3',
			'identificador'=>'nro_factura_3',
			'nombre'=>'factura_final',
			'valor'=>'3',
			'created_at'=>'0000-00-00 00:00:00',
			'updated_at'=>'2016-11-30 12:25:02'
			]);

		DB::table('config_factura')->insert([
			'id'=>'4',
			'identificador'=>'timbrado',
			'nombre'=>'timbrado',
			'valor'=>'0',
			'created_at'=>'0000-00-00 00:00:00',
			'updated_at'=>'0000-00-00 00:00:00'
			]);
	}

}
