<?php
use Illuminate\Database\Seeder;
use Faker\Factory as F;
class PruebaVelocidad extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $faker = F::create('App\Proovedores');
        for($i=0; $i < 30000; $i++){
            DB::table('proovedores')->insert([
                'nombre' => $faker->name,
                'descripcion' => $faker->realText(200, 3),
            ]);
            DB::table('productos')->insert([
                'id_proovedor' => $faker->numberBetween(1,30000),
                'nombre' => $faker->name,
                'ganancia' => $faker->numberBetween(10, 3000),
            ]);
            DB::table('socios')->insert([
                'id_organismo' => $faker->numberBetween(1,10),
                'nombre' => $faker->name,
                'fecha_nacimiento' => $faker->date('Y-m-d'),
                'cuit' => $faker->numberBetween(7000,9999),
                'dni' => $faker->numberBetween(10000000, 99999999),
                'domicilio' => $faker->streetAddress,
                'localidad' => $faker->name,
                'codigo_postal' => $faker->randomNumber,
                'telefono' => $faker->randomNumber,
                'legajo' => $faker->randomNumber(8),
            ]);
            DB::table('ventas')->insert([
                'id_asociado' => $faker->numberBetween(1,30000),
                'id_producto' => $faker->numberBetween(1,30000),
                'nro_cuotas' => $faker->randomNumber,
                'fecha' => $faker->date('Y-m-d'),
            ]);
            DB::table('cuotas')->insert([
                'cuotable_id' => $faker->numberBetween(1,30000),
                'cuotable_type' => 'App\Ventas',
                'importe' => $faker->randomNumber,
                'fecha_vencimiento' => $faker->date('Y-m-d'),
                'fecha_inicio' => $faker->date('Y-m-d'),
                'nro_cuota' => $faker->randomNumber,
            ]);
            DB::table('movimientos')->insert([
                'identificadores_id' => $faker->numberBetween(1,30000),
                'identificadores_type' => 'App\Cuotas',
                'entrada' => $faker->randomNumber,
                'fecha' => $faker->date('Y-m-d'),
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}