@extends('layout')
<x-guest-layout>
    @section('conteudo')
        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <x-label for="name" value="{{ __('Name') }}" style="color: white"/>
                <x-input id="name" class="block mt-1 w-60 md:w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mb-4">
                <x-label for="cpf" value="{{ __('CPF') }}" style="color: white"/>
                <x-input id="cpf" class="block mt-1 w-60 md:w-full" type="text" name="cpf" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mb-4">
                <x-label for="email" value="{{ __('Email') }}" style="color: white"/>
                <x-input id="email" class="block mt-1 w-60 md:w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mb-4">
                <x-label for="password" value="{{ __('Senha') }}" style="color: white"/>
                <x-input id="password" class="block mt-1 w-60 md:w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mb-4">
                <x-label for="password_confirmation" value="{{ __('Confirme senha') }}" style="color: white"/>
                <x-input id="password_confirmation" class="block mt-1 w-60 md:w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <!-- Restante do formulário -->

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    @endsection

</x-guest-layout>
