<?php namespace Modules\Factura\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Factura\Entities\Factura;
use Modules\Factura\Entities\FacturaDetalle;
use Modules\Factura\Entities\Config;
use Modules\Remision\Entities\Remision;
use Modules\Remision\Entities\RemisionDetalle;
use Modules\Factura\Repositories\FacturaRepository;
use Modules\Factura\Http\Requests\FacturaRequest;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Support\Facades\Validator;
use DB;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;
use Input;
use Modules\Obras\Entities\Obras;
use Modules\Clientes\Entities\Clientes;
use Excel;

class FacturaController extends AdminBaseController
{
    /**
     * @var FacturaRepository
     */
    private $factura;

    private $cantidad_detalles;

    public function __construct(FacturaRepository $factura)
    {
        parent::__construct();

        $this->factura = $factura;
        $this->cantidad_detalles = 8;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $facturas = Factura::orderBy('fecha','ASC')->get();

        if($facturas->first())
            $fecha_inicio = $facturas->first()->fecha;
        else
            $fecha_inicio = '';

        if($facturas->last())
            $fecha_fin=$facturas->last()->fecha;
        else
            $fecha_fin = '';

        return view('factura::admin.facturas.index', compact('fecha_inicio','fecha_fin') ); 
    }

    function query_factura_index($request)
    {
        $query = Factura::select();

        if ($request->has('fecha_inicio') && trim($request->get('fecha_inicio') !== '') ) 
            $query->where('fecha', '>', date_create_from_format('Y-m-d', $request->get('fecha_inicio'))->modify('-1 day') );

        if ($request->has('fecha_fin') && trim($request->get('fecha_fin') !== '') ) 
            $query->where('fecha', '<', date_create_from_format('Y-m-d', $request->get('fecha_fin')) );

        if ($request->has('razon_social')  && trim($request->get('razon_social') !== '') ) 
            $query->where('razon_social', 'like', "%{$request->get('razon_social')}%");

        if ($request->has('anulado')  && trim($request->get('anulado') !== '') ) 
            $query->where('anulado',(int)$request->get('anulado'));

        if ($request->has('cobrado')  && trim($request->get('cobrado') !== '') ) 
            $query->where('cobrado',(int)$request->get('cobrado'));

        return $query;
    }

    function date_unformat($date)
    {
        return date("Y-m-d", strtotime( str_replace('/', '-', $date)));
    }

    function date_format($date)
    {
        return date("d/m/Y", strtotime($date));
    }
    

    function procesa_request($request)
    {
        if ($request->has('fecha_inicio') && trim($request->has('fecha_inicio') !== '') ) 
            $request['fecha_inicio'] = $this->date_unformat($request['fecha_inicio']);

        if ($request->has('fecha_fin') && trim($request->has('fecha_fin') !== '') ) 
            $request['fecha_fin'] = $this->date_unformat($request['fecha_fin']);

        return $request;
    }

    public function index_excel(Request $re)
    {
        $re['fecha_inicio'] = $re['fecha_inicio_excel'];
        $re['fecha_fin'] = $re['fecha_fin_excel'];
        $re['razon_social'] = $re['razon_social_excel'];
        $re['anulado'] = $re['anulado_excel'];
        $re['cobrado'] = $re['cobrado_excel'];

        $re = $this->procesa_request($re);
        $facturas = $this->query_factura_index($re)
                    ->select(['id','fecha', 'razon_social', 'nro_factura', 'cobrado', 'anulado', 'monto_total'])
                    ->get();

        \Excel::create('Reporte_Facturas_' . date("Y_m_d"), function($excel) use ($facturas, $re)
        {
            $excel->sheet('Reporte_Facturas', function($sheet) use ($facturas, $re)
            {
                if ($re->has('fecha_inicio') && trim($re->get('fecha_inicio') !== '') ) 
                    $fecha_inicio = $this->date_format($re->fecha_inicio);
                else
                    $fecha_inicio = '';

                if ($re->has('fecha_fin') && trim($re->get('fecha_fin') !== '') ) 
                    $fecha_fin = $this->date_format($re->fecha_fin);
                else
                    $fecha_fin = '';

                $fecha_de_documento = date("d/m/Y");
            
                $sheet->loadView( 'factura::admin.reporte.facturas-excel', compact('facturas', 'fecha_de_documento', 'fecha_inicio', 'fecha_fin') );
            });
        })->export('xls');
    }

    public function indexAjax(Request $request)
    {
        $request = $this->procesa_request($request);
        $query = $this->query_factura_index($request);
        $query->select(['id','fecha', 'razon_social', 'nro_factura', 'cobrado', 'anulado', 'monto_total']);

        $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) 
            {
                $asEdit = "admin.factura.factura.edit";

                $asDestroy = "admin.factura.factura.destroy";

                $asPdf = "admin.factura.factura.invoice";

                $editRoute = route( $asEdit, [$tabla->id]);

                $deleteRoute = route( $asDestroy, [$tabla->id]);

                $pdfRoute = route( $asPdf, [$tabla->id]);

                $buttons="
                <!--
                    <a class='btn btn-default btn-flat' id='noWhite' href='".$pdfRoute."'>
                     <i>PDF</i>
                    </a>
                -->
                <div class='btn-group'>
                            <a href='".$editRoute." ' class='btn btn-default btn-flat'>
                                <b> DETALLES </b>
                            </a>
                            <!--
                            <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='".$deleteRoute."'>
                                <i class='fa fa-trash'></i>
                            </button>
                            -->
                        </div>";

                return $buttons;
            })
            ->editColumn('cobrado', function ($tabla) 
            {
                if($tabla->cobrado)
                    return 'SI';
                else
                    return 'NO';  
            })
            ->editColumn('monto_total', function ($tabla) 
            {
                $monto_total = $tabla->monto_total;

                $monto_total=number_format($monto_total, 1, ',', '.') ;

                return $monto_total; 
            })
            ->editColumn('anulado', function ($tabla) 
            {
                if($tabla->anulado)
                    return 'SI';
                else
                    return 'NO';   
            })
            ->addColumn('monto_total_2', function ($tabla) 
             {
                return $tabla->monto_total;
            }) 
            ->make(true);
        return $object;
    }


    /**
     * @param $remision_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $nro_factura = [];
        if(!Config::first())
        {
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
        };
        $timbrado = Config::where('identificador', 'timbrado')->first();
        $nro_factura[0] = Config::where('identificador', 'nro_factura_1')->first();
        $nro_factura[1] = Config::where('identificador', 'nro_factura_2')->first();
        $nro_factura[2] = Config::where('identificador', 'nro_factura_3')->first();
        $factura = new Factura;
        $factura->fecha = date("Y-m-d");
        $factura->nro_factura = ($nro_factura[0]->valor . '-'. $nro_factura[1]->valor . '-'. $nro_factura[2]->valor);
        $detalles[] = new FacturaDetalle;

        $remisiones = Remision::where('terminado', false)->get();
        return view('factura::admin.facturas.create', compact('remisiones', 'hoy', 'nro_factura', 'timbrado', 'factura', 'detalles'));

        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    
    public function store(Request $re)
    {  
        DB::beginTransaction();
        try
        {
            $new_factura = new Factura;
            $new_factura->fill( $re->cabecera );
            $new_factura->unformat_attributes();
            //dd($new_factura);
            $new_factura->save();
            foreach ($re->detalles as $key => $detalle) 
            {
                $detalle['factura_id'] = $new_factura->id;
                $detalle['precio'] = $detalle['precio_unitario'];
                $new_detalle_factura = new FacturaDetalle;
                $new_detalle_factura->fill( $detalle );
                $new_detalle_factura->unformat_attributes();

                if( !$new_detalle_factura->remision_id )
                    $new_detalle_factura->probeta_tipo = null;
                
                $new_detalle_factura->save();
                $new_detalles[] = $new_detalle_factura;
            }
            Config::where('identificador', 'nro_factura_3')->increment('valor');
        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            flash()->error("Ocurrio un error al crear la factura ");
            return redirect()->back()->withErrors($e);
        }
        DB::commit();
        flash()->success("Factura creada correctamente");
        return redirect()->route('admin.factura.factura.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param $remision_id
     * @return Response
     */
    public function edit(Factura $factura)
    {   
        $detalles = $factura->detalles;
        foreach ($detalles as $key => $detalle)
            $detalles[ $key ] = $detalle->format_attributes();
        return view('factura::admin.facturas.show', compact('factura', 'detalles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Factura $factura
     * @param  Request $request
     * @return Response
     */
    public function update_from_show(Factura $factura, Request $re)
    {
        $new_factura = new Factura;
        $new_factura->fill( $re->cabecera );
        $factura->update( $new_factura->toArray() );
        flash()->success("Factura Actualizada Correctamente");
        return redirect()->route('admin.factura.factura.index');
    }
    public function update(Factura $factura, Request $re)
    {
        DB::beginTransaction();
        try
        {
            $new_factura = new Factura;
            $new_factura->fill( $re->cabecera );
            $new_factura->unformat_attributes();
            $factura->update( $new_factura->toArray() );
            $factura->save();
            foreach ($re->detalles as $key => $detalle) 
            {
                $detalle['factura_id'] = $factura->id;
                $detalle['precio'] = $detalle['precio_unitario'];
                $new_detalle_factura = new FacturaDetalle;
                $new_detalle_factura->fill( $detalle );
                $new_detalle_factura->unformat_attributes();
                if( $new_detalle_factura->id )
                    if( (int)$detalle['eliminar'] )
                        FacturaDetalle::where('id', $new_detalle_factura->id)->delete( );  
                    else
                        FacturaDetalle::where('id', $new_detalle_factura->id)->update( $new_detalle_factura->toArray() );  
                else
                    $new_detalle_factura->save();
                $new_detalles[] = $new_detalle_factura;
            }
        }
        catch (ValidationException $e)
        {
            DB::rollBack();
            flash()->error("Ocurrio un error al actualizar la factura ");
            return redirect()->back()->withErrors($e);
        }
        DB::commit();

        flash()->success("Factura Actualizada Correctamente");

        return redirect()->route('admin.factura.factura.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Factura $factura
     * @return Response
     */
    public function destroy(Factura $factura)
    {
        $this->factura->destroy($factura);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('factura::facturas.title.facturas')]));

        return redirect()->route('admin.factura.factura.index');
    }

    public function printFactura(Factura $factura)
    {
        $bootstrap_path = public_path().'/themes/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css';

        $hoy = Carbon::now()->format('d/m/Y');

        $remision = Remision::where('id', $factura->remision_id)->first();

        $obra = Obras::where('id', $remision->obra_id)->first();

        $cliente = Clientes::where('id', $obra->cliente_id)->first();

        //dd($cliente);

        $detalleFacturas=FacturaDetalle::where('factura_id',$factura->id)->get();  

        $view =  \View::make('factura::admin.facturas.printFactura', compact('factura', 'detalleFacturas','bootstrap_path','hoy','cliente'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        //$pdf->setPaper('legal');
        $pdf->setPaper( array(0,0,595,1082) );


        return $pdf->stream('admin.factura.factura.invoice');//admin.factura.factura.index               
    }

    public function editNroFactura()
    {
        $NroFacturas=Config::get();
        //dd($NroFacturas);

        return view('factura::admin.facturas.editNroFactura', compact('NroFacturas'));
    }

    public function updateNroFactura(Request $request)
    {
        //dd($request->except('_token'));

        $valores=$request->get('valor');

        $etiquetas=$request->get('etiqueta');

        //dd($request->except('_token'));


        $validator = Validator::make($request->all(), $this->rulesNroFactura($request), $this->messagesNroFactura($request));

        if ($validator->fails()) 
        {
            //dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            foreach ($etiquetas as $key => $etiqueta) 
            {
                DB::table('config_factura')
                ->where('identificador',$etiqueta)
                ->update(['valor' => $valores[$key]]);
            }
        }
        
        

        
        $facturas = Factura::orderBy('fecha','ASC')->get();

        $cliente='';

        $fecha_inicio=$facturas->first()->fecha;

        $fecha_fin=$facturas->last()->fecha;

        //dd($fecha_inicio);

        return view('factura::admin.facturas.index', compact('facturas','cliente','fecha_inicio','fecha_fin'));     
    }

    public function rulesNroFactura($request)
    {

        foreach($request->get('valor') as $key => $val)
        {
            $rules['valor.'.$key] = 'required';
        }

        return $rules;
    }

    public function messagesNroFactura($request)
    {

        foreach($request->get('valor') as $key => $val)
        {
            $messages['valor.'.$key.'.required'] = 'El Valor es requerido';
        }

        return $messages;
    }


}

