@extends('layouts.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">
                @include('top_bar')

                {{-- label e cancelar --}}
                <div class="row">
                    <div class="col">
                        <p class="display-6 mb-0">EDITAR VAGA</p>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('home') }}" class="btn btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path
                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- form -->
                <form action="{{ route('editVagaSubmit') }}" method="post" novalidate>
                    @csrf
                    <input type="hidden" name="vaga_id" value="{{ Crypt::encrypt($vaga->id) }}">
                    <div class="row mt-3">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Título da Vaga</label>
                                <input type="text" class="form-control" name="text_title"
                                    value="{{ old('text_title', $vaga->title) }}" required>
                                {{-- mostrar erro --}}
                                @error('text_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descrição da vaga</label>
                                <textarea class="form-control" name="text_vaga" rows="5" required>{{ old('text_vaga', $vaga->text) }}</textarea>
                                {{-- mostrar erro --}}
                                @error('text_vaga')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="select_regime" class="form-label">Regime de contratação</label>
                                <select class="form-select" aria-label="Regime de contratação" name="select_regime"
                                    id="select_regime" required>
                                    <option value="clt">CLT</option>
                                    <option value="pj">PJ</option>
                                    <option value="freelancer">Freelancer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col text-end">
                            <a href="{{ route('home') }}" class="btn btn-primary px-5"><i
                                    class="fa-solid fa-ban me-2"></i>Cancelar</a>
                            <button type="submit" class="btn btn-secondary px-5"><i
                                    class="fa-regular fa-circle-check me-2"></i>Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
