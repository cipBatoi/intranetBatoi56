<?php

namespace Intranet\Http\Controllers;

use Intranet\Entities\Falta;
use Intranet\Botones\BotonImg;
use Intranet\Botones\BotonIcon;

/**
 * Class PanelFaltaController
 * @package Intranet\Http\Controllers
 */
class PanelFaltaController extends ModalController
{
    use traitPanel;

    /**
     * @var string
     */
    protected $perfil = 'profesor';
    /**
     * @var string
     */
    protected $model = 'Falta';
    /**
     * @var array
     */
    protected $gridFields = ['id', 'nombre', 'desde', 'hasta', 'motivo', 'situacion'];
    /**
     * @var bool
     */
    protected $notFollow = true;
    /**
     * @var array
     */
    protected $parametresVista = ['modal' => ['explicacion']];
    protected $formFields = [
        'idProfesor' => ['type' => 'select'],
        'estado' => ['type' => 'hidden'],
        'desde' => ['type' => 'date'],
        'hasta' => ['type' => 'date'],
        'baja' => ['type' => 'checkbox'],
        'dia_completo' => ['type' => 'checkbox'],
        'hora_ini' => ['type' => 'time'],
        'hora_fin' => ['type' => 'time'],
        'motivos' => ['type' => 'select'],
        'observaciones' => ['type' => 'text'],
        'fichero' => ['type' => 'file'],

    ];

    protected function search(){
        return(Falta::orderBy('desde')->get());
    }


    /**
     *
     */
    protected function iniBotones()
    {
        $this->panel->setBotonera(['create']);
        $this->panel->setBoton('profile', new BotonIcon("$this->model.resolve", ['class' => 'btn-success authorize', 'where' => ['estado', '>', '0', 'estado', '<', '3']], true));
        $this->panel->setBoton('profile', new BotonIcon("$this->model.refuse", ['class' => 'btn-danger refuse', 'where' => ['estado', '>', '0', 'estado', '<', '4']], true));
        $this->panel->setBoton('profile', new BotonIcon("$this->model.alta", ['class' => 'btn-success alta', 'where' => ['estado', '==', '5']], true));
        $this->panel->setBoton('grid', new BotonImg('falta.delete', ['where' => ['estado', '<', '4']]));
        $this->panel->setBoton('grid', new BotonImg('falta.edit', ['where' => ['estado', '<', '4']]));
        $this->panel->setBoton('grid', new BotonImg('falta.notification', ['where' => ['estado', '>', '0', 'hasta', 'posterior', Ayer()]]));
        $this->panel->setBothBoton('falta.document', ['where' => ['fichero', '!=', '']]);
        $this->panel->setBothBoton('falta.gestor',['img' => 'fa-eye', 'where'=>['idDocumento','!=',null]]);
        
    }
}
