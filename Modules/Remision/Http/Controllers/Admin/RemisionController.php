<?php namespace Modules\Remision\Http\Controllers\Admin;

use Illuminate\Contracts\Validation\ValidationException;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Remision\Entities\Remision;
use Modules\Factura\Entities\Factura;
use Modules\Factura\Entities\FacturaDetalle;
use Modules\Obras\Entities\Obras;
use Modules\Clientes\Entities\Clientes;
use Modules\Remision\Entities\RemisionDetalle;
use Modules\Remision\Repositories\RemisionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Remision\Http\Requests\RemisionRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Input;
use Yajra\Datatables\Facades\Datatables;

class RemisionController extends AdminBaseController
{
    /**
     * @var RemisionRepository
     */
    private $remision;

    public function __construct(RemisionRepository $remision)
    {
        parent::__construct();

        $this->remision = $remision;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('remision::admin.remisions.index');
    }

    public function indexAjax(  )
    {
        $query = Remision::join('obras__obras','obras__obras.id','=','obra_id')
                ->join('clientes__clientes','clientes__clientes.id','=','obras__obras.cliente_id')
                ->select(['remision__remisions.id', 'remision__remisions.fecha_remision', 'remision__remisions.numero_remision', 'remision__remisions.estado', 'remision__remisions.terminado', 'obras__obras.nombre as obras__obras.nombre','clientes__clientes.nombre as clientes__clientes.nombre'])
                ->orderBy('fecha_remision');

        $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) 
            {
                $asEdit = "admin.remision.remision.edit";

                $asDestroy = "admin.remision.remision.destroy";

                $asCreateInforme = 'admin.remision.remision.createInforme';

                $asDetalles = 'admin.remision.remision.detalles';

                $asFacturaCreate = 'admin.factura.factura.create';

                $editRoute = route( $asEdit, [$tabla->id]);

                $deleteRoute = route( $asDestroy, [$tabla->id]);

                $createInforme = route( $asCreateInforme, [$tabla->id] );

                $DetallesRemision = route( $asDetalles, [$tabla->id]);

                $informe = "
                            <a href='".$createInforme."' class='btn btn-default btn-flat'><strong>INFORMES</strong></a>
                            ";
                
                $buttons=" ".$informe."<div class='btn-group'>
                            <a href='". $editRoute."' class='btn btn-default btn-flat'>
                                <i class='fa fa-pencil'></i>
                            </a><a href='".$DetallesRemision."' class='btn btn-default btn-flat'>Detalles</a>
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='". $deleteRoute ."'>
                                <i class='fa fa-trash'></i>
                            </button>
                        </div>";

                return $buttons;
            })
            ->editColumn('estado',' @if($estado)
                                        SI
                                    @else
                                        NO
                                    @endif')
            ->editColumn('terminado',' @if($terminado)
                                        SI
                                    @else
                                        NO
                                    @endif')
            ->make();

          
       
        return $object;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $obras = Obras::where('activo', 1)->get(['nombre','id', 'diametro']);
        return view('remision::admin.remisions.create', compact('obras'));
    }
    public function search_remision( Request $re )
    {
        //dd($re->all());
        $results = array();
        if ($re->has('term') &&  $re->has('cliente_id')) 
        {
            $remisiones = Remision::with
            (['obra' => function($obra) use ($re)
            {
                $obra->with(['cliente' => function($cliente) use ($re)
                {
                    $cliente
                    ->where("id", $re['cliente_id'])->select('id', 'nombre', 'razon_social');
                }])
                ->where('activo', true)
                ->select('id', 'nombre', 'etiqueta', 'cliente_id');
            }, 
            'detalles'])//falta filtra mas datos sin usar?
            //->orWhere('numero_remision', 'like', "%{$re->get('term')}%")
            ->take(7)
            ->where('numero_remision', 'like', "%{$re->get('term')}%")
            ->select('id', "numero_remision as value", "obra_id")
            ->get()
            ->reject(function ($remision) 
            {
                 if(!$remision->obra->cliente)
                    return $remove_this = true;
            });

//dd($remisiones[0]->obra->cliente);
            foreach ($remisiones as $key => $remision) 
            {
                $cantidades = $remision->clasificacion_cantidades;
                $remision->cantidades_probetas_chicas = $cantidades['chicas'];
                $remision->cantidades_probetas_medianas = $cantidades['medianas'];
                $remision->cantidades_probetas_grandes = $cantidades['grandes'];
                $razon_social = $remision->obra->cliente?$remision->obra->cliente->razon_social:"sin cliente";
                $remision->value = "Nro Remision: {$remision->value} -Obra: {$remision->obra->etiqueta} {$remision->obra->nombre} -Cliente: {$razon_social}";
            }
        }

    return \Response::json( $remisiones->toArray() );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    
    function format($array = [])
    {
        foreach ($array as $key => $value) 
            $array[$key] = str_replace(',', '.', str_replace('.','',$value));
        return $array;
    }
    public function store(Request $request)
    {
        $numero_probeta = $request->get('numero_probeta');
        $fecha_moldeo = $request->get('fecha_moldeo');
        $fecha_rotura = $request->get('fecha_rotura');
        $fck = $request->get('fck');
        $pieza_estructural = $request->get('pieza_estructural');
        $diametros = $request->diametro;
        $alturas = $request->altura;
        $pesos = $request->peso;
        $diametros = $this->format($diametros);
        $alturas = $this->format($alturas);
        $pesos = $this->format($pesos);
        $edad = array();
        foreach ($fecha_rotura as $key => $FR) 
        {
            $fecha_moldeo[$key] = Carbon::createFromFormat('d/m/Y',$fecha_moldeo[$key]);
            $fecha_rotura[$key] = Carbon::createFromFormat('d/m/Y',$fecha_rotura[$key]);
            $edad[] = $fecha_rotura[$key]->diffInDays($fecha_moldeo[$key]);
            
        }
        DB::beginTransaction();

        try
        {
            $fecha_remision = Carbon::createFromFormat('d/m/Y', $request->get('fecha_remision'));
            $remision = Remision::create([
               'obra_id' => $request->get('obra_id'),
                'fecha_remision' => $fecha_remision->format('Y-m-d'),
                'numero_remision' => $request->get('numero_remision')
            ]);

            for($i=0;$i<count($numero_probeta);$i++)
            {
                $remision_detalle = RemisionDetalle::create
                ([
                    'numero_probeta' => $numero_probeta[$i],
                    'fecha_moldeo'=> $fecha_moldeo[$i]->format('Y-m-d'),
                    'dias'=>$edad[$i],
                    'fck'=> str_replace(",", ".", $fck[$i]),
                    'diametro'=>$diametros[$i],
                    'altura' => $alturas[$i],
                    'peso' => $pesos[$i],
                    'pieza_estructural'=>$pieza_estructural[$i],
                    'fecha_rotura'=>$fecha_rotura[$i],
                    'remision_id' => $remision->id
                ]);
            }


        }catch (ValidationException $e)
        {
            DB::rollBack();
            return redirect()->back()->withErrors($e);
        }

        DB::commit();
        flash()->success( 'Remision creada correctamente.' );
        return redirect()->route('admin.remision.remision.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Remision $remision
     * @return Response
     */
    public function edit(Remision $remision)
    {
        //dd($remision);
        //$obras = Obras::lists('nombre', 'id')->toArray();
        $obras = Obras::where('activo', 1)->get(['nombre','id','diametro']);
        $x = 0;
        $remision_detalles = RemisionDetalle::where('remision_id', $remision->id)->get();
        foreach ($remision_detalles as $k => $value)
        {
            $x = $k;
        }
        return view('remision::admin.remisions.edit', compact('remision', 'obras', 'remision_detalles', 'x'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        //dd( $request->all() );
        $numero_probeta = $request->get('numero_probeta');
        $fecha_moldeo = $request->get('fecha_moldeo');
        $fecha_rotura = $request->get('fecha_rotura');
        $fck = $request->get('fck');
        $pieza_estructural = $request->get('pieza_estructural');
        $detalle_id = $request->get('detalle_id');
        $eliminar = $request->get('eliminar');
        $diametros = $request->diametro;
        $alturas = $request->altura;
        $pesos = $request->peso;
        $diametros = $this->format($diametros);
        $alturas = $this->format($alturas);
        $pesos = $this->format($pesos);

        $edad = array();
        foreach ($fecha_rotura as $key => $FR) 
        {
            $fecha_moldeo[$key] = Carbon::createFromFormat('d/m/Y',$fecha_moldeo[$key]);
            $fecha_rotura[$key] = Carbon::createFromFormat('d/m/Y',$fecha_rotura[$key]);
            $edad[] = $fecha_rotura[$key]->diffInDays($fecha_moldeo[$key]);
        }

        DB::beginTransaction();

        try{
            $fecha_remision = Carbon::createFromFormat('d/m/Y', $request->get('fecha_remision'));
            $remision = Remision::where('id', $request->get('remision_id'))->update([
                'obra_id' => $request->get('obra_id'),
                'fecha_remision' => $fecha_remision->format('Y-m-d'),
                'numero_remision' => $request->get('numero_remision')
            ]);

            for($i=0;$i<count($numero_probeta);$i++){

                if(isset($eliminar[$i]) && $eliminar[$i]){

                    if (isset($detalle_id[$i]) && $detalle_id[$i] != null) {

                        RemisionDetalle::where('id', $detalle_id[$i])->delete();

                    }

                }else {

                    if (!isset($detalle_id[$i])) 
                    {
                        $rd = RemisionDetalle::create(
                            [
                                'numero_probeta' => $numero_probeta[$i],
                                'fecha_moldeo' => $fecha_moldeo[$i],
                                'dias'=>$edad[$i],
                                'fecha_rotura'=>$fecha_rotura[$i],
                                'fck' => $fck[$i]?str_replace(",", ".", $fck[$i]):0,
                                'diametro' => $diametros[$i], 
                                'altura' => $alturas[$i],
                                'peso' => $pesos[$i],
                                'pieza_estructural' => $pieza_estructural[$i],
                                'remision_id' => $request->get('remision_id')
                            ]
                        );
                    } 
                    else 
                    {
                       $rd =  RemisionDetalle::where('id', $detalle_id[$i])->update(
                            [
                                'numero_probeta' => $numero_probeta[$i],
                                'fecha_moldeo' => $fecha_moldeo[$i],
                                'fecha_rotura'=>$fecha_rotura[$i],
                                'dias' => $edad[$i],
                                'fck' => str_replace(",", ".", $fck[$i]),
                                'diametro' => $diametros[$i], 
                                'altura' => $alturas[$i],
                                'peso' => $pesos[$i],
                                'pieza_estructural' => $pieza_estructural[$i],
                            ]
                        );
                    }
                }

            }


        }catch (ValidationException $e)
        {
            DB::rollBack();
            return redirect()->back()->withErrors($e);
        }

        DB::commit();

        flash()->success("Remision Actualizada correctamente");

        return redirect()->route('admin.remision.remision.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Remision $remision
     * @return Response
     */
    public function destroy(Remision $remision)
    {
        try 
        {
            $this->remision->destroy($remision);

            flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('remision::remisions.title.remisions')]));

        } 
        catch(\Illuminate\Database\QueryException $e)
        {
            flash()->error('Error al eliminar a la remision, posiblemente ya tiene datos asignados.', ['name' => trans('remision::remisions.title.remisions')]);
        }


        

        return redirect()->route('admin.remision.remision.index');
    }

    public function detalles(Remision $remision)
    {
        $remision_detalles = RemisionDetalle::where('remision_id', $remision->id)->get();

        return view('remision::admin.remisions.detalles', compact('remision', 'remision_detalles'));
    }


    public function probetas()
    {
        $remision_detalles = RemisionDetalle::where('fecha_rotura', Carbon::now()->format('Y-m-d'))->get();
        $now=Carbon::now('America/Asuncion')->format('d/m/Y');
        return view('remision::admin.remisions.probetas', compact('remision_detalles','now'));
    }

    public function probetaEditar($remisionDetalle)
    {

        $detalle = RemisionDetalle::where('id', $remisionDetalle)->first();
        
        $fck = $detalle->fck;
        $area = $detalle->area;

        $remision=Remision::where('id',$detalle->remision_id)->get();
        $obra=Obras::where('id',$remision[0]->obra_id)->get();
        $cliente=Clientes::where('id',$obra[0]->cliente_id)->get();

        dd($remision[0]);

        return view('remision::admin.remisions.probetas-edit', compact('remision','detalle', 'fck', 'area','obra','cliente'));
    }
        

    public function probetaUpdate(Request $request)
    {
        //dd($request->except('_token') );
        RemisionDetalle::where('id', $request->get('detalle_id'))->update([
            'carga_aplicada' => $request->get('carga_aplicada'),
            'resistencia' => $request->get('resistencia'),
            'porcentaje' => $request->get('porcentaje'),
            'area' => $request->get('area')

        ]);

        if( !empty($request->get('carga_aplicada')) && !empty($request->get('resistencia')) && !empty($request->get('porcentaje')) )
        {
            Remision::where('id', $request->get('remision_id'))->update([
                'terminado' => true
            ]);
        }

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('remision::remisions.title.remisions')]));

        return redirect()->route('admin.remision.remision.probeta.lista');

    }

    public function probetaEliminar($detalle)
    {
        try 
        {
            RemisionDetalle::where('id', $detalle)->delete();

            flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('remision::remisions.title.remisions')]));

        } 
        catch(\Illuminate\Database\QueryException $e)
        {
            flash()->error('Error al eliminar a la probeta, posiblemente ya tiene datos asignados.', ['name' => trans('remision::remisions.title.remisions')]);
        }


        return redirect()->route('admin.remision.remision.probeta.lista');
    }

    public function probetaSearch(Request $request)
    {
        $c = 0;
        $fecha = Carbon::createFromFormat('d/m/Y', $request->get('fecha'));
        $detalles = RemisionDetalle::join('remision__remisions','remision__remisions.id','=','remision__detalle.remision_id')
            ->join('obras__obras','obras__obras.id','=','remision__remisions.obra_id')
            ->where('fecha_rotura', $fecha->format('Y-m-d'))
            ->get(['remision__detalle.id as nro','remision__detalle.id', "remision__detalle.diametro", DB::raw('CONCAT(obras__obras.etiqueta,"-",remision__detalle.numero_probeta) as numero_probeta'), 'remision__detalle.fecha_moldeo', 'remision__detalle.dias', 'remision__detalle.fecha_rotura','remision__detalle.resistencia','remision__detalle.carga_aplicada', 'remision__remisions.estado','remision__detalle.pieza_estructural', 'remision__remisions.estado as acciones']);

        foreach ($detalles as $key => $detalle) 
        {
           $detalle->carga_aplicada_format = $detalle->wformat('carga_aplicada');
           $detalle->resistencia_format = $detalle->wformat('resistencia');
        }
        
        //dd( $detalles->toArray() );

        foreach ($detalles as $detalle) 
        {
            $c = $c + 1;
            $detalle->nro = $c;
            if(empty($detalle->resistencia) || $detalle->resistencia==0 ) 
            {

                $detalle->estado = "<a href='#' class='btn-small btn-danger btn-flat'>Pendiente</a>";
                $ruta_edit = route('admin.remision.remision.probeta.edit', [$detalle->id]);
                $ruta_delete = route('admin.remision.remision.probeta.destroy', [$detalle->id]);
                $detalle->acciones = "<div class='btn-group'><a href='".$ruta_edit."' class='btn btn-default btn-flat'> <i class='fa fa-pencil'></i></a>";
                $detalle->acciones .= "<button class='btn btn-danger btn-flat' data-toggle='modal'  data-target='#modal-delete-confirmation  data-action-target='".$ruta_delete."'> <i class='fa fa-trash'></i></button> </div>  ";
            }else{
                $detalle->estado = "<a href='#' class='btn-small btn-success btn-flat'>Finalizado</a>";
                $ruta_edit = route('admin.remision.remision.probeta.edit', [$detalle->id]);
                $ruta_delete = route('admin.remision.remision.probeta.destroy', [$detalle->id]);
                $detalle->acciones = "<div class='btn-group'><a href='".$ruta_edit."' class='btn btn-default btn-flat' > <i class='fa fa-pencil'></i></a>";
                $detalle->acciones .= "<button class='btn btn-danger btn-flat' data-toggle='modal'  data-target='#modal-delete-confirmation  data-action-target='".$ruta_delete."'> <i class='fa fa-trash'></i></button> </div>  ";
                
            }
        }
        return response()->json($detalles);

    }

    public function probetaVerDetalle(Request $request)
    {
        $fecha = Carbon::createFromFormat('d/m/Y', $request->get('fecha_buscar'));

        $remisions = Remision::with('obra')
                             ->join('remision__detalle','remision__detalle.remision_id','=','remision__remisions.id')
                             ->where('fecha_rotura',$fecha->format('Y-m-d'))
                             ->groupBy('remision__remisions.id')
                             ->orderBy('remision__remisions.fecha_remision','DESC')
                             ->get(['remision__remisions.*']);

        //dd($remisions);
                             
        return view('remision::admin.remisions.ver-detalle-probeta', compact('remisions','fecha'));
    }

    public function probetaEditarAll(Request $request)
    {
        $fecha = Carbon::createFromFormat('d/m/Y', $request->get('fecha_buscar'))->format('Y-m-d');
        $remision_detalles = RemisionDetalle::where('fecha_rotura', $fecha)->get();

        return view('remision::admin.remisions.probetaEditarAll', compact('remision_detalles'));
    }

    public function add_dots($array = [])
    {
        foreach ($array as $key => $value) 
           $array[$key] = number_format($value,2,",",".");
        return $array;
    }

    public function probetaUpdateAll(Request $requests)
    {
        $ids = $requests->get('id');
        $observacion = $requests->get('observacion');
        $tipos_roturas = $requests->get('tipo_rotura');
        $diametros = $requests->get('diametro');
        $diametros = $this->format($diametros);
        $fck = $requests->get('fck');
        $fck = $this->format($fck);
        $cargas = $requests->get('carga_aplicada');
        $cargas = $this->format($cargas);
      
        foreach ($ids as $key => $id) 
        {
            if( $cargas[$key]=='' )
                $cargas[$key]=0;
            $radio = (floatval($diametros[$key])/2);
            $area = ( pi()*$radio*$radio);
            $carga=( (floatval($cargas[$key])*1000)/9.8067 );
        
            $resistencias[$key] = floatval($area)?$carga/floatval($area):0 ;
            $resistencias[$key] = number_format((float)$resistencias[$key], 3, '.', '');
        }

        DB::beginTransaction();
        try
        {
            foreach ($ids as $key => $id) 
            {
                RemisionDetalle::where('id', $id)->update
                ([
                    'diametro' => $diametros[$key],
                    'carga_aplicada' => $cargas[$key],
                    'resistencia' => $resistencias[$key],
                    'fck' => $fck[$key],
                    'observacion' => $observacion[$key],
                    'tipo_rotura' => $tipos_roturas[$key]
                ]);
                $probeta=RemisionDetalle::where('id',$id)->get(['remision_id'])->first();
                $remision=Remision::where('id',$probeta->remision_id)->first();
                $remisionDetalles=RemisionDetalle::where('remision_id',$remision->id)->get();
                $terminado=true; 
                foreach ($remisionDetalles as $remisionDetalle) 
                    if ($remisionDetalle->resistencia=="") 
                        $terminado=false;

                if($terminado) 
                    Remision::where('id', $remision->id)->update
                    ([
                        'terminado' => true
                    ]);
            }
        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            flash()->error('Ocurrio un error al intentar actualizar los datos de las probetas');
            return redirect()->back()->withErrors($e);
        }

        DB::commit();
        flash()->success('Probetas Actualizadas Correctamente');
        $fecha_rotura=RemisionDetalle::where('id', $ids[0])->get(['fecha_rotura'])->first(); //dd($ids);
        $fecha_rotura = Carbon::createFromFormat('d/m/Y', $fecha_rotura->fecha_rotura);
        $remision_detalles = RemisionDetalle::where('fecha_rotura', $fecha_rotura->format('Y-m-d'))->get();
        $now=$fecha_rotura->format('d/m/Y');
        return view('remision::admin.remisions.probetas', compact('remision_detalles','now'));
    }

    public function createInforme(Remision $remision)
    {  
        $remision_id = Input::get('remision_id');

        $fecha_inicio = Input::get('fecha_inicio');

        $fecha_fin  = Input::get('fecha_fin');

        $fecha  = Input::get('fecha');


        if(!isset($remision_id))
        {
            $remision_id=$remision->id;

            $remision_detalles=RemisionDetalle::where('remision_id',$remision->id)->orderBy('fecha_rotura','ASC')->get();

            $fecha_inicio=$remision_detalles->first()->fecha_rotura;

            $fecha_fin=$remision_detalles->last()->fecha_rotura;

            $fecha=Carbon::now('America/Asuncion')->format('d/m/Y');

            return view('remision::admin.remisions.create-informe', compact('remision_id','remision_detalles','fecha_inicio','fecha_fin','fecha'));
        }
        else
        {
            
            $remision_detalles = RemisionDetalle::filter(Input::all())->orderBy('fecha_rotura','ASC')->paginate(30);

            $remision=Remision::where('id',$remision_id )->get()->first();
            
            $remision_id=$remision->id;

            return view('remision::admin.remisions.create-informe', compact('remision_id','remision_detalles','fecha_inicio','fecha_fin','firma','fecha'));
        }
    }

    public function printInforme(Request $request)
    {
        $firma  = Input::get('firma');

        $telefono= $request->get('telefono');

        $email= $request->get('email');

        $ruc= $request->get('ruc');

        $direccion= $request->get('direccion');

        $timbrado= $request->get('timbrado');

        $remision_id = $request->get('remision_id_hidden');

        $fecha_inicio = $request->get('fecha_inicio_hidden');

        $fecha_fin  = $request->get('fecha_fin_hidden');

        $fecha_inicio=date_create_from_format('d/m/Y', $fecha_inicio);

        $fecha_fin=date_create_from_format('d/m/Y', $fecha_fin);

        $fecha= $request->get('fecha_hidden');//dd($fecha);

        $remision=Remision::where('id',$remision_id)->first();

        setLocale(LC_ALL,'es_ES.utf8');

        //$fecha_hoy=Carbon::now('America/Asuncion');
        $fecha_hoy=Carbon::createFromFormat('d/m/Y', $fecha); 

        //dd($fecha);

        $day=strftime("%d", strtotime($fecha_hoy));
        //$month=strftime("%B", strtotime($fecha_hoy));
        //dd($day);

        $month=/*(integer)*/$fecha_hoy->format('m');

        $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        //$month=$meses[$month];



        //dd($month);
        $year=strftime("%Y", strtotime($fecha_hoy));

        $remision_detalles=RemisionDetalle::where('remision_id',$remision_id)
                                          ->where('fecha_rotura','>',$fecha_inicio->modify('-1 day'))
                                          ->where('fecha_rotura','<',$fecha_fin)
                                          ->orderBy('fecha_rotura','ASC')->get();

        //dd($obra);

        $view =  \View::make('remision::admin.remisions.printInforme', compact('remision','remision_detalles', 'telefono','email','ruc','timbrado','firma','day','month','year','direccion'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);  
    //return $view;
        return $pdf->stream('remision::admin.remisions.printInforme');            
    }

    public function reporte_remision_obra_cliente(Obras $obra, Clientes $cliente, Request $re)
    {
        $obras = Obras::select('id', "nombre", "etiqueta", "cliente_id")->orderBy('etiqueta')->get();
        $clientes = Clientes::select('id', "nombre", "razon_social")->orderBy('nombre')->get();

        if( isset($re->all()['general']) )
        {
            $fecha_desde = (new Carbon('first day of this month') )->format('d/m/Y');
            $fecha_hasta = (new Carbon('last day of this month') )->format('d/m/Y');
            return view('remision::admin.reporte-general.index', compact('obra', 'cliente', 'obras', 'clientes', "remisiones", "fecha_desde", "fecha_hasta"));
        }
        else
        {
            $remisiones = Remision::select('id', "numero_remision", "fecha_remision", "obra_id")->orderBy('fecha_remision', "DESC")->get();
            return view('remision::admin.reporte.index', compact('obra', 'cliente', 'obras', 'clientes', "remisiones"));
        }
    }
    public function reporte_remision_obra_cliente_ajax(Request $re)
    {
        //dd( $re->all() );
        if ($re->has('fecha_desde') and trim( $re->get('fecha_desde') ) != '') 
            $re['fecha_desde'] = Carbon::createFromFormat('d/m/Y', $re['fecha_desde'])->format('Y-m-d');
        else
            $re['fecha_desde'] = null;

        if ($re->has('fecha_hasta') and trim( $re->get('fecha_hasta') ) != '') 
            $re['fecha_hasta'] = Carbon::createFromFormat('d/m/Y', $re['fecha_hasta'])->format('Y-m-d');
        else
            $re['fecha_hasta'] = null;
        /*RETIRADAS*/
        $datos_probetas = array();
        $probetas_retiradas = RemisionDetalle::whereHas( "remision", function( $remision ) use ($re)
        {
            if( $re['fecha_desde'] )
                $remision->where('fecha_remision', '>=', $re['fecha_desde']);
            if( $re['fecha_hasta'] )
                $remision->where('fecha_remision', '<=', $re['fecha_hasta']);
        });
        $probetas_retiradas = $probetas_retiradas->get();
        $datos_probetas['retiradas']['chicas'] = $probetas_retiradas->where('size_clasification', 'Chica');
        $datos_probetas['retiradas']['medianas'] = $probetas_retiradas->where('size_clasification', 'Mediana');
        $datos_probetas['retiradas']['grandes'] = $probetas_retiradas->where('size_clasification', 'Grande');

        /*ENSAYADAS*/
        $probetas_ensayadas = RemisionDetalle::whereNotNull('carga_aplicada');
        if( $re['fecha_desde'] )
            $probetas_ensayadas->where('fecha_rotura', '>=', $re['fecha_desde']);
        if( $re['fecha_hasta'] )
            $probetas_ensayadas->where('fecha_rotura', '<=', $re['fecha_hasta']);
        $probetas_ensayadas = $probetas_ensayadas->get();
        $datos_probetas['ensayadas']['chicas'] = $probetas_ensayadas->where('size_clasification', 'Chica');
        $datos_probetas['ensayadas']['medianas'] = $probetas_ensayadas->where('size_clasification', 'Mediana');
        $datos_probetas['ensayadas']['grandes'] = $probetas_ensayadas->where('size_clasification', 'Grande');

        /*FACTURADAS*/
        $detalles_facturas = FacturaDetalle::whereNotNull('remision_id')
        ->whereHas( "factura", function( $factura ) use ($re)
        {
            $factura->where('anulado', false)/*->where('cobrado', true)*/;
            if( $re['fecha_desde'] )
                $factura->where('fecha', '>=', $re['fecha_desde']);
            if( $re['fecha_hasta'] )
                $factura->where('fecha', '<=', $re['fecha_hasta']);
        });
        //dd(  $detalles_facturas->where('remision_id', 48)->lists('cantidad', 'probeta_tipo') );
        $detalles_facturas = $detalles_facturas->get();
        $datos_probetas['facturadas']['chicas'] = $detalles_facturas->where('probeta_tipo', 'chica');
        $datos_probetas['facturadas']['medianas'] = $detalles_facturas->where('probeta_tipo', 'mediana');
        $datos_probetas['facturadas']['grandes'] = $detalles_facturas->where('probeta_tipo', 'grande');
        $remisiones_id = array();

        foreach ($datos_probetas as $tipo => $clasificaciones) 
            foreach ($clasificaciones as $clasificacion => $probetas ) 
                foreach ($probetas as $key => $probeta) 
                    $remisiones_id[ $probeta->remision_id ] = null;

        $remisiones_id = collect($remisiones_id)->keys()->toArray();        

        $remisiones = 
        Remision::whereIn('id', $remisiones_id)
        ->whereHas
        (
            "obra", function($obra) use ($re)
            {
                if ($re->has('obra_id') and trim( $re->get('obra_id') ) !== '' and $re->get('obra_id') != '0') 
                    $obra->where('id', $re['obra_id']);

                $obra->whereHas
                (
                    'cliente', function($cliente) use ($re)
                    {
                        if ($re->has('cliente_id') and trim( $re->get('cliente_id') ) !== '') 
                            $cliente->where('id', $re['cliente_id']);
                    }
                );
            }
        )
        ->whereHas("detalles", function( $probetas ) use ($re)
        {
        })
        ->with
        ([
            'obra' => function( $obra )
            {
                $obra->select("id", "nombre", "etiqueta", "cliente_id");
            },
            'obra.cliente' => function( $cliente )
            {
                $cliente->select("id", "razon_social");
            },
            'detalles' => function( $probetas ) use ($re)
            {
                $probetas->select("id", "numero_probeta", "fecha_moldeo", "remision_id", "fecha_rotura", "diametro", "carga_aplicada", "resistencia");
            }
            
        ]);
        $remisiones->select('id', 'numero_remision', 'fecha_remision', 'obra_id');

        $object = Datatables::of( $remisiones )
        ->addColumn('retiradas', function ($remision) use ( $datos_probetas )
        {
            $retiradas =    
            [
                'chicas' => $datos_probetas['retiradas']['chicas']->where('remision_id', $remision->id)->count(), 
                'medianas' => $datos_probetas['retiradas']['medianas']->where('remision_id', $remision->id)->count(), 
                'grandes' => $datos_probetas['retiradas']['grandes']->where('remision_id', $remision->id)->count()
            ];

            return $retiradas['chicas'] + $retiradas['medianas'] + $retiradas['grandes'];
        })
        ->addColumn('ensayadas', function ($remision) use ( $datos_probetas )
        {
            $ensayadas = 
            [
                'chicas' => $datos_probetas['ensayadas']['chicas']->where('remision_id', $remision->id)->count(), 
                'medianas' => $datos_probetas['ensayadas']['medianas']->where('remision_id', $remision->id)->count(), 
                'grandes' => $datos_probetas['ensayadas']['grandes']->where('remision_id', $remision->id)->count()
            ];

            return $ensayadas['chicas'] + $ensayadas['medianas'] + $ensayadas['grandes'];
        })
        ->addColumn('facturadas', function ($remision) use ( $datos_probetas )
        {
            $facturadas = 
            [
                'chicas' => $datos_probetas['facturadas']['chicas']->where('remision_id', $remision->id )->sum('cantidad'), 
                'medianas' => $datos_probetas['facturadas']['medianas']->where('remision_id', $remision->id )->sum('cantidad'),
                'grandes' => $datos_probetas['facturadas']['grandes']->where('remision_id', $remision->id )->sum('cantidad')
            ];

            return number_format( $facturadas['chicas'] + $facturadas['medianas'] + $facturadas['grandes'] , 2, ',', '.');
        })
        ->addColumn('datos_probetas', function ($remision) use ( $datos_probetas )
        {

            $datos = collect([ ]);
        
            $retiradas =    
            [
                'chicas' => $datos_probetas['retiradas']['chicas']->where('remision_id', $remision->id)->count(), 
                'medianas' => $datos_probetas['retiradas']['medianas']->where('remision_id', $remision->id)->count(), 
                'grandes' => $datos_probetas['retiradas']['grandes']->where('remision_id', $remision->id)->count()
            ];

            $ensayadas = 
            [
                'chicas' => $datos_probetas['ensayadas']['chicas']->where('remision_id', $remision->id)->count(), 
                'medianas' => $datos_probetas['ensayadas']['medianas']->where('remision_id', $remision->id)->count(), 
                'grandes' => $datos_probetas['ensayadas']['grandes']->where('remision_id', $remision->id)->count()
            ];

            $facturadas = 
            [
                'chicas' => $datos_probetas['facturadas']['chicas']->where('remision_id', $remision->id )->sum('cantidad'), 
                'medianas' => $datos_probetas['facturadas']['medianas']->where('remision_id', $remision->id )->sum('cantidad'),
                'grandes' => $datos_probetas['facturadas']['grandes']->where('remision_id', $remision->id )->sum('cantidad')
            ];

            $por_cobrar = 
            [
                'chicas' => $retiradas['chicas'] - $facturadas['chicas'], 
                'medianas' => $retiradas['medianas'] - $facturadas['medianas'], 
                'grandes' => $retiradas['grandes'] - $facturadas['grandes']
            ];

            $por_ensayar = 
            [
                'chicas' => $retiradas['chicas'] - $ensayadas['chicas'], 
                'medianas' => $retiradas['medianas'] - $ensayadas['medianas'], 
                'grandes' => $retiradas['grandes'] - $ensayadas['grandes']
            ];
            
            $datos->put('total_retiradas', $retiradas['chicas'] + $retiradas['medianas'] + $retiradas['grandes'] ) ;
            $datos->put('total_ensayadas', $ensayadas['chicas'] + $ensayadas['medianas'] + $ensayadas['grandes'] ) ;
            $datos->put('total_facturadas', number_format( $facturadas['chicas'] + $facturadas['medianas'] + $facturadas['grandes'] , 2, ',', '.'));
            $datos->put('total_por_cobrar', number_format( $por_cobrar['chicas'] + $por_cobrar['medianas'] + $por_cobrar['grandes'] , 2, ',', '.'));
            $datos->put('total_por_ensayar', $por_ensayar['chicas'] + $por_ensayar['medianas'] + $por_ensayar['grandes'] );


            $facturadas['chicas'] = number_format( $facturadas['chicas'] , 2, ',', '.');
            $facturadas['medianas'] = number_format( $facturadas['medianas'] , 2, ',', '.');
            $facturadas['grandes'] = number_format( $facturadas['grandes'] , 2, ',', '.');

            $datos->put('retiradas', $retiradas);
            $datos->put('ensayadas', $ensayadas);
            $datos->put('facturadas', $facturadas);
            $datos->put('por_cobrar', $por_cobrar);
            $datos->put('por_ensayar', $por_ensayar);


            return $datos->toArray();
            
        })
        ->make(true);
        $data = $object->getData(true);

        $retiradas_chicas = $datos_probetas['retiradas']['chicas']->count();
        $retiradas_medianas = $datos_probetas['retiradas']['medianas']->count();
        $retiradas_grandes = $datos_probetas['retiradas']['grandes']->count();

        $ensayadas_chicas = $datos_probetas['ensayadas']['chicas']->count();
        $ensayadas_medianas = $datos_probetas['ensayadas']['medianas']->count();
        $ensayadas_grandes = $datos_probetas['ensayadas']['grandes']->count();

        $facturadas_chicas = $datos_probetas['facturadas']['chicas']->sum('cantidad');
        $facturadas_medianas = $datos_probetas['facturadas']['medianas']->sum('cantidad');
        $facturadas_grandes = $datos_probetas['facturadas']['grandes']->sum('cantidad');

        $por_cobrar_chicas = $retiradas_chicas - $facturadas_chicas;
        $por_cobrar_medianas = $retiradas_medianas - $facturadas_medianas;
        $por_cobrar_grandes = $retiradas_grandes - $facturadas_grandes;

        $por_ensayar_chicas = $retiradas_chicas - $ensayadas_chicas;
        $por_ensayar_medianas = $retiradas_medianas - $ensayadas_medianas;
        $por_ensayar_grandes = $retiradas_grandes - $ensayadas_grandes;
/*
        $retiradas_chicas = number_format( $retiradas_chicas, 2, ',', '.');
        $retiradas_medianas = number_format( $retiradas_medianas, 2, ',', '.');
        $retiradas_grandes = number_format( $retiradas_grandes, 2, ',', '.');

        $ensayadas_chicas = number_format( $ensayadas_chicas, 2, ',', '.');
        $ensayadas_medianas = number_format( $ensayadas_medianas, 2, ',', '.');
        $ensayadas_grandes = number_format( $ensayadas_grandes, 2, ',', '.');

        $facturadas_chicas = number_format( $facturadas_chicas, 2, ',', '.');
        $facturadas_medianas = number_format( $facturadas_medianas, 2, ',', '.');
        $facturadas_grandes = number_format( $facturadas_grandes, 2, ',', '.');

        $por_cobrar_chicas = number_format( $por_cobrar_chicas, 2, ',', '.');
        $por_cobrar_medianas = number_format( $por_cobrar_medianas, 2, ',', '.');
        $por_cobrar_grandes = number_format( $por_cobrar_grandes, 2, ',', '.');

        $por_ensayar_chicas = number_format( $por_ensayar_chicas, 2, ',', '.');
        $por_ensayar_medianas = number_format( $por_ensayar_medianas, 2, ',', '.');
        $por_ensayar_grandes = number_format( $por_ensayar_grandes, 2, ',', '.');
*/

        $data['cantidades_probetas_retiradas_chicas'] = $retiradas_chicas ;
        $data['cantidades_probetas_retiradas_medianas'] = $retiradas_medianas ;
        $data['cantidades_probetas_retiradas_grandes'] = $retiradas_grandes ;

        $data['cantidades_probetas_ensayadas_chicas'] = $ensayadas_chicas ;
        $data['cantidades_probetas_ensayadas_medianas'] = $ensayadas_medianas ;
        $data['cantidades_probetas_ensayadas_grandes'] = $ensayadas_grandes ;

        $data['cantidades_probetas_facturadas_chicas'] = $facturadas_chicas ;
        $data['cantidades_probetas_facturadas_medianas'] = $facturadas_medianas ;
        $data['cantidades_probetas_facturadas_grandes'] = $facturadas_grandes ;

        $data['cantidades_probetas_por_cobrar_chicas'] = $por_cobrar_chicas ;
        $data['cantidades_probetas_por_cobrar_medianas'] = $por_cobrar_medianas ;
        $data['cantidades_probetas_por_cobrar_grandes'] = $por_cobrar_grandes ;

        $data['cantidades_probetas_por_ensayar_chicas'] = $por_ensayar_chicas ;
        $data['cantidades_probetas_por_ensayar_medianas'] = $por_ensayar_medianas ;
        $data['cantidades_probetas_por_ensayar_grandes'] = $por_ensayar_grandes ;

        return response()->json( $data );
    }

    public function get_informe_caracteristicas(Request $re)
    {

        $fecha_inicio = date_create_from_format('Y-m-d',date("Y-m-d", strtotime( str_replace('/', '-', $re->fecha_inicio_hidden) )));
        $fecha_fin = date_create_from_format('Y-m-d',date("Y-m-d", strtotime( str_replace('/', '-', $re->fecha_fin_hidden) )));
        $fecha_de_impresion = $re->fecha_hidden;
        $direccion = $re->direccion;
        $telefono = $re->telefono;
        $email = $re->email;
        $firma = $re->firma;
        $remision = Remision::with(["detalles" => function($detalles_query) use ($fecha_inicio, $fecha_fin)
                                        {
                                        $detalles_query->where('fecha_rotura','>',$fecha_inicio->modify('-1 day'))
                                                          ->where('fecha_rotura','<',$fecha_fin)
                                                          ->orderBy('fecha_rotura','ASC');
                                         } 
                                    ])->find( $re->remision_id_hidden );

        $view =  \View::make('remision::admin.reporte-caracteristicas-fisicas.reporte', compact("remision", "fecha_de_impresion", "direccion", "telefono", "email", "firma"))->render();
//return $view;
        $pdf = \App::make('dompdf.wrapper')->loadHTML($view);   
        return $pdf->stream("Informe_Caracteristicas.pdf");           
    }

    public function probetas_status()
    {
        return view('remision::admin.probetas_status.probetas_status');
    }

    public function probetas_status_ajax()
    {
        $query = RemisionDetalle::select
        (
            'id', 
            'numero_probeta', 
            'fecha_moldeo', 
            'dias', 
            'fck', 
            'remision_id', 
            'created_at', 
            'fecha_rotura', 
            'carga_aplicada', 
            'resistencia', 
            DB::raw('cast( (((carga_aplicada*1000)/9.8067)/(PI()*(diametro/2)*(diametro/2)) ) as decimal(10,3) )  as resistencia_calculada'),
            DB::raw('(cast( (((carga_aplicada*1000)/9.8067)/(PI()*(diametro/2)*(diametro/2)) ) as decimal(10,3) ) - resistencia) as diff_resistencias'),
            DB::raw("cast( ((resistencia*100)/fck) as decimal(10,2) ) as porcentaje_calculado"),
            DB::raw("( (peso/( PI() * POW( (diametro/2) , 2) * altura ))/1000 ) as peso_especifico_calculado"),
            'diametro', 
            'altura', 
            'peso'
        );
    //dd( $query );
        $object = Datatables::of( $query )
            /*
            ->addColumn('acciones', function ($tabla) 
            {
                $asEdit = "admin.remision.remision.edit";
                $editRoute = route( $asEdit, [$tabla->remision_id]);
                
                $buttons = "<div class='btn-group'>
                            <a href='". $editRoute."' class='btn btn-default btn-flat'>
                                <i class='fa fa-pencil'></i>
                            </a>
                        </div>";

                return $buttons;
            })
            */
           ->editColumn('remision_id', function($tabla) use ($query)
            {
                $asEdit = "admin.remision.remision.edit";
                $editRoute = route( $asEdit, [$tabla->remision_id]);
                return "<a href='". $editRoute."' class='btn btn-default btn-flat btn-primary' style='color:white'>" . $tabla->remision_id ."</a>";
            })
            ->editColumn('fck', function($tabla) use ($query)
            {
                return $tabla->wformat('fck', 3);
            })
            ->editColumn('carga_aplicada', function($tabla) use ($query)
            {
                return $tabla->wformat('carga_aplicada', 3);
            })
            ->editColumn('resistencia', function($tabla) use ($query)
            {
                return $tabla->wformat('resistencia', 3);
            })
            ->editColumn('diametro', function($tabla) use ($query)
            {
                return $tabla->wformat('diametro', 3);
            })
            ->editColumn('altura', function($tabla) use ($query)
            {
                return $tabla->wformat('altura', 3);
            })
            ->editColumn('peso', function($tabla) use ($query)
            {
                return $tabla->wformat('peso', 3);
            })
            ->editColumn('created_at', function($tabla) use ($query)
            {
                return $tabla->created_at->format('d/m/Y H:i:s');
            })
            ->editColumn('resistencia_calculada', function($tabla) use ($query)
            {
                return $tabla->wformat('resistencia_calculada');
            })
            ->editColumn('diff_porcentajes', function($tabla) use ($query)
            {
                $tmp = str_replace(",", ".", $tabla->porcentaje);

                return  ($tmp - $tabla->porcentaje_calculado ) . "%";
            })
            ->editColumn('porcentaje', function($tabla) use ($query)
            {
                return $tabla->porcentaje;
            })
            ->editColumn('porcentaje_calculado', function($tabla) use ($query)
            {
                return $tabla->porcentaje_calculado . " %";
            })
            ->editColumn('diff_resistencias', function($tabla) use ($query)
            {
                return $tabla->wformat('diff_resistencias');
            })
            ->editColumn('peso_especifico', function($tabla) use ($query)
            {
                return $tabla->peso_especifico;
            })
            ->editColumn('peso_especifico_calculado', function($tabla) use ($query)
            {
                return $tabla->peso_especifico_calculado;
            })
            ->editColumn('diff_pesos_especificos', function($tabla) use ($query)
            {
                return "({$tabla->peso_especifico} - {$tabla->peso_especifico_calculado})";
            })
            ->make(true);
        return $object;
    }
}
