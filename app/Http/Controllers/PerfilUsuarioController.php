<?php

namespace App\Http\Controllers;

use App\Mail\NotasMiembro;
use App\Models\Persona;
use App\Models\ServicioInforme;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\isNull;

class PerfilUsuarioController extends Controller
{
    // QUEDA PENDIENTE DAR DE BAJA AL USUARIO ELIMINACION LOGICA
    protected $disk = 'public';

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        $usuario = auth()->user();
        $persona = Persona::join('tipo_categorias', 'tipo_categorias.id', '=', 'personas.tipocategoria_id')
            ->join('tipo_documentos', 'tipo_documentos.id', '=', 'personas.tipodocumento_id')
            ->where('personas.estado', 'A')->where("usuario_id", $usuario->id)
            ->select('personas.*', 'personas.id as persona_id', 'tipo_documentos.id as tipodocid', 'tipo_documentos.descripcion as tipodocdesc', 'tipo_documentos.abreviatura as tipodocabrev', 'tipo_categorias.descripcion as tcdescripcion', 'tipo_categorias.abreviatura as tcabreviatura')->first();
        $datosPersona = Arr::add($persona, 'correo', $usuario->email);

        $tipoDocumentos = TipoDocumento::where('estado', 'A')->get();

        $programas = DB::select("SELECT DISTINCT
                                    s.id AS servicios_id,
                                    s.tiposervicio_id,
                                    ts.descripcion || ' - ' || sts.titulo || ' - ' ||sts.subtitulo AS descripcion,
                                    per.documento,
                                    per.apepaterno || ' ' || per.apematerno || ' ' || nombres AS apeynom,
                                    ver_horarios(cast (s.id AS INTEGER)) AS horario,
                                    ver_horarios_ins(cast (s.id AS INTEGER),cast (ins.persona_id AS INTEGER)) AS horario_inscripcion,
                                    lc.costohora AS pago,
                                    ins.estado AS estado_inscripcion,
                                    pag.estadopago AS estado_pago,
                                    pag.fechapago
                                FROM servicios s
                                LEFT JOIN tipo_servicios ts ON s.tiposervicio_id = ts.id
                                LEFT JOIN subtipo_servicios sts ON s.subtiposervicio_id = sts.id
                                LEFT JOIN sedes sed ON s.sede_id = sed.id
                                LEFT JOIN lugars l ON s.lugar_id = l.id
                                LEFT JOIN lugar_costos lc ON lc.lugars_id = l.id AND lc.descripcion = s.turno
                                LEFT JOIN servicio_plantillas  sp ON s.id = sp.servicio_id
                                LEFT JOIN servicio_inscripcions ins ON s.id = ins.servicio_id
                                LEFT JOIN servicio_reservas sr ON ins.id = sr.servicioinscripcion_id
                                LEFT JOIN personas per ON ins.persona_id = per.id
                                LEFT JOIN servicio_pagos pag ON ins.id = pag.servicioinscripcion_id
                                WHERE ins.persona_id = ? ", [$datosPersona["persona_id"]]);

        $notasPrivadas = ServicioInforme::where("privado",true)->where('persona_id',auth()->user()->id)->orderBy('id','ASC')->get();

        return view("pages.public.users.userprofile.index", compact("datosPersona", 'tipoDocumentos', 'programas','notasPrivadas'));
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|max:2048'
        ], [
            'imagen.required' => 'Debes seleccionar una foto para actualizar tu perfil',
            'imagen.max' => 'La imagen seleccionada es demasiado pesada, te sugerimos seleccionar una imagen menor o igual a 2mb',
        ]);

        $persona = Persona::find($request->idpersona);

        if ($persona->directorio != null) {
            $dirName = $persona->directorio;
        } else {
            $dirName = Str::random(20);
        }

        if ($imagen = $request->file('imagen')) {
            if (\File::exists(public_path('/storage/avatars/' . $dirName . '/' . $persona->imagen))) {
                \File::delete(public_path('/storage/avatars/' . $dirName . '/' . $persona->imagen));
            }
            $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $persona['imagen'] = "$imgRename";
            // $imagen->storeAs('/sedes/', $imgRename, $this->disk);
            $imagen->storeAs('/avatars/' . $dirName . '/', $imgRename, $this->disk);
        }

        $persona->directorio = $dirName;
        $persona->update();

        return redirect()->back()->with('success', 'Foto Actualizado Exitosamente!');
    }

    public function removeImage(Request $request)
    {
        $persona = Persona::find($request->foto);
        if (\File::exists(public_path('/storage/avatars/' . $persona->directorio . '/' . $persona->imagen))) {
            \File::delete(public_path('/storage/avatars/' . $persona->directorio . '/' . $persona->imagen));
        }
        $persona->imagen = null;

        $persona->save();

        return redirect()->back()->with('success', 'Tu foto de perfil fue eliminado');
    }
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'nombres' => 'required|max:50',
            'apepaterno' => 'required|max:50',
            'apematerno' => 'required|max:50',
            'correo' => 'required',
            'tipo_documento' => 'required',
            'documento' => 'required|max:12',
            'movil' => 'required|max:15',
            'password' => 'same:password_confirmation',
        ], [
            'nombres.required' => 'No debes dejar en blando el nombre',
            'nombres.max' => 'El nombre solo permite 50 caracteres como máximo',
            'apepaterno.required' => 'No debes dejar en blanco el apellido parterno',
            'apepaterno.max' => 'El apellido paterno solo permite 50 caracteres como máximo',
            'apematerno.required' => 'No debes dejar en blanco el apellido marterno',
            'apematerno.max' => 'El apellido materno solo permite 50 caracteres como máximo',
            'correo.required' => 'No debes dejar en blanco el correo',
            'tipo_documento.required' => 'Debes seleccionar un tipo de documento',
            'documento' => 'No debes dejar en blanco el número de documento',
            'documento.max' => 'El documento solo permite 12 caracteres como máximo',
            'movil' => 'No debes dejar en blanco el número de movil',
            'movil.max' => 'Solo se permite 15 caracteres como máximo para el campo movil',
            'password.same' => 'Las contraseñas ingresadas no coinciden',
        ]);

        $persona = Persona::where('id', $id)->get();
        $usuario = User::where('id', $persona[0]->usuario_id)->get();
        $nombrePersona = $persona[0]->nombres . ' ' . $persona[0]->apepaterno . ' ' . $persona[0]->apematerno;
        if (!empty($request->password)) {
            $newpass = Hash::make($request->password);
        } else {
            $newpass = $usuario[0]->password;
        }
        $usuario[0]->email = $request->correo;
        $usuario[0]->password = $newpass;
        $persona[0]->tipodocumento_id = $request->tipo_documento;
        $persona[0]->documento = $request->documento;
        $persona[0]->apepaterno = Str::upper($request->apepaterno);
        $persona[0]->apematerno = Str::upper($request->apematerno);
        $persona[0]->nombres = Str::upper($request->nombres);
        $persona[0]->movil = $request->movil;
        $persona[0]->usuario_creador = Str::upper($nombrePersona);
        $persona[0]->usuario_editor = Str::upper($nombrePersona);
        $persona[0]->ip_usuario = request()->ip();

        $usuario[0]->save();
        $persona[0]->save();

        return redirect()->back()->with('success', 'Datos actualizados exitosamente!');
    }

    public function destroy($id)
    {
        //
    }

    public function sendNote(Request $request){
        $usuario = Persona::where('usuario_id', Auth::user()->id)->get();
        $nombre_usuario = "{$usuario[0]->nombres} {$usuario[0]->apepaterno} {$usuario[0]->apematerno}";
        $nota = new ServicioInforme();
        $nota->servicioinscripcion_id = $request->servinscid;
        $nota->detalle = $request->nota;
        $nota->adjuntto = $request->enlace;
        $nota->estado = 'A';
        $nota->usuario_creador = $nombre_usuario;
        $nota->ip_usuario = $request->ip();
        $nota->privado = true;
        $nota->persona_id = Auth::user()->id;
        $nota->save();

        // $resultNota = DB::select("SELECT si.* ,p.nombres ,p.apepaterno ,p.apematerno , p.usuario_id
        //                             FROM servicio_informes si
        //                             LEFT JOIN servicio_inscripcions si2
        //                             ON si.servicioinscripcion_id = si2.id
        //                             LEFT JOIN personas p
        //                             ON si2.persona_id = p.id
        //                             WHERE si.id = ?",[$nota->id]);

        // $correo = User::where('id',$resultNota[0]->usuario_id)->select('email')->get()[0]->email;

        // Mail::to($correo)->send(new NotasMiembro($resultNota[0]));

        return redirect()->route('prfole.user');
    }
}
