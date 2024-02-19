@extends('errors::illustrated-layout')

{{-- @section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden')) --}}

@section('title', __('Prohibido'))
@section('code', '403')
@section('message', __('El usuario no tiene los permisos correctos.'))
