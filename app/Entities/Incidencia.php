<?php

namespace Intranet\Entities;

use Illuminate\Database\Eloquent\Model;
use Intranet\Entities\Profesor;
use Intranet\Entities\Material;
use Intranet\Entities\TipoIncidencia;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Intranet\Events\PreventAction;
use Intranet\Events\ActivityReport;
use Intranet\Events\IncidenciaSaved;

class Incidencia extends Model
{

    protected $table = 'incidencias';
    public $timestamps = false;
    protected $fillable = ['tipo','espacio', 'material', 'descripcion', 'idProfesor',  'prioridad', 'Observaciones'];
    protected $descriptionField = 'descripcion';

    use BatoiModels,
        TraitEstado;

    protected $rules = [
        'descripcion' => 'required',
        'tipo' => 'required',
        'idProfesor' => 'required',
        'prioridad' => 'required',
        'fecha' => 'date',
    ];
    protected $inputTypes = [
        'espacio' => ['type' => 'select'],
        'material' => ['type' => 'select'],
        'descripcion' => ['type' => 'textarea'],
        'idProfesor' => ['type' => 'hidden'],
        'tipo' => ['type' => 'select'],
        'prioridad' => ['type' => 'select'],
    ];
    protected $dispatchesEvents = [
        'deleting' => PreventAction::class,
        'saving' => PreventAction::class,
        'deleted' => ActivityReport::class,
        'saved' => IncidenciaSaved::class,
        'created' => ActivityReport::class,
    ];

    public function __construct()
    {
        if (AuthUser()) {
            $this->idProfesor = AuthUser()->dni;
            $this->espacio = null;
            $this->estado = 0;
            $this->fecha = new Date('now');
            $this->prioridad = 0;
            $this->tipo = 10;
        }
    }

    public function Creador()
    {
        return $this->belongsTo(Profesor::class, 'idProfesor', 'dni');
    }

    public function Responsables()
    {
        return $this->belongsTo(Profesor::class, 'responsable', 'dni');
    }

    public function Tipos()
    {
        return $this->belongsTo(TipoIncidencia::class, 'tipo');
    }

    public function Materiales()
    {
        return $this->belongsTo(Material::class, 'material');
    }

    public function Espacios()
    {
        return $this->belongsTo(Espacio::class, 'espacio');
    }

    public function getEspacioOptions()
    {
        return hazArray(Espacio::all(), 'aula', 'descripcion');
    }

    public function getTipoOptions()
    {
        return hazArray(TipoIncidencia::all(), 'id', 'nombre');
    }

    /**
    public function getResponsableOptions()
    {
        $todos = Profesor::select('dni', 'apellido1',  'nombre')
                ->whereIn('dni', config('contacto.incidencias'))
                ->get();
        $esp = array();
        foreach ($todos as $uno) {
            $esp[$uno->dni] = $uno->nombre.' '.$uno->apellido1;
        }
        return $esp;
    }
    **/

    public function getEstadoOptions()
    {
        return config('auxiliares.estadoIncidencia');
    }

    public function getPrioridadOptions()
    {
        return config('auxiliares.prioridadIncidencia');
    }

    public function getFechaAttribute($entrada)
    {
        $fecha = new Date($entrada);
        return $fecha->format('d-m-Y');
    }

    public function getFechasolucionAttribute($salida)
    {
        $fecha = new Date($salida);
        return $fecha->format('d-m-Y');
    }

    public function getXestadoAttribute()
    {
        return $this->getEstadoOptions()[$this->estado];
    }

    public function getXcreadorAttribute()
    {
        return $this->Creador->ShortName;
    }

    public function getXespacioAttribute(){
        return $this->espacio?$this->Espacios->descripcion:'';
    }

    public function getXresponsableAttribute()
    {
        return ($this->responsable == '') ? $this->responsable : $this->Responsables->ShortName;
    }

    public function getXtipoAttribute()
    {
        return $this->Tipos->literal;
    }

    public function getDesCurtaAttribute()
    {
        return substr($this->descripcion, 0, 30);
    }

    public static function putEstado($id, $estado, $mensaje = null, $fecha = null)
    {
        $elemento = static::findOrFail($id);
        if ($fecha != null) {
            if (isset($elemento->fechasolucion)) {
                $elemento->fechasolucion = $fecha;
            }
        }
        if ($elemento->estado < $estado) {
            $elemento->responsable = $estado > 1 ? AuthUser()->dni : $elemento->Tipos->idProfesor;
        } else
            $elemento->responsable = $estado > 1 ? AuthUser()->dni : '';

        if ($elemento->has('solucion') && isset($mensaje))
            $elemento->solucion .= $mensaje;
        
        $elemento->estado = $estado;
        $elemento->save();
        $elemento->informa($mensaje);
        return ($elemento->estado);
    }

}
