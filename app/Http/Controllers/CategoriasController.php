<?php

namespace App\Http\Controllers;

use App\Models\CategoriaNoticia;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoriasController extends Controller
{
    public function index()
    {
        return view("pages.private.categorias.index");
    }

    public function tableCategories()
    {
        $tableCategories = CategoriaNoticia::all();
        return datatables()->of($tableCategories)
            ->addColumn('acciones',function ($row){
                    return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="/admin/lugares/editar/'.$row['id'].'" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Editar</a>
                                <button class="dropdown-item delete" onclick="deleteCategory('.$row['id'].')"><i class="bx bx-trash me-1"></i> Eliminar</button>
                            </div>
                        </div>';
            })
            ->addColumn('estado',function ($row){
                if($row['estado'] == "A")
                {
                    return '
                    <button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" onclick="changeState('.$row['id'].')"><span class="badge bg-label-success me-1">PUBLICADO</span></button>';
                }else{
                    return '
                    <button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" onclick="changeState('.$row['id'].')"><span class="badge bg-label-danger me-1">BORRADOR</span></button>';
                }
            })
            ->rawColumns(['estado','acciones'])
            ->make(true);
    }


    public function create()
    {
        return view('pages.private.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required','max:100',
            'slug'=>'required','max:150',
            'estado'=>'required',
        ],[
            'nombre.required'=>'El campo nombre es obligatorio',
            'nombre.max'=>'El máximo de longitud para este campo es 100 caracteres',
            'slug.required'=>'El campo slug es obligatorio',
            'slug.max'=>'El máximo de longitud para este campo es 150 caracteres',
            'estado.required' => 'El campo Estado es obligatorio',
        ]);

        $categoria = new CategoriaNoticia();
        $categoria->nombre = Str::upper($request->get('nombre'));
        $categoria->slug = $request->get('slug');
        if($request->estado == 'off'){
            $categoria->estado = 'I';
        }
        $categoria->save();

        return redirect()->route('categorias.index');
    }

    public function changeState(Request $request)
    {
        $categoria = CategoriaNoticia::find($request->id);
        if ($categoria->estado == "I") {
            $categoria->estado = "A";
            $nombreCategoria = $categoria->descripcion;
            $categoria->save();
            return back()->with(["success" => "La sede $nombreCategoria fue ACTIVADA"]);
        }
        if ($categoria->estado  == "A") {
            $categoria->estado  = "I";
            $nombreCategoria = $categoria->descripcion;
            $categoria->save();
            return back()->with(["success" => "La sede $nombreCategoria fue DESACTIVADA"]);
        }
    }

    public function search(Request $request){

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
