@extends('layouts.pdf')
@section('content')
@include('pdf.partials.cabecera')
<br/>
<table class="table table-bordered">
    <tr>
        <th>Acta d'elecció de delegats</th>
    </tr>
</table>

<div class="container col-lg-12" >
   <br/> 
   <div style="width:55%;float:left"><strong>Tutor:</strong> {{$datosInforme->Responsable->nombre}} {{$datosInforme->Responsable->apellido1}}  {{$datosInforme->Responsable->apellido2}}</div><div style="width:45%;float:right;text-align: right"><strong>Grup:</strong> {{$datosInforme->Xgrupo}}</div>
   <br/>
   <div style="width:55%;float:left"><strong>Curs:</strong> {{$datosInforme->curso}}</div><div style="width:45%;float:right;text-align: right"><strong>{{$todos[0]->descripcion}}:</strong> {{ $todos[0]->resumen }} <strong>{{$todos[1]->descripcion}}:</strong> {{ $todos[1]->resumen }}</div>
    <br/>
</div>
<div class="container" >
    @if (isset($todos[2]))<br/> {{$todos[2]->descripcion}}: <br/>
    <pre>@php echo($todos[2]->resumen) @endphp</pre> @endif
    @if (isset($todos[3]))<br/>{{$todos[3]->descripcion}}:<br/>
    <pre>@php echo($todos[3]->resumen) @endphp</pre> @endif
    @if (isset($todos[4]))<br/>{{$todos[4]->descripcion}}: {{strip_tags($todos[4]->resumen)}}@endif
    @if (isset($todos[5]))<br/>{{$todos[5]->descripcion}}: {{strip_tags($todos[5]->resumen)}}@endif
    @if (isset($todos[6]))<br/>{{$todos[6]->descripcion}}: {{strip_tags($todos[6]->resumen)}}@endif
    @if (isset($todos[7]))<br/>{{$todos[7]->descripcion}}: {{strip_tags($todos[7]->resumen)}}@endif
</div>
<div class="container">
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <div style="width:55%;float:left">SIGNAT:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        TUTOR/A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        VOCAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        SECRETARI/A</div>
    <div style="width:45%;float:right;text-align: right">{{strtoupper(config('contacto.poblacion'))}} A {{$datosInforme->hoy}}</div>
</div>
@include('pdf.partials.pie',['document'=>'actaDelegat'])
@endsection
