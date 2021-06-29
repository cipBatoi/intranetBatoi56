@extends('layouts.pdf')
@section('css')
    {{ Html::style('/css/dual.css') }}
@endsection
@section('content')
    <div class="page">
        @include('pdf.partials.cabecera')
        <br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <p style="font-size: 20px;text-align: justify;margin-top: 75px;line-height: 1.5em">
            {{ $todos->Alumno->sexo=='H'?"L’alumne":"L'alumna" }}  <strong> {{ $todos->Alumno->FullName }}</strong>, amb DNI:  <strong>{{ $todos->Alumno->dni }}</strong><br/><br/>
            Del cicle formatiu <strong>{{ $todos->fct->Colaboracion->Ciclo->vliteral }}</strong>
        </p>
        <p style="font-size: 20px;text-align: justify;margin-top: 75px;line-height: 1.5em;text-align: justify">
            Fa constar: <br/><br/>
            Que en data {{ FechaString($datosInforme['date']) }} li ha estat lliurat el document Annex XIII,
            acreditatiu de les activitats realitzades durant la FP Dual.
        </p>
        <p style="font-size: 20px;text-align: right;margin-top: 75px">
            {{ $todos->Alumno->sexo=='H'?"L’alumne":"L'alumna" }} signa el present document expresant el seu acord amb el aquí exposat.
        </p>
        <p style="font-size: 20px;text-align: right;margin-top: 150px;">
            Signatura : {{ $todos->Alumno->FullName }}
        </p>
    </div>
    <div class="page">
        @include('pdf.partials.cabecera')
        <br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <p style="font-size: 20px;text-align: justify;margin-top: 75px;line-height: 1.5em">
            L'Empresa: {{$todos->Fct->Centro}} amb NIF: {{$todos->Fct->Colaboracion->Centro->Empresa->cif}}<br/><br/><br/>
            per mitja del seu representant  <strong>{{$todos->Fct->Colaboracion->Centro->Empresa->gerente }}</strong>.<br/><br/>
        </p>
        <p style="font-size: 20px;text-align: justify;margin-top: 75px;line-height: 1.5em;text-align: justify">
            Fa constar: <br/><br/>
            Que en data {{ FechaString($datosInforme['date']) }} li ha estat lliurat el document Annex V-a,
            acreditatiu de la seua participació en la FP Dual.
        </p>
        <p style="font-size: 20px;text-align: justify;margin-top: 75px">
            L’empresa signa i fica el seu segell en el present document expresant el seu acord amb el aquí exposat.
        </p>
        <p style="font-size: 20px;text-align: right;margin-top: 150px;">
            Signatura i segell: {{$todos->Fct->Colaboracion->Centro->Empresa->gerente }}
        </p>
    </div>
    <div class="page">
        @include('pdf.partials.cabecera')
        <br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <p style="font-size: 20px;text-align: justify;margin-top: 75px;line-height: 1.5em">
            L'instructor/a: {{$todos->Fct->Instructor->Nombre }} amb DNI: {{$todos->Fct->Instructor->dni   }}.<br/>
            De l'Empresa: {{$todos->Fct->Centro}} amb NIF: {{$todos->Fct->Colaboracion->Centro->Empresa->cif}}.<br/><br/><br/>
        </p>
        <p style="font-size: 20px;text-align: justify;margin-top: 75px;line-height: 1.5em;text-align: justify">
            Fa constar: <br/><br/>
            Que en data {{ FechaString($datosInforme['date']) }} li ha estat lliurat el document Annex V-b,
            acreditatiu de la seua participació en la FP Dual.
        </p>
        <p style="font-size: 20px;text-align: justify;margin-top: 75px">
            L’instructor signa el present document expresant el seu acord amb el aquí exposat.
        </p>
        <p style="font-size: 20px;text-align: right;margin-top: 150px;">
            Signatura i segell: {{$todos->Fct->Instructor->Nombre }}
        </p>
    </div>
@endsection