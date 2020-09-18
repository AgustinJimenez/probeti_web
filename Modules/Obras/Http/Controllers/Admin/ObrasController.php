<?php namespace Modules\Obras\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Obras\Entities\Obras;
use Modules\Clientes\Entities\Clientes;
use Modules\Obras\Repositories\ObrasRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Obras\Http\Requests\ObraRequest;

class ObrasController extends AdminBaseController
{
    /**
     * @var ObrasRepository
     */
    private $obras;

    public function __construct(ObrasRepository $obras)
    {
        parent::__construct();

        $this->obras = $obras;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $obras = Obras::orderBy('created_at','DESC')->get();

        return view('obras::admin.obras.index', compact('obras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $clientes = Clientes::lists('nombre', 'id')->toArray();

        return view('obras::admin.obras.create', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(ObraRequest $request)
    {
        $this->obras->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('obras::obras.title.obras')]));

        return redirect()->route('admin.obras.obras.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Obras $obras
     * @return Response
     */
    public function edit(Obras $obras)
    {
        $clientes = Clientes::lists('nombre', 'id')->all();

        return view('obras::admin.obras.edit', compact('obras','clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Obras $obras
     * @param  Request $request
     * @return Response
     */
    public function update(Obras $obras, ObraRequest $request)
    {
        $this->obras->update($obras, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('obras::obras.title.obras')]));

        return redirect()->route('admin.obras.obras.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Obras $obras
     * @return Response
     */
    public function destroy(Obras $obras)
    {
        try 
        {
            $this->obras->destroy($obras);

            flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('obras::obras.title.obras')]));

        } 
        catch(\Illuminate\Database\QueryException $e)
        {
            flash()->error('Error al eliminar la obra, posiblemente ya tiene datos asignados.', ['name' => trans('obras::obras.title.obras')]);
        }
        return redirect()->route('admin.obras.obras.index');
    }
}
