@extends('errors.layout')

@section('errorCode', '401')
@section('errorTitle', __('errors.401_title'))
@section('errorMessage', __('errors.401_message'))
@section('errorBtnHome', true)
