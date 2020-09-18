<?php namespace Modules\Clientes\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Clientes\Entities\Clientes;
use Modules\Clientes\Repositories\ClientesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Clientes\Http\Requests\ClienteRequest;
use Yajra\Datatables\Facades\Datatables;
use Response;
class ClientesController extends AdminBaseController
{
    /**
     * @var ClientesRepository
     */
    private $clientes;

    public function __construct(ClientesRepository $clientes)
    {
        parent::__construct();

        $this->clientes = $clientes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $clientes = $this->clientes->all();

        return view('clientes::admin.clientes.index', compact('clientes'));
    }

    public function indexAjax()
    {
        $query = Clientes::orderBy('nombre')
                ->select(['nombre', 'ruc', 'telefono', 'direccion', 'contacto','id']);

        $object = Datatables::of( $query )
            ->addColumn('acciones', function ($tabla) 
                {
                    $asEdit = "admin.clientes.clientes.edit";

                    $asDestroy = "admin.clientes.clientes.destroy";

                    $reporte_route = route('admin.remision.remision.reporte_remision_obra_cliente', ['obra' => 0, 'cliente' => $tabla->id] );

                    $editRoute = route( $asEdit, [$tabla->id]);

                    $deleteRoute = route( $asDestroy, [$tabla->id]);
 
                    $buttons="<div class='btn-group'>
                                <a class='btn btn-primary btn-flat' href=".$reporte_route.">
                                    <strong>REPORTE</strong>
                                    </a>
                                <a href='".$editRoute." ' class='btn btn-default btn-flat'>
                                    <i class='fa fa-pencil'></i>
                                </a>
                                <button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='".$deleteRoute."'>
                                    <i class='fa fa-trash'></i>
                                </button>

                            </div>";

                    return $buttons;
                })
            ->make();

        //dd( $object );

        return $object;
    }
    /**
     * search list of client
     *
     * @return Response json
     */
    public function search_cliente( Request $request )
    {
        $results = [ 'id' => '', 'value' => '', 'ruc' => '', 'direccion' => '', 'telefono' => ''];

        if ($request->has('term')  && trim($request->get('term')) !== '' ) 
        {
            $clientes = Clientes::where('razon_social', 'like', "%{$request->get('term')}%")
                                 ->orWhere('nombre', 'like', "%{$request->get('term')}%")
                                ->take(7)
                                ->select('id', 'razon_social as value', 'ruc', 'direccion', 'telefono')
                                ->get()
                                ->toArray();
        }
        return Response::json( $clientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('clientes::admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClienteRequest $request
     * @return Response
     */
    public function store(ClienteRequest $request)
    {
        $this->clientes->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('clientes::clientes.title.clientes')]));

        return redirect()->route('admin.clientes.clientes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Clientes $clientes
     * @return Response
     */
    public function edit(Clientes $clientes)
    {
        return view('clientes::admin.clientes.edit', compact('clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Clientes $clientes
     * @param  Request $request
     * @return Response
     */
    public function update(Clientes $clientes, Request $request)
    {
        $this->clientes->update($clientes, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('clientes::clientes.title.clientes')]));

        return redirect()->route('admin.clientes.clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Clientes $clientes
     * @return Response
     */
    public function destroy(Clientes $clientes)
    {
        try 
        {
             $this->clientes->destroy($clientes);

            flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('clientes::clientes.title.clientes')]));

        } 
        catch(\Illuminate\Database\QueryException $e)
        {
            flash()->error('Error al eliminar al cliente, posiblemente ya tiene datos asignados.', ['name' => trans('clientes::clientes.title.clientes')]);
        }

        return redirect()->route('admin.clientes.clientes.index');
    }
}
