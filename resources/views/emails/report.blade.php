@extends('beautymail::templates.ark')
@section('content')
<!--
@include('beautymail::templates.ark.heading', [
        'heading' => 'Report Campovolo Termon',
        'level' => 'h2'
    ])
-->
@include('beautymail::templates.ark.contentStart')
<h4 class="secondary">Caro socio,</h4>
        <p>in allegato trovi il resoconto della tua situazione economica.</p>
@include('beautymail::templates.ark.contentEnd')

@include('beautymail::templates.ark.contentStart')
<h4 class="secondary">Cordiali saluti,</h4>
        <p>Il direttivo ASD PUMA</p>
@include('beautymail::templates.ark.contentEnd')
@stop
